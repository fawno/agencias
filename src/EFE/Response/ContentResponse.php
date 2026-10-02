<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Response;

	use Fawno\Agencias\EFE\ContentParameters;
	use Fawno\Agencias\EFE\DataItems;
	use Fawno\Agencias\EFE\Exception\EFEException;
	use Fawno\Agencias\EFE\HttpResponse;
	use SimpleXMLElement;
	use stdClass;

	class ContentResponse {
		final private function __construct (
			public readonly HttpResponse $httpResponse,
			public readonly ContentParameters $parameters,
			public readonly DataItems $data,
		) {
		}

		public static function fromJson (string $json) : ContentResponse {
			if (!json_validate($json)) {
				throw new EFEException('Invalid JSON payload provided.');
			}

			return static::fromObject(json_decode($json));
		}

		public static function fromXML (string $xml) : ContentResponse {
			if (false === $xml = simplexml_load_string($xml)) {
				throw new EFEException('Invalid XML payload provided.');
			}

			$httpResponseData = $xml->HttpResponse ?? null;
			$parametersData = $xml->Parameters ?? null;
			$dataItemsData = $xml->Data ?? null;

			if (!($httpResponseData instanceof SimpleXMLElement) or !($parametersData instanceof SimpleXMLElement) or !($dataItemsData instanceof SimpleXMLElement)) {
				throw new EFEException('Missing core structural properties in XML payload.');
			}

			return new static(
				HttpResponse::fromXML($httpResponseData),
				ContentParameters::fromXML($parametersData),
				DataItems::fromXML($dataItemsData),
			);
		}

		public static function fromObject (stdClass $object) : ContentResponse {
			$httpResponseData = $object->httpResponse ?? null;
			$parametersData = $object->parameters ?? null;
			$dataItemsData = $object->data ?? null;

			if (!($httpResponseData instanceof stdClass) or !($parametersData instanceof stdClass) or !($dataItemsData instanceof stdClass)) {
				throw new EFEException('Missing core structural properties in stdClass payload.');
			}

			return new static(
				HttpResponse::fromObject($httpResponseData),
				ContentParameters::fromObject($parametersData),
				DataItems::fromObject($dataItemsData),
			);
		}
	}
