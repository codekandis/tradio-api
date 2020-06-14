<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi;

use CodeKandis\SentryClient\SentryClient;
use CodeKandis\Tiphy\Actions\ActionDispatcher;
use CodeKandis\TiphySentryClientIntegration\Throwables\Handlers\InternalServerErrorThrowableHandler;
use CodeKandis\TradioApi\Configurations\ConfigurationRegistry;
use function error_reporting;
use function ini_set;
use const E_ALL;

/**
 * Represents the bootstrap script of the project.
 *
 * @package codekandis/tradio-api
 * @author  Christian Ramelow <info@codekandis.net>
 */
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );
ini_set( 'html_errors', 'Off' );

require_once __DIR__ . '/../vendor/autoload.php';

/** @var ConfigurationRegistry $configurationRegistry */
$configurationRegistry = ConfigurationRegistry::_();

$sentryClient = new SentryClient( $configurationRegistry->getSentryClientConfiguration() );
$sentryClient->register();

$routesConfiguration = $configurationRegistry->getRoutesConfiguration();
$throwableHandler    = new InternalServerErrorThrowableHandler( $sentryClient );
$actionDispatcher    = new ActionDispatcher( $routesConfiguration, $throwableHandler );
$actionDispatcher->dispatch();
