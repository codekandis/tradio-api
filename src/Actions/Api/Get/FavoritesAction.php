<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\Tiphy\Persistence\PersistenceException;
use CodeKandis\TradioApi\Actions\AbstractWithDatabaseConnectorAndApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\FavoriteApiUriExtender;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use JsonException;

class FavoritesAction extends AbstractWithDatabaseConnectorAndApiUriBuilderAction
{
	/**
	 * @throws PersistenceException
	 * @throws JsonException
	 */
	public function execute(): void
	{
		$favorites = $this->readFavorites();
		$this->extendUris( $favorites );

		$responderData = [
			'favorites' => $favorites,
		];
		( new JsonResponder( StatusCodes::OK, $responderData ) )
			->respond();
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
	 * @return FavoriteEntity[]
	 * @throws PersistenceException
	 */
	private function readFavorites(): array
	{
		return ( new FavoritesRepository(
			$this->getDatabaseConnector()
		) )
			->readFavorites();
	}
}
