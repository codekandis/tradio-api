<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\Tiphy\Entities\UriExtenders\UriExtenderInterface;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

abstract class AbstractApiUriExtender implements UriExtenderInterface
{
	/** @var ApiUriBuilderInterface */
	protected ApiUriBuilderInterface $apiUriBuilder;

	public function __construct( ApiUriBuilderInterface $apiUriBuilder )
	{
		$this->apiUriBuilder = $apiUriBuilder;
	}
}
