<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Read;

use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Entities\IndexEntity;
use CodeKandis\TradioApi\Entities\UriExtenders\IndexUriExtender;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;
use ReflectionException;

class GetIndexAction extends AbstractAction
{
	/** @var ApiUriBuilder */
	private $uriBuilder;

	private function getUriBuilder(): ApiUriBuilder
	{
		if ( null === $this->uriBuilder )
		{
			$uriBuilderConfiguration = ConfigurationRegistry::_()->getUriBuilderConfiguration();
			$this->uriBuilder        = new ApiUriBuilder( $uriBuilderConfiguration );
		}

		return $this->uriBuilder;
	}

	/**
	 * @throws ReflectionException
	 */
	public function execute(): void
	{
		$index = new IndexEntity;
		$this->extendUris( $index );

		$responderData = [
			'index' => $index,
		];
		( new JsonResponder( StatusCodes::OK, $responderData ) )
			->respond();
	}

	private function extendUris( $index ): void
	{
		$uriBuilder = $this->getUriBuilder();
		( new IndexUriExtender( $uriBuilder, $index ) )
			->extend();
	}
}
