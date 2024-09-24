<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\TransitionEvent;

class MovieStatusChangeSubscriber implements EventSubscriberInterface
{
    public function handleWatchTransition(TransitionEvent $event): void
    {
        $movie = $event->getSubject();
        $movie->setLastPlayedAt(new \DateTimeImmutable());
    }

    public function handleUnWatchTransition(TransitionEvent $event): void
    {
        $movie = $event->getSubject();
        $movie->setLastPlayedAt(null);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            "workflow.movie_status.transition.watch" => "handleWatchTransition",
            "workflow.movie_status.transition.unwatch" => "handleUnWatchTransition"
        ];
    }
}