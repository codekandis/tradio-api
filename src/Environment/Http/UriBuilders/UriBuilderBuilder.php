<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Http\UriBuilders;

use CodeKandis\Tiphy\Http\UriBuilders\AbstractUriBuilderBuilder;
use CodeKandis\TradioApi\Api\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\TradioApi\Api\Http\UriBuilders\ApiUriBuilderInterface;
use CodeKandis\TradioApi\Environment\Enumerations\ApplicationStageNames;

/**
 * Represents a URI builder builder.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class UriBuilderBuilder extends AbstractUriBuilderBuilder implements UriBuilderBuilderInterface
{
	/**
	 * @inheritDoc
	 */
	public function buildApiUriBuilder(): ApiUriBuilderInterface
	{
		return new ApiUriBuilder(
			$this->uriBuilderConfiguration->getPreset( ApplicationStageNames::API )
		);
	}
}
