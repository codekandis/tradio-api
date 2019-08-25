<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;

class FavoriteUriExtender extends AbstractUriExtender
{
	/** @var FavoriteEntity */
	private $favorite;

	public function __construct( ApiUriBuilder $uriBuilder, FavoriteEntity $favorite )
	{
		parent::__construct( $uriBuilder );
		$this->favorite = $favorite;
	}

	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addFavoriteUsersUri();
	}

	private function addCanonicalUri(): void
	{
		$this->favorite->canonicalUri = $this->uriBuilder->getFavoriteUri( $this->favorite->id );
	}

	private function addFavoriteUsersUri(): void
	{
		$this->favorite->usersUri = $this->uriBuilder->getFavoriteUsersUri( $this->favorite->id );
	}
}
