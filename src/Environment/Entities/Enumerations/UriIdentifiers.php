<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\Enumerations;

/**
 * Represents an enumeration of URI identifiers.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class UriIdentifiers
{
	/**
	 * Represents the URI identifier of the API index.
	 * @var string
	 */
	public const INDEX = 'index';

	/**
	 * Represents the URI identifier of the stations.
	 * @var string
	 */
	public const STATIONS = 'stations';

	/**
	 * Represents the URI identifier of a specific station.
	 * @var string
	 */
	public const STATION = 'station';

	/**
	 * Represents the URI identifier of the currently playing track of a specific station.
	 * @var string
	 */
	public const CURRENT_TRACK = 'currentTrack';

	/**
	 * Represents the URI identifier of the users of a specific station.
	 * @var string
	 */
	public const STATION_USERS = 'stationUsers';

	/**
	 * Represents the URI identifier of the users.
	 * @var string
	 */
	public const USERS = 'users';

	/**
	 * Represents the URI identifier of a specific user.
	 * @var string
	 */
	public const USER = 'user';

	/**
	 * Represents the URI identifier of the stations of a specific user.
	 * @var string
	 */
	public const USER_STATIONS = 'userStations';

	/**
	 * Represents the URI identifier of the favored tracks of a specific user.
	 * @var string
	 */
	public const USER_FAVORITE_TRACKS = 'userFavoriteTracks';

	/**
	 * Represents the URI identifier of the favored tracks.
	 * @var string
	 */
	public const FAVORITE_TRACKS = 'favoriteTracks';

	/**
	 * Represents the URI identifier of a specific favored track.
	 * @var string
	 */
	public const FAVORITE_TRACK = 'favoriteTrack';

	/**
	 * Represents the URI identifier of the users of a specific favored track.
	 * @var string
	 */
	public const FAVORITE_TRACK_USERS = 'favoriteTrackUsers';
}
