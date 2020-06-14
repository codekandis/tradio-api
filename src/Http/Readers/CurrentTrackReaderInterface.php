<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Http\Readers;

interface CurrentTrackReaderInterface
{
	public function read( string $uri, string $xPath ): string;
}
