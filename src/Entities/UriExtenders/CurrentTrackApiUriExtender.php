<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Entities\StationEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

/**
 * Represents a current track API URI extender.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class CurrentTrackApiUriExtender extends AbstractApiUriExtender
{
	/**
	 * Stores the currently playing track to extend its URIs.
	 * @var CurrentTrackEntity
	 */
	private CurrentTrackEntity $currentTrack;

	/**
	 * Stores the station currently playing the track.
	 * @var StationEntity
	 */
	private StationEntity $station;

	/**
	 * Stores the favorite representing the currently playing track.
	 * @var ?FavoriteEntity
	 */
	private ?FavoriteEntity $favorite;

	/**
	 * Constructor method.
	 * @param ApiUriBuilderInterface $apiUriBuilder The API uri builder the URI extension depends on.
	 * @param CurrentTrackEntity $currentTrack The currently playing track to extend its URIs.
	 * @param StationEntity $station The station currently playing the track.
	 * @param null|FavoriteEntity $favorite The favorite representing the currently playing track.
	 */
	public function __construct( ApiUriBuilderInterface $apiUriBuilder, CurrentTrackEntity $currentTrack, StationEntity $station, ?FavoriteEntity $favorite )
	{
		parent::__construct( $apiUriBuilder );

		$this->currentTrack = $currentTrack;
		$this->station      = $station;
		$this->favorite     = $favorite;
	}

	/**
	 * {@inheritDoc}
	 */
	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addStationUri();
		$this->addFavoriteUri();
	}

	/**
	 * Adds the canonical URI of the currently playing track.
	 */
	private function addCanonicalUri(): void
	{
		$this->currentTrack->canonicalUri = $this->apiUriBuilder->buildCurrentTrackUri( $this->station->id );
	}

	/**
	 * Adds the URI of the station currently playing the track.
	 */
	private function addStationUri(): void
	{
		$this->currentTrack->stationUri = $this->apiUriBuilder->buildStationUri( $this->station->id );
	}

	/**
	 * Adds the URI of the favorite representing the currently playing track.
	 */
	private function addFavoriteUri(): void
	{
		$this->currentTrack->favoriteUri = null === $this->favorite
			? null
			: $this->apiUriBuilder->buildFavoriteUri( $this->favorite->id );
	}
}
