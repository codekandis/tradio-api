<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

class StationUriExtender extends AbstractUriExtender
{
	/** @var StationEntity */
	private $station;

	public function __construct( ApiUriBuilderInterface $uriBuilder, StationEntity $station )
	{
		parent::__construct( $uriBuilder );
		$this->station = $station;
	}

	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addCurrentTrackUri();
		$this->addStationUsersUri();
	}

	private function addCanonicalUri(): void
	{
		$this->station->canonicalUri = $this->uriBuilder->buildStationUri( $this->station->id );
	}

	private function addCurrentTrackUri(): void
	{
		$this->station->currentTrackUri = $this->uriBuilder->buildCurrentTrackUri( $this->station->id );
	}

	private function addStationUsersUri(): void
	{
		$this->station->usersUri = $this->uriBuilder->buildStationUsersUri( $this->station->id );
	}
}
