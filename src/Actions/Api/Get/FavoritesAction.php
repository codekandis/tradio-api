<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Get;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\TradioApi\Actions\AbstractWithPersistenceConnectorAndApiUriBuilderAction;
use CodeKandis\TradioApi\Entities\Collections\FavoriteEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\UriExtenders\FavoriteApiUriExtender;
use CodeKandis\TradioApi\Persistence\MariaDb\Repositories\FavoritesRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to retrieve all favored tracks.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoritesAction extends AbstractWithPersistenceConnectorAndApiUriBuilderAction
{
	/**
	 * {@inheritDoc}
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 * @throws JsonException An error occurred during the creation of the JSON response.
	 */
	public function execute(): void
	{
		$favorites = $this->readFavorites();
		$this->extendUris( $favorites );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'favorites' => $favorites,
			]
		) )
			->respond();
	}

	/**
	 * Extends the URIs of a list of favored tracks.
	 * @param FavoriteEntityCollectionInterface $favorites The favored tracks to extend their URIs.
	 */
	private function extendUris( FavoriteEntityCollectionInterface $favorites ): void
	{
		$apiUriBuilder = $this->getApiUriBuilder();
		foreach ( $favorites as $favorite )
		{
			( new FavoriteApiUriExtender( $apiUriBuilder, $favorite ) )
				->extend();
		}
	}

	/**
	 * Reads all favored tracks.
	 * @return FavoriteEntityCollectionInterface The favored tracks.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readFavorites(): FavoriteEntityCollectionInterface
	{
		return ( new FavoritesRepository(
			$this->getPersistenceConnector()
		) )
			->readFavorites();
	}
}
