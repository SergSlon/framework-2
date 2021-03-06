<?php
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('leap_year', new Routing\Route('/is-leap-year/{year}', [
    'year'        => null,
    '_controller' => 'Calendar\\Controller\\LeapYearController::indexAction',
]));

return $routes;