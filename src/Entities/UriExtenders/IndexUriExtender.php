<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\IndexEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;

class IndexUriExtender extends AbstractUriExtender
{
	/** @var IndexEntity */
	private $index;

	public function __construct( ApiUriBuilder $uriBuilder, IndexEntity $index )
	{
		parent::__construct( $uriBuilder );
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
		$this->index->canonicalUri = $this->uriBuilder->getIndexUri();
	}

	private function addStationsUri(): void
	{
		$this->index->stationsUri = $this->uriBuilder->getStationsUri();
	}

	private function addUsersUri(): void
	{
		$this->index->usersUri = $this->uriBuilder->getUsersUri();
	}

	private function addFavoritesUri(): void
	{
		$this->index->favoritesUri = $this->uriBuilder->getFavoritesUri();
	}
}
