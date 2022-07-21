<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities;

/**
 * Represents the interface of any station.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface StationEntityInterface extends PersistableEntityInterface
{
	/**
	 * Gets the server type of the station.
	 * @return string The server type of the station.
	 */
	public function getServerType(): string;

	/**
	 * Sets the server type of the station.
	 * @param string $serverType The server type of the station.
	 */
	public function setServerType( string $serverType ): void;

	/**
	 * Gets the name of the station.
	 * @return string The name of the station.
	 */
	public function getName(): string;

	/**
	 * Sets the name of the station.
	 * @param string $name The name of the station.
	 */
	public function setName( string $name ): void;

	/**
	 * Gets the URI of the stream of the station.
	 * @return string The URI of the stream of the station.
	 */
	public function getStreamUri(): string;

	/**
	 * Sets the URI of the stream of the station.
	 * @param string $streamUri The URI of the stream of the station.
	 */
	public function setStreamUri( string $streamUri ): void;

	/**
	 * Gets the URI of the tracklist of the station.
	 * @return string The URI of the tracklist of the station.
	 */
	public function getTracklistUri(): string;

	/**
	 * Sets the URI of the tracklist of the station.
	 * @param string $tracklistUri The URI of the tracklist of the station.
	 */
	public function setTracklistUri( string $tracklistUri ): void;

	/**
	 * Gets the XPath to fetch the currently playing track of the station.
	 * @return string The XPath to fetch the currently playing track of the station.
	 */
	public function getCurrentTrackXPath(): string;

	/**
	 * Sets the XPath to fetch the currently playing track of the station.
	 * @param string $currentTrackXPath The XPath to fetch the currently playing track of the station.
	 */
	public function setCurrentTrackXPath( string $currentTrackXPath ): void;

	/**
	 * Gets the URI of the currently playing track of the station.
	 * @return string The URI of the currently playing track.
	 */
	public function getCurrentTrackUri(): string;

	/**
	 * Sets the URI of the currently playing track.
	 * @param string $currentTrackUri The URI of the currently playing track.
	 */
	public function setCurrentTrackUri( string $currentTrackUri ): void;

	/**
	 * Gets the URI of the users who favored the station.
	 * @return string The URI of the users who favored the station.
	 */
	public function getUsersUri(): string;

	/**
	 * Sets the URI of the users who favored the station.
	 * @param string $usersUri The URI of the users who favored the station.
	 */
	public function setUsersUri( string $usersUri ): void;
}
