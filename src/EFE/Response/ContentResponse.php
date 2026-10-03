<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Response;

	use Fawno\Agencias\EFE\ContentParameters;
	use Fawno\Agencias\EFE\DataItems;
	use Fawno\Agencias\EFE\Exception\EFEException;
	use Fawno\Agencias\EFE\HttpResponse;
	use SimpleXMLElement;
	use stdClass;
	use TypeError;
	use ValueError;

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
			$previousLibxmlState = libxml_use_internal_errors(true);
			$parsedXml = simplexml_load_string($xml);
			libxml_clear_errors();
			libxml_use_internal_errors($previousLibxmlState);

			if (false === $parsedXml) {
				throw new EFEException('Invalid XML payload provided.');
			}

			$httpResponseData = $parsedXml->HttpResponse ?? null;
			$parametersData = $parsedXml->Parameters ?? null;
			$dataItemsData = $parsedXml->Data ?? null;

			if (!($httpResponseData instanceof SimpleXMLElement) or !($parametersData instanceof SimpleXMLElement) or !($dataItemsData instanceof SimpleXMLElement)) {
				throw new EFEException('Missing core structural properties in XML payload.');
			}

			try {
				return new static(
					HttpResponse::fromXML($httpResponseData),
					ContentParameters::fromXML($parametersData),
					DataItems::fromXML($dataItemsData),
				);
			} catch (TypeError | ValueError $e) {
				throw new EFEException('Missing or invalid properties in XML payload: ' . $e->getMessage(), 0, $e);
			}
		}

		public static function fromObject (stdClass $object) : ContentResponse {
			$httpResponseData = $object->httpResponse ?? null;
			$parametersData = $object->parameters ?? null;
			$dataItemsData = $object->data ?? null;

			if (!($httpResponseData instanceof stdClass) or !($parametersData instanceof stdClass) or !($dataItemsData instanceof stdClass)) {
				throw new EFEException('Missing core structural properties in stdClass payload.');
			}

			try {
				return new static(
					HttpResponse::fromObject($httpResponseData),
					ContentParameters::fromObject($parametersData),
					DataItems::fromObject($dataItemsData),
				);
			} catch (TypeError | ValueError $e) {
				throw new EFEException('Missing or invalid properties in stdClass payload: ' . $e->getMessage(), 0, $e);
			}
		}
	}
