<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Http\Readers;

use CodeKandis\ConstantsClassesTranslator\ConstantsClassesTranslator;
use CodeKandis\Tiphy\Http\Requests\Methods;
use CodeKandis\TradioApi\Errors\CurlErrorCodes;
use CodeKandis\TradioApi\Errors\CurlErrorMessages;
use CodeKandis\TradioApi\Errors\CurlException;
use DOMDocument;
use DOMXPath;
use function curl_close;
use function curl_errno;
use function curl_exec;
use function curl_init;
use function curl_setopt_array;
use function mb_strtolower;
use const CURLOPT_CUSTOMREQUEST;
use const CURLOPT_FAILONERROR;
use const CURLOPT_HEADER;
use const CURLOPT_RETURNTRANSFER;
use const CURLOPT_URL;
use const CURLOPT_USERAGENT;
use const LIBXML_NOERROR;

class CurrentTrackReader implements CurrentTrackReaderInterface
{
	/**
	 * @return string
	 * @throws CurlException
	 */
	public function read( string $uri, string $xPath ): string
	{
		$curlHandler = curl_init();
		curl_setopt_array(
			$curlHandler,
			[
				CURLOPT_FAILONERROR    => true,
				CURLOPT_URL            => $uri,
				CURLOPT_CUSTOMREQUEST  => Methods::GET,
				CURLOPT_USERAGENT      => 'Mozilla',
				CURLOPT_HEADER         => false,
				CURLOPT_RETURNTRANSFER => true,
			]
		);

		$response = curl_exec( $curlHandler );
		if ( $curlErrorCode = curl_errno( $curlHandler ) )
		{
			$curlErrorMessage = ( new ConstantsClassesTranslator( CurlErrorCodes::class, CurlErrorMessages::class ) )
				->translate( $curlErrorCode );
			throw new CurlException( $curlErrorMessage, $curlErrorCode );
		}
		curl_close( $curlHandler );

		$domDocument = new DOMDocument();
		$domDocument->loadHTML(
			$response,
			LIBXML_NOERROR
		);
		$xPathResult = ( new DOMXPath( $domDocument ) )
			->evaluate( $xPath );

		return mb_strtolower( $xPathResult );
	}
}
