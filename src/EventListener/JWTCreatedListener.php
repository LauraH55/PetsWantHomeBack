<?php

namespace App\EventListener;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;


class JWTCreatedListener
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    private $security;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack, Security $security)
    {
        $this->requestStack = $requestStack;
        $this->security = $security;
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $payload       = $event->getData();
        $payload['shelter_id'] = $this->security->getUser()->getShelter()->getId();

        $event->setData($payload);

    }
}
