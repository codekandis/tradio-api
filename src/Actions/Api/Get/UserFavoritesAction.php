<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Actions\AbstractWithDatabaseConnectorAndApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\FavoriteApiUriExtender;
use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Errors\UsersErrorCodes;
use CodeKandis\TradioApi\Errors\UsersErrorMessages;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\UsersRepository;
use JsonException;

class UserFavoritesAction extends AbstractWithDatabaseConnectorAndApiUriBuilderAction
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

		$favorites = $this->readFavoritesByUserId( $user );
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
		$apiUriBuilder = $this->getApiUriBuilder();
		foreach ( $favorites as $favorite )
		{
			( new FavoriteApiUriExtender( $apiUriBuilder, $favorite ) )
				->extend();
		}
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
	 * @return FavoriteEntity[]
	 * @throws PersistenceException
	 */
	private function readFavoritesByUserId( UserEntity $user ): array
	{
		return ( new FavoritesRepository(
			$this->getDatabaseConnector()
		) )
			->readFavoritesByUserId( $user );
	}
}
