<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Configurations;

use CodeKandis\TiphySentryClientIntegration\Configurations\AbstractConfigurationRegistry;
use function dirname;

class ConfigurationRegistry extends AbstractConfigurationRegistry
{
	protected function initialize(): void
	{
		$this->initializeSentryClientConfiguration();
		$this->initializeRoutesConfiguration();
		$this->initializePersistenceConfiguration();
		$this->initializeUriBuilderConfiguration();
	}

	private function initializeSentryClientConfiguration()
	{
		$this->setPlainSentryClientConfiguration(
			( require __DIR__ . '/Plain/sentryClient.php' )
			+ ( require dirname( __DIR__, 2 ) . '/config/sentryClient.php' )
		);
	}

	private function initializeRoutesConfiguration()
	{
		$this->setPlainRoutesConfiguration(
			( require __DIR__ . '/Plain/routes.php' )
			+ ( require dirname( __DIR__, 2 ) . '/config/routes.php' )
		);
	}

	private function initializePersistenceConfiguration()
	{
		$this->setPlainPersistenceConfiguration(
			require dirname( __DIR__, 2 ) . '/config/persistence.php'
		);
	}

	private function initializeUriBuilderConfiguration()
	{
		$this->setPlainUriBuilderConfiguration(
			( require __DIR__ . '/Plain/uriBuilder.php' )
			+ ( require dirname( __DIR__, 2 ) . '/config/uriBuilder.php' )
		);
	}
}
