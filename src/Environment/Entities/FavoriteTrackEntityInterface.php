<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities;

use DateTimeImmutable;

/**
 * Represents the interface of any favored track.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface FavoriteTrackEntityInterface extends PersistableEntityInterface
{
	/**
	 * Gets the name of the favored track.
	 * @return string The name of the favored track.
	 */
	public function getName(): string;

	/**
	 * Sets the name of the favored track.
	 * @param string $name The name of the favored track.
	 */
	public function setName( string $name ): void;

	/**
	 * Gets the URI of the users who favored the track.
	 * @return string The URI of the users who favored the track.
	 */
	public function getUsersUri(): string;

	/**
	 * Sets the URI of the users who favored the track.
	 * @param string $usersUri The URI of the users who favored the track.
	 */
	public function setUsersUri( string $usersUri ): void;

	/**
	 * Gets the timestamp when the favored track has been created.
	 * @return DateTimeImmutable The timestamp when the favored track has been created.
	 */
	public function getTimestampCreated(): DateTimeImmutable;

	/**
	 * Sets the timestamp when the favored track has been created.
	 * @param DateTimeImmutable $timestampCreated The timestamp when the favored track has been created.
	 */
	public function setTimestampCreated( DateTimeImmutable $timestampCreated ): void;
}
