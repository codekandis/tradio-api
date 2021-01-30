<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Delete;

use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Actions\AbstractWithDatabaseConnectorAction;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Errors\FavoritesErrorCodes;
use CodeKandis\TradioApi\Errors\FavoritesErrorMessages;
use CodeKandis\TradioApi\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;

class UserFavoriteAction extends AbstractWithDatabaseConnectorAction
{
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
		return ( new UsersRepository(
			$this->getDatabaseConnector()
		) )
			->readUserById( $requestedUser );
	}

	/**
	 * @throws PersistenceException
	 */
	private function readFavoriteById( FavoriteEntity $requestedFavorite ): ?FavoriteEntity
	{
		return ( new FavoritesRepository(
			$this->getDatabaseConnector()
		) )
			->readFavoriteById( $requestedFavorite );
	}

	/**
	 * @throws PersistenceException
	 */
	private function deleteFavoriteByUserId( UserEntity $user, FavoriteEntity $favorite ): void
	{
		( new FavoritesRepository(
			$this->getDatabaseConnector()
		) )
			->deleteFavoriteByUserId( $favorite, $user );
	}
}
