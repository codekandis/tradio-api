<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\Tiphy\Entities\UriExtenders\UriExtenderInterface;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

abstract class AbstractUriExtender implements UriExtenderInterface
{
	/** @var ApiUriBuilderInterface */
	protected $uriBuilder;

	public function __construct( ApiUriBuilderInterface $uriBuilder )
	{
		$this->uriBuilder = $uriBuilder;
	}
}
