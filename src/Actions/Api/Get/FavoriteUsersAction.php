<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Actions\AbstractWithDatabaseConnectorAndApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\UserApiUriExtender;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Errors\FavoritesErrorCodes;
use CodeKandis\TradioApi\Errors\FavoritesErrorMessages;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;

class FavoriteUsersAction extends AbstractWithDatabaseConnectorAndApiUriBuilderAction
{
	/**
	 * @throws PersistenceException
	 * @throws JsonException
	 */
	public function execute(): void
	{
		$inputData = $this->getInputData();

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

		$users = $this->readUsersByFavoriteId( $favorite );
		$this->extendUris( $users );

		$responderData = [
			'users' => $users,
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
	 * @param UserEntity[] $users
	 */
	private function extendUris( array $users ): void
	{
		$apiUriBuilder = $this->getApiUriBuilder();
		foreach ( $users as $user )
		{
			( new UserApiUriExtender( $apiUriBuilder, $user ) )
				->extend();
		}
	}

	/**
	 * @throws PersistenceException
	 */
	private function readFavoriteById( FavoriteEntity $favorite ): ?FavoriteEntity
	{
		return ( new FavoritesRepository(
			$this->getDatabaseConnector()
		) )
			->readFavoriteById( $favorite );
	}

	/**
	 * @return UserEntity[]
	 * @throws PersistenceException
	 */
	private function readUsersByFavoriteId( FavoriteEntity $favorite ): array
	{
		return ( new UsersRepository(
			$this->getDatabaseConnector()
		) )
			->readUsersByFavoriteId( $favorite );
	}
}
