<?php
namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\FlattenException;

class ErrorController
{
    public function exceptionAction(FlattenException $exception)
    {
        $msg = 'Something went wrong! (' . $exception->getMessage() . ')';

        if ($exception->getStatusCode() == 404) {
            $msg = 'Whoops, no such page :(' . '<br>' . 'Error message: ' . $exception->getMessage();
        } elseif ($exception->getStatusCode() == 500) {
            $msg = 'Problem with server?' . '<br>' . 'Error message: ' . $exception->getMessage();
        }

        return new Response($msg, $exception->getStatusCode());
    }
}
