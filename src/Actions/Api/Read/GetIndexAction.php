<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions\Api\Read;

use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\Tiphy\Http\Responses\JsonResponder;
use CodeKandis\Tiphy\Http\Responses\StatusCodes;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Entities\IndexEntity;
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
		$this->addIndexUri( $index );
		$this->addStationsUri( $index );

		$responderData = [
			'index' => $index,
		];
		$responder     = new JsonResponder( StatusCodes::OK, $responderData );
		$responder->respond();
	}

	private function addIndexUri( IndexEntity $index ): void
	{
		$index->uri = $this->getUriBuilder()->getIndexUri();
	}

	private function addStationsUri( IndexEntity $index ): void
	{
		$index->stationsUri = $this->getUriBuilder()->getStationsUri();
	}
}
