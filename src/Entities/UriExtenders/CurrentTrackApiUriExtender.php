<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

class CurrentTrackApiUriExtender extends AbstractApiUriExtender
{
	/** @var CurrentTrackEntity */
	private CurrentTrackEntity $currentTrack;

	/** @var StationEntity */
	private StationEntity $station;

	/** @var null|FavoriteEntity */
	private ?FavoriteEntity $favorite;

	public function __construct( ApiUriBuilderInterface $apiUriBuilder, CurrentTrackEntity $currentTrack, StationEntity $station, ?FavoriteEntity $favorite )
	{
		parent::__construct( $apiUriBuilder );
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
		$this->currentTrack->canonicalUri = $this->apiUriBuilder->buildCurrentTrackUri( $this->station->id );
	}

	private function addStationUri(): void
	{
		$this->currentTrack->stationUri = $this->apiUriBuilder->buildStationUri( $this->station->id );
	}

	private function addFavoriteUri(): void
	{
		$this->currentTrack->favoriteUri = null === $this->favorite
			? null
			: $this->apiUriBuilder->buildFavoriteUri( $this->favorite->id );
	}
}
