<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

class StationApiUriExtender extends AbstractApiUriExtender
{
	/** @var StationEntity */
	private StationEntity $station;

	public function __construct( ApiUriBuilderInterface $apiUriBuilder, StationEntity $station )
	{
		parent::__construct( $apiUriBuilder );
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
		$this->station->canonicalUri = $this->apiUriBuilder->buildStationUri( $this->station->id );
	}

	private function addCurrentTrackUri(): void
	{
		$this->station->currentTrackUri = $this->apiUriBuilder->buildCurrentTrackUri( $this->station->id );
	}

	private function addStationUsersUri(): void
	{
		$this->station->usersUri = $this->apiUriBuilder->buildStationUsersUri( $this->station->id );
	}
}
