<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Read;

use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\MariaDb\Connector;
use CodeKandis\Tiphy\Persistence\MariaDb\ConnectorInterface;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\FavoriteUriExtender;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use ReflectionException;

class GetUserFavoritesAction extends AbstractAction
{
	/** @var ConnectorInterface */
	private $databaseConnector;

	/** @var ApiUriBuilder */
	private $uriBuilder;

	private function getDatabaseConnector(): ConnectorInterface
	{
		if ( null === $this->databaseConnector )
		{
			$databaseConfig          = ConfigurationRegistry::_()->getPersistenceConfiguration();
			$this->databaseConnector = new Connector( $databaseConfig );
		}

		return $this->databaseConnector;
	}

	private function getUriBuilder(): ApiUriBuilder
	{
		if ( null === $this->uriBuilder )
		{
			$uriBuilderConfiguration = ConfigurationRegistry::_()->getUriBuilderConfiguration();
			$this->uriBuilder        = new ApiUriBuilder( $uriBuilderConfiguration );
		}

		return $this->uriBuilder;
	}

	/**
	 * @throws PersistenceException
	 * @throws ReflectionException
	 */
	public function execute(): void
	{
		$inputData = $this->getInputData();

		$requestedUser     = new UserEntity();
		$requestedUser->id = $inputData[ 'id' ];
		$user              = $this->readUser( $requestedUser );

		if ( null === $user )
		{
			( new JsonResponder( StatusCodes::NOT_FOUND, null ) )
				->respond();

			return;
		}

		$favorites = $this->readUsersFavorites( $user );
		$this->extendUris( $favorites );

		$responderData = [
			'favorites' => $favorites,
		];
		( new JsonResponder( StatusCodes::OK, $responderData ) )
			->respond();
	}

	/**
	 * @return string[]
	 */
	private function getInputData(): array
	{
		return $this->arguments;
	}

	/**
	 * @param FavoriteEntity[] $favorites
	 */
	private function extendUris( array $favorites ): void
	{
		$uriBuilder = $this->getUriBuilder();
		foreach ( $favorites as $favorite )
		{
			( new FavoriteUriExtender( $uriBuilder, $favorite ) )
				->extend();
		}
	}

	/**
	 * @throws PersistenceException
	 */
	private function readUser( UserEntity $requestedUser ): ?UserEntity
	{
		$databaseConnector = $this->getDatabaseConnector();

		return ( new UsersRepository( $databaseConnector ) )
			->readUserById( $requestedUser );
	}

	/**
	 * @return FavoriteEntity[]
	 * @throws PersistenceException
	 */
	private function readUsersFavorites( UserEntity $user ): array
	{
		$databaseConnector = $this->getDatabaseConnector();

		return ( new FavoritesRepository( $databaseConnector ) )
			->readFavoritesByUserId( $user );
	}
}