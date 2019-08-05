<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;

class CurrentTrackUriExtender extends AbstractUriExtender
{
	/** @var CurrentTrackEntity */
	private $currentTrack;

	/** @var StationEntity */
	private $station;

	/** @var ?FavoriteEntity */
	private $favorite;

	public function __construct( ApiUriBuilder $uriBuilder, CurrentTrackEntity $currentTrack, StationEntity $station, ?FavoriteEntity $favorite )
	{
		parent::__construct( $uriBuilder );
		$this->currentTrack = $currentTrack;
		$this->station      = $station;
		$this->favorite     = $favorite;
	}

	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addStationUri();
		$this->addFavoriteUri();
	}

	private function addCanonicalUri(): void
	{
		$this->currentTrack->uri = $this->uriBuilder->getCurrentTrackUri( $this->station->id );
	}

	private function addStationUri(): void
	{
		$this->currentTrack->stationUri = $this->uriBuilder->getStationUri( $this->station->id );
	}

	private function addFavoriteUri(): void
	{
		$this->currentTrack->favoriteUri = null === $this->favorite
			? null
			: $this->uriBuilder->getFavoriteUri( $this->favorite->id );
	}
}
