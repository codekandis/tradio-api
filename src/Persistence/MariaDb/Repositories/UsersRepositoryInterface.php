<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Persistence\MariaDb\Repositories;

use CodeKandis\Persistence\Repositories\RepositoryInterface;
use CodeKandis\TradioApi\Entities\Collections\UserEntityCollectionInterface;
use CodeKandis\TradioApi\Entities\FavoriteEntityInterface;
use CodeKandis\TradioApi\Entities\StationEntityInterface;
use CodeKandis\TradioApi\Entities\UserEntityInterface;

/**
 * Represents the interface of any repository of any user entity.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface UsersRepositoryInterface extends RepositoryInterface
{
	/**
	 * Reads all users.
	 * @return UserEntityCollectionInterface The users.
	 */
	public function readUsers(): UserEntityCollectionInterface;

	/**
	 * Reads a user by its ID.
	 * @param UserEntityInterface $user The user with the ID to search for.
	 * @return ?UserEntityInterface The user if found, otherwise null.
	 */
	public function readUserById( UserEntityInterface $user ): ?UserEntityInterface;

	/**
	 * Reads all users who favored a specific station.
	 * @param StationEntityInterface $station The station with the ID to search for.
	 * @return UserEntityCollectionInterface The users.
	 */
	public function readUsersByStationId( StationEntityInterface $station ): UserEntityCollectionInterface;

	/**
	 * Reads all users who favored a specific favorite track.
	 * @param FavoriteEntityInterface $favorite The favorite track with the ID to search for.
	 * @return UserEntityCollectionInterface The users.
	 */
	public function readUsersByFavoriteId( FavoriteEntityInterface $favorite ): UserEntityCollectionInterface;
}
