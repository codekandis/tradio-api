<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\IndexEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

class IndexApiUriExtender extends AbstractApiUriExtender
{
	/** @var IndexEntity */
	private IndexEntity $index;

	public function __construct( ApiUriBuilderInterface $apiUriBuilder, IndexEntity $index )
	{
		parent::__construct( $apiUriBuilder );
		$this->index = $index;
	}

	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addStationsUri();
		$this->addUsersUri();
		$this->addFavoritesUri();
	}

	private function addCanonicalUri(): void
	{
		$this->index->canonicalUri = $this->apiUriBuilder->buildIndexUri();
	}

	private function addStationsUri(): void
	{
		$this->index->stationsUri = $this->apiUriBuilder->buildStationsUri();
	}

	private function addUsersUri(): void
	{
		$this->index->usersUri = $this->apiUriBuilder->buildUsersUri();
	}

	private function addFavoritesUri(): void
	{
		$this->index->favoritesUri = $this->apiUriBuilder->buildFavoritesUri();
	}
}
