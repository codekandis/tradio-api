<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Persistence\MariaDb\Repositories;

use CodeKandis\Persistence\Repositories\RepositoryInterface;
use CodeKandis\TradioApi\Entities\Collections\FavoriteEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\FavoriteEntityInterface;
use CodeKandis\TradioApi\Entities\UserEntityInterface;

/**
 * Represents the interface of any repository of any favorite track entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface FavoritesRepositoryInterface extends RepositoryInterface
{
	/**
	 * Reads all favorite tracks.
	 * @return FavoriteEntityCollectionInterface The favorite tracks.
	 */
	public function readFavorites(): FavoriteEntityCollectionInterface;

	/**
	 * Reads a favorite track by its ID.
	 * @param FavoriteEntityInterface $favorite The favorite track with the ID to search for.
	 * @return ?FavoriteEntityInterface The favorite track if found, otherwise null.
	 */
	public function readFavoriteById( FavoriteEntityInterface $favorite ): ?FavoriteEntityInterface;

	/**
	 * Reads a favorite track by its name.
	 * @param FavoriteEntityInterface $favorite The favorite track with the name to search for.
	 * @return ?FavoriteEntityInterface The favorite track if found, otherwise null.
	 */
	public function readFavoriteByName( FavoriteEntityInterface $favorite ): ?FavoriteEntityInterface;

	/**
	 * Reads all favorite tracks favored by a specific user.
	 * @param UserEntityInterface $user The user with the ID to search for.
	 * @return FavoriteEntityCollectionInterface The favorite tracks.
	 */
	public function readFavoritesByUserId( UserEntityInterface $user ): FavoriteEntityCollectionInterface;

	/**
	 * Creates a favorite track for a specific user.
	 * @param FavoriteEntityInterface $favorite The favorite track to create.
	 * @param UserEntityInterface $user The user with the ID whom the favorite track is related with.
	 */
	public function createFavoriteByUserId( FavoriteEntityInterface $favorite, UserEntityInterface $user ): void;

	/**
	 * Deletes a favorite track of a specific user.
	 * @param FavoriteEntityInterface $favorite The favorite track to delete.
	 * @param UserEntityInterface $user The user with the ID whom the favorite track is related with.
	 */
	public function deleteFavoriteByUserId( FavoriteEntityInterface $favorite, UserEntityInterface $user ): void;
}
