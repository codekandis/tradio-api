<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Api\Http\UriBuilders;

/**
 * Represents the interface of any APU URI builder.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface ApiUriBuilderInterface
{
	/**
	 * Builds the URI of the index.
	 * @return string The URI of the index.
	 */
	public function buildIndexUri(): string;

	/**
	 * Builds the URI of the stations.
	 * @return string The URI of the stations.
	 */
	public function buildStationsUri(): string;

	/**
	 * Builds the URI of a specific station.
	 * @param string $stationId The ID of the station.
	 * @return string The URI of the station.
	 */
	public function buildStationUri( string $stationId ): string;

	/**
	 * Builds the URI of the currently playing track of a specific station.
	 * @param string $stationId The ID of the station.
	 * @return string The URI of the currently playing track of the station.
	 */
	public function buildCurrentTrackUri( string $stationId ): string;

	/**
	 * Builds the URI of the users favoring a specific station.
	 * @param string $stationId The ID of the station.
	 * @return string The URI of the users favoring the station.
	 */
	public function buildStationUsersUri( string $stationId ): string;

	/**
	 * Builds the URI of the users.
	 * @return string The URI of the users.
	 */
	public function buildUsersUri(): string;

	/**
	 * Builds the URI of a specific user.
	 * @param string $userId The ID of the user.
	 * @return string The URI of the user.
	 */
	public function buildUserUri( string $userId ): string;

	/**
	 * Builds the URI of the stations favored by a specific user.
	 * @param string $userId The ID of the user.
	 * @return string The URI of the stations favored by the user.
	 */
	public function buildUserStationsUri( string $userId ): string;

	/**
	 * Builds the URI of the tracks favored by a specific user.
	 * @param string $userId The ID of the user.
	 * @return string The URI of the tracks favored by the user.
	 */
	public function buildUserFavoriteTracksUri( string $userId ): string;

	/**
	 * Builds the URI of the favored tracks.
	 * @return string The URI of the favored tracks.
	 */
	public function buildFavoriteTracksUri(): string;

	/**
	 * Builds the URI of a specific favored track.
	 * @param string $favoriteTrackId The ID of the favored track.
	 * @return string The URI of the favored track.
	 */
	public function buildFavoriteTrackUri( string $favoriteTrackId ): string;

	/**
	 * Builds the URI of the users favoring a specific track.
	 * @param string $favoriteTrackId The ID of the favored track.
	 * @return string The URI of the users favoring the track.
	 */
	public function buildFavoriteTrackUsersUri( string $favoriteTrackId ): string;
}
