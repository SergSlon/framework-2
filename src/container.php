<?php
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$sc = new ContainerBuilder();


// Context is needed to enforce method requirements
$sc->register('context', 'Symfony\Component\Routing\RequestContext');
// Create a Url Matcher that will take URL paths and convert them to the internal routes;
// '%routes%' was earlier a variable '$routes' created in front controller
$sc->register('matcher', 'Symfony\Component\Routing\Matcher\UrlMatcher')
    ->setArguments([
        '%routes%',
        new Reference('context')
    ]);
// The resolver will take care of the lazy loading of our controller classes
$sc->register('resolver', 'Symfony\Component\HttpKernel\Controller\ControllerResolver');


$sc->register('listener.router', 'Symfony\Component\HttpKernel\EventListener\RouterListener')
    ->setArguments([new Reference('matcher')]);

$sc->register('listener.response', 'Symfony\Component\HttpKernel\EventListener\ResponseListener')
    ->setArguments(['UTF-8']);
// Defining object definition (if put above - won't change the result; will be overridden)
$sc->register('listener.response', 'Symfony\Component\HttpKernel\EventListener\ResponseListener')
    ->setArguments(['%charset%']);

$sc->register('listener.exception', 'Symfony\Component\HttpKernel\EventListener\ExceptionListener')
    ->setArguments(['Calendar\\Controller\\ErrorController::exceptionAction']);


// Subscribe to a couple of events with the EventDispatcher component
// For example: Introducing ExceptionListener to handle 404's and 500's,
//              Register the plain text StringResponseListener
$sc->register('dispatcher', 'Symfony\Component\EventDispatcher\EventDispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.router')])
    ->addMethodCall('addSubscriber', [new Reference('listener.response')])
    ->addMethodCall('addSubscriber', [new Reference('listener.exception')]);


$sc->register('framework', 'Simplex\Framework')
    ->setArguments([
        new Reference('dispatcher'),
        new Reference('resolver')
    ]);

return $sc;
