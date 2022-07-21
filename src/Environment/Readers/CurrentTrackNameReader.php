<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Readers;

use CodeKandis\CurlyBrace\Headers\RequestHeader;
use CodeKandis\CurlyBrace\HttpRequest;
use DOMDocument;
use DOMXPath;
use ReflectionException;
use function mb_strtolower;
use function sprintf;
use const LIBXML_NOERROR;

/**
 * Represents a current track reader.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurrentTrackNameReader implements CurrentTrackNameReaderInterface
{
	/**
	 * Represents the error message if a tracklist is not readable.
	 * @var string
	 */
	protected const ERROR_TRACKLIST_NOT_READABLE = 'The tracklist is not readable. [%s] %s';

	/**
	 * Represents the error message if a currently playing track name is not extractable.
	 * @var string
	 */
	protected const ERROR_CURRENT_TRACK_NAME_NOT_EXTRACTABLE = 'The currently playing track name is not extractable.';

	/**
	 * Reads the tracklist from a specific URI.
	 * @param string $uri The URI to read the tracklist from.
	 * @return string The tracklist.
	 * @throws TracklistNotReadableException The tracklist is not readable.
	 */
	private function readTrackList( string $uri ): string
	{
		$request = new HttpRequest( $uri );
		$request->getHeaders()
				->add(
					new RequestHeader( 'user-agent', 'Mozilla' )
				);
		$requestResult = $request->send();

		if ( null !== $requestResult->getError() )
		{
			throw new TracklistNotReadableException(
				sprintf(
					static::ERROR_TRACKLIST_NOT_READABLE,
					$requestResult
						->getError()
						->getCode(),
					$requestResult
						->getError()
						->getMessage()
				)
			);
		}

		return $requestResult
			->getResponse()
			->getPayload();
	}

	/**
	 * Extracts the currently playing track name from the tracklist.
	 * @param string $trackList The tracklist to read from.
	 * @param string $xPathSelector The XPath selector used to read the currently playing track name.
	 * @return string The currently playing track name.
	 * @throws CurrentTrackNameNotExtractableException The currently playing track name is not extractable.
	 */
	private function extractCurrentTrackName( string $trackList, string $xPathSelector ): string
	{
		$domDocument = new DOMDocument();
		$domDocument->loadHTML( $trackList, LIBXML_NOERROR );

		$currentTrackName = ( new DOMXPath( $domDocument ) )
			->evaluate( $xPathSelector );

		if ( '' === $currentTrackName )
		{
			throw new TracklistNotReadableException( static::ERROR_CURRENT_TRACK_NAME_NOT_EXTRACTABLE );
		}

		return mb_strtolower( $currentTrackName );
	}

	/**
	 * {@inheritDoc}
	 * @throws TracklistNotReadableException The tracklist is not readable.
	 * @throws CurrentTrackNameNotExtractableException The currently playing track name is not extractable.
	 */
	public function read( string $uri, string $xPathSelector ): string
	{
		$tracklist = $this->readTracklist( $uri );

		return $this->extractCurrentTrackName( $tracklist, $xPathSelector );
	}
}
