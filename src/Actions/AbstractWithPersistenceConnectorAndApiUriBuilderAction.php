<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions;

use CodeKandis\Persistence\Connector;
use CodeKandis\Persistence\ConnectorInterface;
use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

/**
 * Represents the base class of all actions providing a persistence connector and an API URI builder.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class AbstractWithPersistenceConnectorAndApiUriBuilderAction extends AbstractAction
{
	/**
	 * Stores the persistence connector.
	 * @var ConnectorInterface
	 */
	private ConnectorInterface $persistenceConnector;

	/**
	 * Stores the API URI builder.
	 * @var ApiUriBuilderInterface
	 */
	private ApiUriBuilderInterface $apiUriBuilder;

	/**
	 * Gets the persistence connector.
	 * @return ConnectorInterface The persistence connector.
	 */
	protected function getPersistenceConnector(): ConnectorInterface
	{
		return $this->persistenceConnector ??
			   $this->persistenceConnector = new Connector(
				   ConfigurationRegistry
					   ::_()
					   ->getPersistenceConfiguration()
			   );
	}

	/**
	 * Gets the API URI builder.
	 * @return ApiUriBuilderInterface The API URI builder.
	 */
	protected function getApiUriBuilder(): ApiUriBuilderInterface
	{
		return $this->apiUriBuilder ??
			   $this->apiUriBuilder = new ApiUriBuilder(
				   ConfigurationRegistry
					   ::_()
					   ->getUriBuilderConfiguration()
			   );
	}
}
