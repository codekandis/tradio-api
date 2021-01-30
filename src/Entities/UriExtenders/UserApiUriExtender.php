<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

class UserApiUriExtender extends AbstractApiUriExtender
{
	/** @var UserEntity */
	private UserEntity $user;

	public function __construct( ApiUriBuilderInterface $apiUriBuilder, UserEntity $user )
	{
		parent::__construct( $apiUriBuilder );
		$this->user = $user;
	}

	public function extend(): void
	{
		$this->addCanonicalUri();
		$this->addUserStationsUri();
		$this->addUserFavoritesUri();
	}

	private function addCanonicalUri(): void
	{
		$this->user->canonicalUri = $this->apiUriBuilder->buildUserUri( $this->user->id );
	}

	private function addUserStationsUri(): void
	{
		$this->user->stationsUri = $this->apiUriBuilder->buildUserStationsUri( $this->user->id );
	}

	private function addUserFavoritesUri(): void
	{
		$this->user->favoritesUri = $this->apiUriBuilder->buildUserFavoritesUri( $this->user->id );
	}
}
