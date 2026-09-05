<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Http\UriBuilders;

use CodeKandis\TradioApi\Api\Http\UriBuilders\ApiUriBuilderInterface;

/**
 * Represents the interface of any URI builder builder.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface UriBuilderBuilderInterface
{
	/**
	 * Builds an API URI builder.
	 * @return ApiUriBuilderInterface The API URI builder.
	 */
	public function buildApiUriBuilder(): ApiUriBuilderInterface;
}
