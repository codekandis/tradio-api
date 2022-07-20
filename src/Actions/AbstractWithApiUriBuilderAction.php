<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions;

use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

/**
 * Represents the base class of all actions providing an API URI builder.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class AbstractWithApiUriBuilderAction extends AbstractAction
{
	/**
	 * Stores the API URI builder.
	 * @var ApiUriBuilderInterface
	 */
	private ApiUriBuilderInterface $apiUriBuilder;

	/**
	 * Gets the API URI builder.
	 * @return ApiUriBuilderInterface The API URI builder.
	 */
	protected function getApiUriBuilder(): ApiUriBuilderInterface
	{
		return $this->apiUriBuilder ??
			   $this->apiUriBuilder = new ApiUriBuilder(
				   ConfigurationRegistry::_()->getUriBuilderConfiguration()
			   );
	}
}
