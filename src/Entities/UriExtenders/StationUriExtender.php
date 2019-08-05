<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;

class StationUriExtender extends AbstractUriExtender
{
	/** @var StationEntity */
	private $station;

	public function __construct( ApiUriBuilder $uriBuilder, StationEntity $station )
	{
		parent::__construct( $uriBuilder );
		$this->station = $station;
	}

	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addCurrentTrackUri();
		$this->addStationUsersUri();
		$this->addStationFavoritesUri();
	}

	private function addCanonicalUri(): void
	{
		$this->station->uri = $this->uriBuilder->getStationUri( $this->station->id );
	}

	private function addCurrentTrackUri(): void
	{
		$this->station->currentTrackUri = $this->uriBuilder->getCurrentTrackUri( $this->station->id );
	}

	private function addStationUsersUri(): void
	{
		$this->station->usersUri = $this->uriBuilder->getStationUsersUri( $this->station->id );
	}

	private function addStationFavoritesUri(): void
	{
		$this->station->favoritesUri = $this->uriBuilder->getStationFavoritesUri( $this->station->id );
	}
}
