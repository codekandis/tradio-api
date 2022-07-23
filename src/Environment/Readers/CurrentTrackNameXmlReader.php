<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Readers;

use DOMDocument;
use DOMXPath;
use function mb_strtolower;
use const LIBXML_NOERROR;

/**
 * Represents a currently playing track name XML reader.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurrentTrackNameXmlReader extends AbstractCurrentTrackNameReader
{
	/**
	 * {@inheritDoc}
	 */
	protected function extractCurrentTrackName( string $tracklist, string $selector ): string
	{
		$domDocument = new DOMDocument();
		$domDocument->loadXML( $tracklist, LIBXML_NOERROR );

		$currentTrackName = ( new DOMXPath( $domDocument ) )
			->evaluate( $selector );

		if ( '' === $currentTrackName )
		{
			throw new TracklistNotReadableException( static::ERROR_CURRENT_TRACK_NAME_NOT_EXTRACTABLE );
		}

		return mb_strtolower( $currentTrackName );
	}
}
