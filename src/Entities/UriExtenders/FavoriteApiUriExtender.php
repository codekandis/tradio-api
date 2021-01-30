<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\FavoriteEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

class FavoriteApiUriExtender extends AbstractApiUriExtender
{
	/** @var FavoriteEntity */
	private FavoriteEntity $favorite;

	public function __construct( ApiUriBuilderInterface $apiUriBuilder, FavoriteEntity $favorite )
	{
		parent::__construct( $apiUriBuilder );
		$this->favorite = $favorite;
	}

	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addFavoriteUsersUri();
	}

	private function addCanonicalUri(): void
	{
		$this->favorite->canonicalUri = $this->apiUriBuilder->buildFavoriteUri( $this->favorite->id );
	}

	private function addFavoriteUsersUri(): void
	{
		$this->favorite->usersUri = $this->apiUriBuilder->buildFavoriteUsersUri( $this->favorite->id );
	}
}
