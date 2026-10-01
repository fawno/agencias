<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE\Response;

	use Fawno\Agencias\EFE\ContentParameters;
	use Fawno\Agencias\EFE\DataItems;
	use Fawno\Agencias\EFE\Exception\EFEException;
	use Fawno\Agencias\EFE\HttpResponse;
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

		public static function fromObject (stdClass $object) : ContentResponse {
			$httpResponseData = $object->httpResponse ?? null;
			$parametersData = $object->parameters ?? null;
			$dataItemsData = $object->data ?? null;

			if (null === $httpResponseData or null === $parametersData or null === $dataItemsData) {
				throw new EFEException('Missing core structural properties in stdClass payload.');
			}

			return new static(
				HttpResponse::fromObject($httpResponseData),
				ContentParameters::fromObject($parametersData),
				DataItems::fromObject($dataItemsData),
			);
		}
	}
