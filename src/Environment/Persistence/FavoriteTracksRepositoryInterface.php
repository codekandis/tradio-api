<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Persistence;

use CodeKandis\Persistence\Repositories\RepositoryInterface;
use CodeKandis\TradioApi\Environment\Entities\Collections\FavoriteTrackEntityCollectionInterface;
use CodeKandis\TradioApi\Environment\Entities\FavoriteTrackEntityInterface;
use CodeKandis\TradioApi\Environment\Entities\UserEntityInterface;

/**
 * Represents the interface of any repository of any favorite track entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface FavoriteTracksRepositoryInterface extends RepositoryInterface
{
	/**
	 * Reads all favored tracks.
	 * @return FavoriteTrackEntityCollectionInterface The favored tracks.
	 */
	public function readFavoriteTracks(): FavoriteTrackEntityCollectionInterface;

	/**
	 * Reads a favored track by its ID.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track with the ID to search for.
	 * @return ?FavoriteTrackEntityInterface The favored track if found, otherwise null.
	 */
	public function readFavoriteTrackById( FavoriteTrackEntityInterface $favoriteTrack ): ?FavoriteTrackEntityInterface;

	/**
	 * Reads a favored track by its name.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track with the name to search for.
	 * @return ?FavoriteTrackEntityInterface The favored track if found, otherwise null.
	 */
	public function readFavoriteTrackByName( FavoriteTrackEntityInterface $favoriteTrack ): ?FavoriteTrackEntityInterface;

	/**
	 * Reads all favored tracks favored by a specific user.
	 * @param UserEntityInterface $user The user with the ID to search for.
	 * @return FavoriteTrackEntityCollectionInterface The favored tracks.
	 */
	public function readFavoriteTracksByUserId( UserEntityInterface $user ): FavoriteTrackEntityCollectionInterface;

	/**
	 * Creates a favored track for a specific user.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track to create.
	 * @param UserEntityInterface $user The user with the ID whom the favored track is related with.
	 */
	public function createFavoriteTrackByUserId( FavoriteTrackEntityInterface $favoriteTrack, UserEntityInterface $user ): void;

	/**
	 * Deletes a favored track of a specific user.
	 * @param FavoriteTrackEntityInterface $favoriteTrack The favored track to delete.
	 * @param UserEntityInterface $user The user with the ID whom the favored track is related with.
	 */
	public function deleteFavoriteTrackByUserId( FavoriteTrackEntityInterface $favoriteTrack, UserEntityInterface $user ): void;
}
