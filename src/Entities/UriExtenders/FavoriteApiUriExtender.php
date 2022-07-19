<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

/**
 * Represents a favorite track API URI extender.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class FavoriteApiUriExtender extends AbstractApiUriExtender
{
	/**
	 * Stores the favorite track to extend its URIs.
	 * @var FavoriteEntity
	 */
	private FavoriteEntity $favorite;

	/**
	 * Constructor method.
	 * @param ApiUriBuilderInterface $apiUriBuilder The API uri builder the URI extension depends on.
	 * @param FavoriteEntity $favorite The favorite track to extend its URIs.
	 */
	public function __construct( ApiUriBuilderInterface $apiUriBuilder, FavoriteEntity $favorite )
	{
		parent::__construct( $apiUriBuilder );

		$this->favorite = $favorite;
	}

	/**
	 * {@inheritDoc}
	 */
	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addFavoriteUsersUri();
	}

	/**
	 * Adds the canonical URI of the favorite track.
	 */
	private function addCanonicalUri(): void
	{
		$this->favorite->canonicalUri = $this->apiUriBuilder->buildFavoriteUri( $this->favorite->id );
	}

	/**
	 * Adds the URI of the users who favored the track.
	 */
	private function addFavoriteUsersUri(): void
	{
		$this->favorite->usersUri = $this->apiUriBuilder->buildFavoriteUsersUri( $this->favorite->id );
	}
}
