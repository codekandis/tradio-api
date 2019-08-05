<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\Tiphy\Entities\UriExtenders\UriExtenderInterface;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;

abstract class AbstractUriExtender implements UriExtenderInterface
{
	/** @var ApiUriBuilder */
	protected $uriBuilder;

	public function __construct( ApiUriBuilder $uriBuilder )
	{
		$this->uriBuilder = $uriBuilder;
	}
}
