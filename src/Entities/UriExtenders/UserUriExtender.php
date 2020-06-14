<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

class UserUriExtender extends AbstractUriExtender
{
	/** @var UserEntity */
	private $user;

	public function __construct( ApiUriBuilderInterface $uriBuilder, UserEntity $user )
	{
		parent::__construct( $uriBuilder );
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
		$this->user->canonicalUri = $this->uriBuilder->buildUserUri( $this->user->id );
	}

	private function addUserStationsUri(): void
	{
		$this->user->stationsUri = $this->uriBuilder->buildUserStationsUri( $this->user->id );
	}

	private function addUserFavoritesUri(): void
	{
		$this->user->favoritesUri = $this->uriBuilder->buildUserFavoritesUri( $this->user->id );
	}
}
