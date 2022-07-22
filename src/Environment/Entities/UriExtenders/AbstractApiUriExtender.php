<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\UriExtenders;

use CodeKandis\Tiphy\Entities\UriExtenders\UriExtenderInterface;
use CodeKandis\TradioApi\Api\Http\UriBuilders\ApiUriBuilderInterface;

/**
 * Represents the base class of any URI extender.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class AbstractApiUriExtender implements UriExtenderInterface
{
	/**
	 * Stores the API URI builder to use for the URI extensions.
	 * @var ApiUriBuilderInterface
	 */
	protected ApiUriBuilderInterface $apiUriBuilder;

	/**
	 * Constructor method.
	 * @param ApiUriBuilderInterface $apiUriBuilder The API URI builder to use for the URI extensions.
	 */
	public function __construct( ApiUriBuilderInterface $apiUriBuilder )
	{
		$this->apiUriBuilder = $apiUriBuilder;
	}
}
