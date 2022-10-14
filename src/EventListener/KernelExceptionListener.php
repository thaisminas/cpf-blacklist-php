<?php

namespace App\EventListener;


use App\Controller\Exception\BadRequestException;
use Doctrine\ORM\NoResultException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelExceptionListener implements EventSubscriberInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onResultNotFoundException'],
                ['onBadRequestException']
            ]
        ];
    }


    public function onResultNotFoundException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if(!$exception instanceof NoResultException){
            return;
        }

        $event->setResponse(new JsonResponse([
            'message' => $exception->getMessage(),
        ], Response::HTTP_NOT_FOUND));
    }


    public function onBadRequestException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if(!$exception instanceof BadRequestException){
            return;
        }

        $this->logException($exception, \sprintf('Error PHP Exception %s: %s, %s, %s', \get_class($exception),  $exception->getMessage(), $exception->getFile(), $exception->getLine()));

        $event->setResponse(JsonResponse::create(['type' => (new \ReflectionClass($exception))->getShortName(),
        'message' => $exception->getMessage(), ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    public function onUnknownExeception(GetResponseForExceptionEvent $event)
    {
        $e = $event->getException();

        $this->logException($e, \sprintf('Error PHP Exception %s: ', \get_class($e), $e->getMessage(), $e->getFile(), $e->getLine()));

        $response = ['InternalServerError' => true];

        $response['ExceptionType'] = \get_class($e);

        $event->setResponse(JsonResponse::create($response, Response::HTTP_INTERNAL_SERVER_ERROR));
    }


    protected function logException(\Exception $exception, $message): void
    {
        $this->logger->critical($message, [
            'exception' => $exception,
            'tags' => ['error'],
        ]);
    }
}