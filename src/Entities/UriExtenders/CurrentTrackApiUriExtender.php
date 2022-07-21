<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\CurrentTrackEntity;
use CodeKandis\TradioApi\Entities\FavoriteTrackEntity;
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
	 * Stores the favored track representing the currently playing track.
	 * @var ?FavoriteTrackEntity
	 */
	private ?FavoriteTrackEntity $favoriteTrack;

	/**
	 * Constructor method.
	 * @param ApiUriBuilderInterface $apiUriBuilder The API uri builder the URI extension depends on.
	 * @param CurrentTrackEntity $currentTrack The currently playing track to extend its URIs.
	 * @param StationEntity $station The station currently playing the track.
	 * @param null|FavoriteTrackEntity $favoriteTrack The favored track representing the currently playing track.
	 */
	public function __construct( ApiUriBuilderInterface $apiUriBuilder, CurrentTrackEntity $currentTrack, StationEntity $station, ?FavoriteTrackEntity $favoriteTrack )
	{
		parent::__construct( $apiUriBuilder );

		$this->currentTrack = $currentTrack;
		$this->station      = $station;
		$this->favoriteTrack     = $favoriteTrack;
	}

	/**
	 * {@inheritDoc}
	 */
	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addStationUri();
		$this->addFavoriteTrackUri();
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
	 * Adds the URI of the favored track representing the currently playing track.
	 */
	private function addFavoriteTrackUri(): void
	{
		$this->currentTrack->favoriteTrackUri = null === $this->favoriteTrack
			? null
			: $this->apiUriBuilder->buildFavoriteTrackUri( $this->favoriteTrack->id );
	}
}
