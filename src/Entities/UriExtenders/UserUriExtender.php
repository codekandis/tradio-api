<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Entities\UriExtenders;

use CodeKandis\TradioApi\Entities\UserEntity;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;

class UserUriExtender extends AbstractUriExtender
{
	/** @var UserEntity */
	private $user;

	public function __construct( ApiUriBuilder $uriBuilder, UserEntity $user )
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
		$this->user->uri = $this->uriBuilder->getUserUri( $this->user->id );
	}

	private function addUserStationsUri(): void
	{
		$this->user->stationsUri = $this->uriBuilder->getUserStationsUri( $this->user->id );
	}

	private function addUserFavoritesUri(): void
	{
		$this->user->favoritesUri = $this->uriBuilder->getUserFavoritesUri( $this->user->id );
	}
}
