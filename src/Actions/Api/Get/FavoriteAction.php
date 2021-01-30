<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\Tiphy\Throwables\ErrorInformation;
use CodeKandis\TradioApi\Actions\AbstractWithDatabaseConnectorAndApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\FavoriteApiUriExtender;
use CodeKandis\TradioApi\Errors\FavoritesErrorCodes;
use CodeKandis\TradioApi\Errors\FavoritesErrorMessages;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use JsonException;

class FavoriteAction extends AbstractWithDatabaseConnectorAndApiUriBuilderAction
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

		$this->extendUris( $favorite );

		$responderData = [
			'favorite' => $favorite
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

	private function extendUris( FavoriteEntity $favorite ): void
	{
		$apiUriBuilder = $this->getApiUriBuilder();
		( new FavoriteApiUriExtender( $apiUriBuilder, $favorite ) )
			->extend();
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
}
