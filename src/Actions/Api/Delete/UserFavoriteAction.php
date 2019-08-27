<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Delete;

use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\Tiphy\Exceptions\ErrorInformation;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\MariaDb\Connector;
use CodeKandis\Tiphy\Persistence\MariaDb\ConnectorInterface;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Errors\FavoritesErrorCodes;
use CodeKandis\TradioApi\Errors\FavoritesErrorMessages;
use CodeKandis\TradioApi\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;

class UserFavoriteAction extends AbstractAction
{
	/** @var ConnectorInterface */
	private $databaseConnector;

	private function getDatabaseConnector(): ConnectorInterface
	{
		if ( null === $this->databaseConnector )
		{
			$databaseConfig          = ConfigurationRegistry::_()->getPersistenceConfiguration();
			$this->databaseConnector = new Connector( $databaseConfig );
		}

		return $this->databaseConnector;
	}

	/**
	 * @throws PersistenceException
	 * @throws JsonException
	 */
	public function execute(): void
	{
		$inputData = $this->getInputData();

		$requestedUser     = new UserEntity();
		$requestedUser->id = $inputData[ 'userId' ];
		$user              = $this->readUserById( $requestedUser );

		if ( null === $user )
		{
			$errorInformation = new ErrorInformation( UsersErrorCodes::USER_UNKNOWN, UsersErrorMessages::USER_UNKNOWN, $inputData );
			( new JsonResponder( StatusCodes::NOT_FOUND, null, $errorInformation ) )
				->respond();

			return;
		}

		$requestedFavorite     = new FavoriteEntity();
		$requestedFavorite->id = $inputData[ 'favoriteId' ];
		$favorite              = $this->readFavoriteById( $requestedFavorite );

		if ( null === $favorite )
		{
			$errorInformation = new ErrorInformation( FavoritesErrorCodes::FAVORITE_UNKNOWN, FavoritesErrorMessages::FAVORITE_UNKNOWN, $inputData );
			( new JsonResponder( StatusCodes::NOT_FOUND, null, $errorInformation ) )
				->respond();

			return;
		}

		$this->deleteFavoriteByUserId( $user, $favorite );

		( new JsonResponder( StatusCodes::OK, null ) )
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
	 * @throws PersistenceException
	 */
	private function readUserById( UserEntity $requestedUser ): ?UserEntity
	{
		$databaseConnector = $this->getDatabaseConnector();

		return ( new UsersRepository( $databaseConnector ) )
			->readUserById( $requestedUser );
	}

	/**
	 * @throws PersistenceException
	 */
	private function readFavoriteById( FavoriteEntity $requestedFavorite ): ?FavoriteEntity
	{
		$databaseConnector = $this->getDatabaseConnector();

		return ( new FavoritesRepository( $databaseConnector ) )
			->readFavoriteById( $requestedFavorite );
	}

	/**
	 * @throws PersistenceException
	 */
	private function deleteFavoriteByUserId( UserEntity $user, FavoriteEntity $favorite ): void
	{
		$databaseConnector = $this->getDatabaseConnector();

		( new FavoritesRepository( $databaseConnector ) )
			->deleteFavoriteByUserId( $favorite, $user );
	}
}
