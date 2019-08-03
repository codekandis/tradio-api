<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Http\UriBuilders;

use CodeKandis\Tiphy\Http\UriBuilders\AbstractUriBuilder;

class ApiUriBuilder extends AbstractUriBuilder
{
	public function getIndexUri(): string
	{
		return $this->getUri( 'index' );
	}

	public function getStationsUri(): string
	{
		return $this->getUri( 'stations' );
	}

	public function getStationUri( string $id ): string
	{
		return $this->getUri( 'station', $id );
	}

	public function getCurrentTrackUri( string $stationId ): string
	{
		return $this->getUri( 'currentTrack', $stationId );
	}
}
