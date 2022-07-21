<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Readers;

/**
 * Represents the interface of any current track name reader.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface CurrentTrackNameReaderInterface
{
	/**
	 * Reads the currently playing track name specified by a URI and a XPath selector.
	 * @param string $uri The URI to read the currently playing track name from.
	 * @param string $xPathSelector The XPath selector used to read the currently playing track name.
	 * @return string The currently playing track name if found, otherwise null.
	 * @throws TracklistNotReadableException The currently playing track name is not readable.
	 */
	public function read( string $uri, string $xPathSelector ): string;
}
