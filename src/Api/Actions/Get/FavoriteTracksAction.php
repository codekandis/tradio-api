<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Api\Actions\Get;

use CodeKandis\Persistence\FetchingResultFailedException;
use CodeKandis\Persistence\SettingFetchModeFailedException;
use CodeKandis\Persistence\StatementExecutionFailedException;
use CodeKandis\Persistence\StatementPreparationFailedException;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\TradioApi\Api\Actions\AbstractAction;
use CodeKandis\TradioApi\Environment\Entities\Collections\FavoriteTrackEntityCollectionInterface;
use CodeKandis\TradioApi\Environment\Entities\UriExtenders\FavoriteTrackApiUriExtender;
use CodeKandis\TradioApi\Environment\Persistence\MariaDb\Repositories\FavoriteTracksRepository;
use JsonException;
use ReflectionException;

/**
 * Represents the action to retrieve all favored tracks.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoriteTracksAction extends AbstractAction
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
		$favoriteTracks = $this->readFavoriteTracks();
		$this->extendUris( $favoriteTracks );

		( new JsonResponder(
			StatusCodes::OK,
			[
				'favoriteTracks' => $favoriteTracks,
			]
		) )
			->respond();
	}

	/**
	 * Extends the URIs of a list of favored tracks.
	 * @param FavoriteTrackEntityCollectionInterface $favoriteTracks The favored tracks to extend their URIs.
	 */
	private function extendUris( FavoriteTrackEntityCollectionInterface $favoriteTracks ): void
	{
		$apiUriBuilder = $this->getApiUriBuilder();
		foreach ( $favoriteTracks as $favoriteTrack )
		{
			( new FavoriteTrackApiUriExtender( $apiUriBuilder, $favoriteTrack ) )
				->extend();
		}
	}

	/**
	 * Reads all favored tracks.
	 * @return FavoriteTrackEntityCollectionInterface The favored tracks.
	 * @throws ReflectionException The favorite track entity class to reflect does not exist.
	 * @throws ReflectionException An error occurred during the creation of the favorite track entity.
	 * @throws StatementPreparationFailedException The preparation of the statement failed.
	 * @throws StatementExecutionFailedException The execution of the statement failed.
	 * @throws SettingFetchModeFailedException The setting of the fetch mode of the statement failed.
	 * @throws FetchingResultFailedException The fetching of the statment result failed.
	 */
	private function readFavoriteTracks(): FavoriteTrackEntityCollectionInterface
	{
		return ( new FavoriteTracksRepository(
			$this->getPersistenceConnector()
		) )
			->readFavoriteTracks();
	}
}
