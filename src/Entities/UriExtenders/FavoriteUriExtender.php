<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

class FavoriteUriExtender extends AbstractUriExtender
{
	/** @var FavoriteEntity */
	private $favorite;

	public function __construct( ApiUriBuilderInterface $uriBuilder, FavoriteEntity $favorite )
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
		$this->favorite->canonicalUri = $this->uriBuilder->buildFavoriteUri( $this->favorite->id );
	}

	private function addFavoriteUsersUri(): void
	{
		$this->favorite->usersUri = $this->uriBuilder->buildFavoriteUsersUri( $this->favorite->id );
	}
}
