<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\PreDispatchment;

use CodeKandis\Authentication\AuthorizationHeader\AuthorizationHeaderParser;
use CodeKandis\Authentication\AuthorizationHeader\ParsedAuthorizationHeaderInterface;
use CodeKandis\Authentication\KeyBasedClientCredentials;
use CodeKandis\Authentication\KeyBasedStatelessAuthenticator;
use CodeKandis\Authentication\RegisteredKeyBasedClient;
use CodeKandis\Tiphy\Actions\PreDispatchment\PreDispatcherInterface;
use CodeKandis\Tiphy\Actions\PreDispatchment\PreDispatchmentStateInterface;
use CodeKandis\Tiphy\Persistence\MariaDb\Connector;
use CodeKandis\TradioApi\Actions\Api\UnauthorizedAction;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Entities\Authentication\UserEntity;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\Authentication\UsersRepository;
use JsonException;

class AuthenticationPreDispatcher implements PreDispatcherInterface
{
	/**
	 * Gets the authorization header.
	 * @return null|ParsedAuthorizationHeaderInterface The authorization header.
	 */
	private function getAuthorizationHeader(): ?ParsedAuthorizationHeaderInterface
	{
		return ( new AuthorizationHeaderParser() )
			->parse();
	}

	private function getRegisteredClients( string $apiKey ): array
	{
		$userRepository = new UsersRepository(
			$this->databaseConnector = new Connector(
				ConfigurationRegistry::_()->getPersistenceConfiguration()
			)
		);

		$requestedUser         = new UserEntity();
		$requestedUser->apiKey = $apiKey;
		$registeredUser        = $userRepository->readUserByKey( $requestedUser );

		$registeredClients = [];
		if ( null !== $registeredUser )
		{
			$registeredClients[] = new RegisteredKeyBasedClient( '', $registeredUser->apiKey, (int) $registeredUser->isActive );
		}

		return $registeredClients;
	}

	/**
	 * Responds with a `401 Unauthorized`.
	 * @param PreDispatchmentStateInterface $dispatchmentState
	 * @throws JsonException
	 */
	private function respondUnauthorized( PreDispatchmentStateInterface $dispatchmentState ): void
	{
		$dispatchmentState->setPreventDispatchment( true );
		( new UnauthorizedAction() )
			->execute();
	}

	/**
	 * @inheritDoc
	 */
	public function preDispatch( PreDispatchmentStateInterface $dispatchmentState ): void
	{
		$authorizationHeader = $this->getAuthorizationHeader();

		if ( null === $authorizationHeader || 'Key' !== $authorizationHeader->getType() )
		{
			$this->respondUnauthorized( $dispatchmentState );
		}

		$clientCredentials = new KeyBasedClientCredentials( $authorizationHeader->getValue() );
		$registeredClients = $this->getRegisteredClients( $clientCredentials->getKeySha512() );
		$authenticator     = new KeyBasedStatelessAuthenticator();

		if ( false === $authenticator->requestPermission( $registeredClients, $clientCredentials ) )
		{
			$this->respondUnauthorized( $dispatchmentState );
		}
	}
}
