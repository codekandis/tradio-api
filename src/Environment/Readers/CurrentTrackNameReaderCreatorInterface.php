<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Readers;

/**
 * Represents the interface of any currently playing track name reader creator.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
interface CurrentTrackNameReaderCreatorInterface
{
	/**
	 * Creates a currently playing track name reader by a specific tracklist type.
	 * @param string $tracklistType The type of the tracklist.
	 * @return ?CurrentTrackNameReaderInterface The currently playing track name reader if creatable, otherwise null.
	 */
	public function create( string $tracklistType ): ?CurrentTrackNameReaderInterface;
}
