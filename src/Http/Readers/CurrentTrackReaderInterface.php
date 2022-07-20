<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Http\Readers;

/**
 * Represents the interface of any current track reader.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface CurrentTrackReaderInterface
{
	/**
	 * Reads the currently playing track specified by a URI and a XPath.
	 * @param string $uri The URI to read the currently playing track from.
	 * @param string $xPath The XPath query how to read the currently playing track.
	 * @return string The currently playing track.
	 */
	public function read( string $uri, string $xPath ): string;
}
