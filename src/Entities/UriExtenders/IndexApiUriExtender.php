<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\IndexEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

/**
 * Represents an index API URI extender.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
class IndexApiUriExtender extends AbstractApiUriExtender
{
	/**
	 * Stores the index to extend its URIs.
	 * @var IndexEntity
	 */
	private IndexEntity $index;

	/**
	 * Constructor method.
	 * @param ApiUriBuilderInterface $apiUriBuilder The API uri builder the URI extension depends on.
	 * @param IndexEntity $index The index to extend its URIs.
	 */
	public function __construct( ApiUriBuilderInterface $apiUriBuilder, IndexEntity $index )
	{
		parent::__construct( $apiUriBuilder );

		$this->index = $index;
	}

	/**
	 * {@inheritDoc}
	 */
	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addStationsUri();
		$this->addUsersUri();
		$this->addFavoritesUri();
	}

	/**
	 * Adds the canonical URI of the index.
	 */
	private function addCanonicalUri(): void
	{
		$this->index->canonicalUri = $this->apiUriBuilder->buildIndexUri();
	}

	/**
	 * Adds the URI of the stations.
	 */
	private function addStationsUri(): void
	{
		$this->index->stationsUri = $this->apiUriBuilder->buildStationsUri();
	}

	/**
	 * Adds the URI of the users.
	 */
	private function addUsersUri(): void
	{
		$this->index->usersUri = $this->apiUriBuilder->buildUsersUri();
	}

	/**
	 * Adds the URI of the favorite tracks.
	 */
	private function addFavoritesUri(): void
	{
		$this->index->favoritesUri = $this->apiUriBuilder->buildFavoritesUri();
	}
}
