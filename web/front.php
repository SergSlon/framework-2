<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Reference;

/**
 * SC - Service container (Dependency Injection container)
 */

// Service container (DI stuff)
$sc = include __DIR__ . '/../src/container.php';
// Create a mapping - each URL pattern will be mapped to the page file
$sc->setParameter('routes', include __DIR__.'/../src/app.php');

// Form the request from all possible sources: $_GET, $_POST, $_FILE, $_COOKIE, $_SESSION
// TEST with command-line
//$request = Request::create('/is-leap-year/2015');
$request = Request::createFromGlobals();

// Custom listener in front controller
$sc->register('listener.string_response', 'Simplex\StringResponseListener');
$sc->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')]);

// Setting a parameters via ServiceContainer
$sc->setParameter('debug', true);
echo $sc->getParameter('debug');
$sc->setParameter('charset', 'UTF-777');

/** End of SC - Service Container */


$response = $sc->get('framework')->handle($request);

// TEST with command-line
//echo $response;
$response->send();
