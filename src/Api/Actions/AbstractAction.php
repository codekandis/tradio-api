<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Api\Actions;

use CodeKandis\Persistence\Connector;
use CodeKandis\Persistence\ConnectorInterface;
use CodeKandis\SentryClient\SentryClient;
use CodeKandis\SentryClient\SentryClientInterface;
use CodeKandis\Tiphy\Actions\AbstractAction as OriginAbstractAction;
use CodeKandis\TradioApi\Api\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\TradioApi\Api\Http\UriBuilders\ApiUriBuilderInterface;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;

/**
 * Represents the base class of any action.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class AbstractAction extends OriginAbstractAction
{
	/**
	 * Stores the `SentryClient`.
	 * @var SentryClientInterface
	 */
	private SentryClientInterface $sentryClient;

	/**
	 * Stores the API URI builder.
	 * @var ApiUriBuilderInterface
	 */
	private ApiUriBuilderInterface $apiUriBuilder;

	/**
	 * Stores the persistence connector.
	 * @var ConnectorInterface
	 */
	private ConnectorInterface $persistenceConnector;

	/**
	 * Gets the `SentryClient`.
	 * @return SentryClientInterface The `SentryClient`.
	 */
	protected function getSentryClient(): SentryClientInterface
	{
		return $this->sentryClient ??
			   $this->sentryClient = new SentryClient(
				   ConfigurationRegistry::_()->getSentryClientConfiguration()
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
				   ConfigurationRegistry::_()->getUriBuilderConfiguration()
			   );
	}

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
