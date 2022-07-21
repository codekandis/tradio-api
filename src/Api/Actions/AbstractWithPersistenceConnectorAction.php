<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Api\Actions;

use CodeKandis\Persistence\Connector;
use CodeKandis\Persistence\ConnectorInterface;
use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;

/**
 * Represents the base class of all actions providing a persistence connector.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class AbstractWithPersistenceConnectorAction extends AbstractAction
{
	/**
	 * Stores the persistence connector.
	 * @var ConnectorInterface
	 */
	private ConnectorInterface $persistenceConnector;

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
}
