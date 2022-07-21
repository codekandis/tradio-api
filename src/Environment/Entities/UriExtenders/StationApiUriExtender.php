<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Environment\Entities\UriExtenders;

use CodeKandis\TradioApi\Api\Http\UriBuilders\ApiUriBuilderInterface;
use CodeKandis\TradioApi\Environment\Entities\StationEntity;

/**
 * Represents a station API URI extender.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class StationApiUriExtender extends AbstractApiUriExtender
{
	/**
	 * Stores the user to extend its URIs.
	 * @var StationEntity
	 */
	private StationEntity $station;

	/**
	 * Constructor method.
	 * @param ApiUriBuilderInterface $apiUriBuilder The API uri builder the URI extension depends on.
	 * @param StationEntity $station The station to extend its URIs.
	 */
	public function __construct( ApiUriBuilderInterface $apiUriBuilder, StationEntity $station )
	{
		parent::__construct( $apiUriBuilder );

		$this->station = $station;
	}

	/**
	 * {@inheritDoc}
	 */
	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addCurrentTrackUri();
		$this->addStationUsersUri();
	}

	/**
	 * Adds the canonical URI of the station.
	 */
	private function addCanonicalUri(): void
	{
		$this->station->canonicalUri = $this->apiUriBuilder->buildStationUri( $this->station->id );
	}

	/**
	 * Adds the URI of the currently playing track.
	 */
	private function addCurrentTrackUri(): void
	{
		$this->station->currentTrackUri = $this->apiUriBuilder->buildCurrentTrackUri( $this->station->id );
	}

	/**
	 * Adds the URI of the users who favored the station.
	 */
	private function addStationUsersUri(): void
	{
		$this->station->usersUri = $this->apiUriBuilder->buildStationUsersUri( $this->station->id );
	}
}
