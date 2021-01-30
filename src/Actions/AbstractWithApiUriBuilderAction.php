<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Actions;

use CodeKandis\Tiphy\Actions\AbstractAction;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilder;
use CodeKandis\TradioApi\Http\UriBuilders\ApiUriBuilderInterface;

abstract class AbstractWithApiUriBuilderAction extends AbstractAction
{
	/** @var ApiUriBuilderInterface */
	private ApiUriBuilderInterface $apiUriBuilder;

	protected function getApiUriBuilder(): ApiUriBuilderInterface
	{
		return $this->apiUriBuilder ??
			   $this->apiUriBuilder = new ApiUriBuilder(
				   ConfigurationRegistry::_()->getUriBuilderConfiguration()
			   );
	}
}
