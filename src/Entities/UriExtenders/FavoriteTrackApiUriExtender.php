<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\FavoriteTrackEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

/**
 * Represents a favored track API URI extender.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoriteTrackApiUriExtender extends AbstractApiUriExtender
{
	/**
	 * Stores the favored track to extend its URIs.
	 * @var FavoriteTrackEntity
	 */
	private FavoriteTrackEntity $favoriteTrack;

	/**
	 * Constructor method.
	 * @param ApiUriBuilderInterface $apiUriBuilder The API uri builder the URI extension depends on.
	 * @param FavoriteTrackEntity $favoriteTrack The favored track to extend its URIs.
	 */
	public function __construct( ApiUriBuilderInterface $apiUriBuilder, FavoriteTrackEntity $favoriteTrack )
	{
		parent::__construct( $apiUriBuilder );

		$this->favoriteTrack = $favoriteTrack;
	}

	/**
	 * {@inheritDoc}
	 */
	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addFavoriteTrackUsersUri();
	}

	/**
	 * Adds the canonical URI of the favored track.
	 */
	private function addCanonicalUri(): void
	{
		$this->favoriteTrack->canonicalUri = $this->apiUriBuilder->buildFavoriteTrackUri( $this->favoriteTrack->id );
	}

	/**
	 * Adds the URI of the users who favored the track.
	 */
	private function addFavoriteTrackUsersUri(): void
	{
		$this->favoriteTrack->usersUri = $this->apiUriBuilder->buildFavoriteTrackUsersUri( $this->favoriteTrack->id );
	}
}
