<?php
	declare(strict_types=1);

	namespace Fawno\Agencias\EFE;

	enum FormatRequest : string {
		case JSON = 'json';
		case NEWSML = 'newsml';
		case RSS = 'rss';
		case XML = 'xml';
	}
