<?php

declare(strict_types=1);

namespace App\Application\Http\Middleware\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['processException', 10],
            ],
        ];
    }

    public function processException(ExceptionEvent $event): void
    {
        $event->getThrowable();
    }
}
