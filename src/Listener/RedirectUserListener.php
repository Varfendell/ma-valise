<?php

namespace App\Listener;

use App\Entity\User;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class RedirectUserListener
 * @package AppBundle\EventListener
 */
class RedirectUserListener
{
    private $tokenStorage;
    private $router;

    /**
     * RedirectUserListener constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param RouterInterface $router
     */
    public function __construct(TokenStorageInterface $tokenStorage, RouterInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    /**
     * @param ResponseEvent $event
     */
    public function onKernelRequest(ResponseEvent $event)
    {
        if ($this->isUserLogged() && $event->isMasterRequest()) {
            /** @var User $user */
            $user = $this->tokenStorage->getToken()->getUser();
            $currentRoute = $event->getRequest()->attributes->get('_route');
            if ($this->isAuthenticatedUserOnAnonymousPage($currentRoute)) {
                $response = new RedirectResponse($this->router->generate('app_default_index'));
                $event->setResponse($response);
            }
        }
    }

    /**
     * @return bool
     */
    protected function isUserLogged()
    {
        $token = $this->tokenStorage->getToken();
        if (is_null($token)) {
            return false;
        }
        $user = $token->getUser();
        return $user instanceof User;
    }

    /**
     * @param $currentRoute
     * @return bool
     */
    protected function isAuthenticatedUserOnAnonymousPage($currentRoute)
    {
        return in_array(
            $currentRoute,
            ['fos_user_security_login', 'fos_user_resetting_request', 'app_user_registration']
        );
    }
}
