<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Readers;

use CodeKandis\JsonCodec\JsonDecoder;
use CodeKandis\JsonCodec\JsonDecoderOptions;
use DOMDocument;
use DOMXPath;
use Traversable;
use function array_keys;
use function assert;
use function count;
use function explode;
use function is_array;
use function is_int;
use function mb_strtolower;
use function range;
use function sprintf;
use function strlen;
use function strpos;
use function substr;
use function trim;
use const LIBXML_NOERROR;

/**
 * Represents a currently playing track name JSON reader.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurrentTrackNameJsonReader extends AbstractCurrentTrackNameReader
{
	private function xmlEncode( array $arr, bool $encloseInRootNode = true, string $name_for_numeric_keys = 'val' ): string
	{
		if ( empty ( $arr ) )
		{
			return '';
		}
		$is_iterable_compat = function ( $v ): bool
		{
			return is_array( $v ) || ( $v instanceof Traversable );
		};
		$isAssoc            = function ( array $arr ): bool
		{
			if ( [] === $arr )
			{
				return false;
			}

			return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
		};
		$endsWith           = function ( string $haystack, string $needle ): bool
		{
			$length = strlen( $needle );
			if ( $length == 0 )
			{
				return true;
			}

			return ( substr( $haystack, -$length ) === $needle );
		};
		$formatXML          = function ( string $xml ) use ( $endsWith ): string
		{
			$domd                     = new DOMDocument( '1.0', 'UTF-8' );
			$domd->preserveWhiteSpace = false;
			$domd->formatOutput       = true;
			$domd->loadXML( '<root>' . $xml . '</root>' );
			$ret = trim( $domd->saveXML( $domd->getElementsByTagName( "root" )->item( 0 ) ) );
			assert( 0 === strpos( $ret, '<root>' ) );
			assert( $endsWith ( $ret, '</root>' ) );
			$full = trim( substr( $ret, strlen( '<root>' ), -strlen( '</root>' ) ) );
			$ret  = '';
			foreach ( explode( "\n", $full ) as $line )
			{
				if ( substr( $line, 0, 2 ) === '  ' )
				{
					$ret .= substr( $line, 2 ) . "\n";
				}
				else
				{
					$ret .= $line . "\n";
				}
			}
			$ret = trim( $ret );

			return $ret;
		};

		$iterator = $arr;
		$domd     = new DOMDocument ();
		$root     = $domd->createElement( 'root' );
		foreach ( $iterator as $key => $val )
		{
			$ele = $domd->createElement( is_int( $key ) ? $name_for_numeric_keys : $key );
			if ( !empty ( $val ) || $val === '0' )
			{
				if ( $is_iterable_compat ( $val ) )
				{
					$asoc   = $isAssoc ( $val );
					$tmp    = $this->xmlEncode( $val, false, is_int( $key ) ? $name_for_numeric_keys : $key );
					$tmpDom = new DOMDocument();
					@$tmpDom->loadXML( '<root>' . $tmp . '</root>' );
					foreach ( $tmpDom->getElementsByTagName( "root" )->item( 0 )->childNodes ?? [] as $tmp2 )
					{
						$tmp3 = $domd->importNode( $tmp2, true );
						if ( $asoc )
						{
							$ele->appendChild( $tmp3 );
						}
						else
						{
							$root->appendChild( $tmp3 );
						}
					}
					unset ( $tmp, $tmp2, $tmp3, $tmpDom );
					if ( !$asoc )
					{
						continue;
					}
				}
				else
				{
					$ele->textContent = $val;
				}
			}
			$root->appendChild( $ele );
		}
		$domd->preserveWhiteSpace = false;
		$domd->formatOutput       = true;
		$ret                      = trim( $domd->saveXML( $root ) );
		assert( 0 === strpos( $ret, '<root>' ) );
		assert( $endsWith ( $ret, '</root>' ) );
		$ret = trim( substr( $ret, strlen( '<root>' ), -strlen( '</root>' ) ) );
		$ret = $formatXML ( $ret );

		return false === $encloseInRootNode
			? $ret
			: sprintf(
				'<root>%s</root>',
				$ret
			);
	}

	/**
	 * {@inheritDoc}
	 */
	protected function extractCurrentTrackName( string $tracklist, string $selector ): string
	{
		$domDocument = new DOMDocument();
		$domDocument->loadXML(
			$this->xmlEncode(
				( new JsonDecoder() )
					->decode(
						$tracklist,
						new JsonDecoderOptions( JsonDecoderOptions::OBJECT_AS_ARRAY )
					)
			),
			LIBXML_NOERROR
		);

		$currentTrackName = ( new DOMXPath( $domDocument ) )
			->evaluate( $selector );

		if ( '' === $currentTrackName )
		{
			throw new TracklistNotReadableException( static::ERROR_CURRENT_TRACK_NAME_NOT_EXTRACTABLE );
		}

		return mb_strtolower( $currentTrackName );
	}
}
