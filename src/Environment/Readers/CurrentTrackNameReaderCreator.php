<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Readers;

use CodeKandis\TradioApi\Environment\Entities\Enumerations\TracklistTypes;

/**
 * Represents a currently playing track name reader creator.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurrentTrackNameReaderCreator implements CurrentTrackNameReaderCreatorInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function create( string $tracklistType ): ?CurrentTrackNameReaderInterface
	{
		switch ( $tracklistType )
		{
			case TracklistTypes::XML:
			{
				return new CurrentTrackNameXmlReader();
			}
			case TracklistTypes::HTML:
			{
				return new CurrentTrackNameHtmlReader();
			}
			case TracklistTypes::JSON:
			{
				return new CurrentTrackNameJsonReader();
			}
			default:
			{
				return null;
			}
		}
	}
}
