<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

use CodeKandis\Configurations\PlainConfigurationLoader;
use CodeKandis\Tiphy\Configurations\AbstractConfigurationRegistry;
use CodeKandis\Tiphy\Configurations\RoutesConfiguration;
use CodeKandis\Tiphy\Configurations\UriBuilderConfiguration;
use CodeKandis\TiphyPersistenceIntegration\Configurations\ConfigurationRegistryTrait as PersistenceConfigurationRegistryTrait;
use CodeKandis\TiphyPersistenceIntegration\Configurations\PersistenceConfiguration;
use CodeKandis\TiphySentryClientIntegration\Configurations\ConfigurationRegistryTrait as SentryClientConfigurationRegistryTrait;
use CodeKandis\TiphySentryClientIntegration\Configurations\SentryClientConfiguration;
use function dirname;

/**
 * Represents the application's configuration registry.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class ConfigurationRegistry extends AbstractConfigurationRegistry implements ConfigurationRegistryInterface
{
	use PersistenceConfigurationRegistryTrait;
	use SentryClientConfigurationRegistryTrait;

	/**
	 * {@inheritDoc}
	 */
	public static function _(): ConfigurationRegistryInterface
	{
		return parent::_();
	}

	/**
	 * {@inheritDoc}
	 */
	protected function initialize(): void
	{
		$this->persistenceConfiguration  = new PersistenceConfiguration(
			( new PlainConfigurationLoader() )
				->load( __DIR__ . '/Plain', 'persistence' )
				->load( dirname( __DIR__, 2 ) . '/config', 'persistence' )
				->getPlainConfiguration()
		);
		$this->routesConfiguration       = new RoutesConfiguration(
			( new PlainConfigurationLoader() )
				->load( __DIR__ . '/Plain', 'routes' )
				->load( dirname( __DIR__, 2 ) . '/config', 'routes' )
				->getPlainConfiguration()
		);
		$this->sentryClientConfiguration = new SentryClientConfiguration(
			( new PlainConfigurationLoader() )
				->load( __DIR__ . '/Plain', 'sentryClient' )
				->load( dirname( __DIR__, 2 ) . '/config', 'sentryClient' )
				->getPlainConfiguration()
		);
		$this->uriBuilderConfiguration   = new UriBuilderConfiguration(
			( new PlainConfigurationLoader() )
				->load( __DIR__ . '/Plain', 'uriBuilder' )
				->load( dirname( __DIR__, 2 ) . '/config', 'uriBuilder' )
				->getPlainConfiguration()
		);
	}
}
