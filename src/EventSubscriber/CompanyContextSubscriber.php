<?php

namespace App\EventSubscriber;

use App\Security\CompanyContext;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Bundle\SecurityBundle\Security;

class CompanyContextSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Security $security,
        private CompanyContext $companyContext
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onRequest',
        ];
    }

    public function onRequest(RequestEvent $event): void
    {
        // Only run once per request
        if (!$event->isMainRequest()) {
            return;
        }

        $user = $this->security->getUser();

        if (!$user) {
            return;
        }

        // We intentionally do NOT type-hint User yet
        if (!method_exists($user, 'getCompany')) {
            return;
        }

        $this->companyContext->setCompany($user->getCompany());
    }
}
