<?php 

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class ExceptionListener implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = [
            'status' => 'error',
            'message' => 'An unexpected error occurred'
        ];

        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            $response['message'] = $exception->getMessage();
        } elseif ($exception instanceof NotFoundHttpException) {
            $statusCode = Response::HTTP_NOT_FOUND;
            $response['message'] = 'Resource not found';
        } elseif ($exception instanceof BadRequestHttpException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            $response['message'] = $exception->getMessage();
        } elseif ($exception instanceof AccessDeniedHttpException) {
            $statusCode = Response::HTTP_FORBIDDEN;
            $response['message'] = 'Access denied';
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $event->setResponse(new JsonResponse($response, $statusCode));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
