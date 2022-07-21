<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities;

/**
 * Stores the interface of any currently playing track.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface CurrentTrackEntityInterface extends EntityInterface
{
	/**
	 * Gets the name of the track.
	 * @return string The name of the track.
	 */
	public function getName(): string;

	/**
	 * Sets the name of the track.
	 * @param string $name The name of the track.
	 */
	public function setName( string $name ): void;

	/**
	 * Gets the ID of the station playing the track.
	 * @return string The ID of the station playing the track.
	 */
	public function getStationId(): string;

	/**
	 * Sets the ID of the station playing the track.
	 * @param string $stationId The ID of the station playing the track.
	 */
	public function setStationId( string $stationId ): void;

	/**
	 * Gets the URI of the station playing the track.
	 * @return string The URI of the station playing the track.
	 */
	public function getStationUri(): string;

	/**
	 * Sets the URI of the station playing the track.
	 * @param string $stationUri The URI of the station playing the track.
	 */
	public function setStationUri( string $stationUri ): void;

	/**
	 * Gets the URI of the persisted favored track of the currently playing track.
	 * @return ?string The URI of the persisted favored track of the currently playing track.
	 */
	public function getFavoriteTrackUri(): ?string;

	/**
	 * Sets the URI of the persisted favored track of the currently playing track.
	 * @param ?string $favoriteTrackUri The URI of the persisted favored track of the currently playing track.
	 */
	public function setFavoriteTrackUri( ?string $favoriteTrackUri ): void;
}
