<?php
namespace Simplex;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class StringResponseListener implements EventSubscriberInterface
{
    public function onView(GetResponseForControllerResultEvent $event)
    {
        $responseString = $event->getControllerResult();

        // Play with the Response a bit
        $response = new Response();
        $response->headers->set('Content-Type', 'text/plain');
        $response->setContent($responseString);

        if(is_string($responseString)) {
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents()
    {
        return ['kernel.view' => 'onView'];
    }
}
