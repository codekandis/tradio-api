<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Readers;

/**
 * Represents the interface of any currently playing track name reader.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface CurrentTrackNameReaderInterface
{
	/**
	 * Reads the currently playing track name specified by a tracklist URI and a selector.
	 * @param string $tracklistUri The URI of the tracklist to extract the currently playing track name from.
	 * @param string $selector The XPath selector used to extract the currently playing track name.
	 * @return string The currently playing track name if found, otherwise null.
	 * @throws TracklistNotReadableException The currently playing track name is not readable.
	 */
	public function read( string $tracklistUri, string $selector ): string;
}
