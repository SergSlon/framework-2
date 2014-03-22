<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;

// Form the request from all possible sources: $_GET, $_POST, $_FILE, $_COOKIE, $_SESSION
// TEST with command-line
//$request = Request::create('/is-leap-year/2015');
$request = Request::createFromGlobals();

// Create a mapping - each URL pattern will be mapped to the page file
$routes = include __DIR__ . '/../src/app.php';

// Context is needed to enforce method requirements
$context = new Routing\RequestContext();

// Create a Url Matcher that will take URL paths and convert them to the internal routes
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

// The resolver will take care of the lazy loading of our controller classes
$resolver = new HttpKernel\Controller\ControllerResolver();

// Subscribe to a couple of events with the EventDispatcher Component
$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher));

// Introducing ExceptionListener to handle 404's and 500's
$dispatcher->addSubscriber(new HttpKernel\EventListener\ExceptionListener('Calendar\\Controller\ErrorController::exceptionAction'));

// Register the plain text response listener
$dispatcher->addSubscriber(new Simplex\StringResponseListener());

$framework = new Simplex\Framework($dispatcher, $resolver);

$response = $framework->handle($request);
$dispatcher->addSubscriber(new HttpKernel\EventListener\ResponseListener('UTF-8'));

// TEST with command-line
//echo $response;
$response->send();




