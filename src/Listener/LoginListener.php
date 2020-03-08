<?php

namespace App\Listener;

use App\Entity\User;
use App\Manager\UserManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

/**
 * Class LoginListener
 * @package App\EventListener
 */
class LoginListener
{
    protected $userManager;
    protected $session;
    protected $requestStack;

    /**
     * LoginListener constructor.
     * @param SessionInterface $session
     * @param RequestStack $requestStack
     * @param UserManager $userManager
     */
    public function __construct(
        SessionInterface $session,
        RequestStack $requestStack,
        UserManager $userManager
    ) {
        $this->userManager = $userManager;
        $this->session = $session;
        $this->requestStack = $requestStack;
    }

    /**
     * onAuthenticationFailureLookAccount triggered when AuthenticationFailure is dispatched
     * In purpose of locking the user account
     *
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailureLookAccount(AuthenticationFailureEvent $event)
    {
        $username = $event->getAuthenticationToken()->getUsername();
        /** @var User $user */
        $user = $this->userManager->findUserByUsernameOrEmail($username);
        if ($user) {
            if ($this->session->get('loginAttempts')) {
                $attempts = $this->session->get('loginAttempts');
                $this->session->set('loginAttempts', ++$attempts);
                if ($attempts == AuthenticationHelper::MAX_ATTEMPTS) {
                    $user->setEnabled(false);
                    $this->userManager->updateUser($user);
                    $this->session->remove('loginAttempts');

                    $this->traceService->logTrace(
                        $this->requestStack->getCurrentRequest(),
                        $user,
                        TraceHelper::FUNCTIONALITY_AUTHENTICATION_LOCK_ACCOUNT,
                        TraceHelper::RESULT_OK
                    );
                }
            } else {
                $this->session->set('loginAttempts', AuthenticationHelper::FIRST_ATTEMPT_COUNT);
            }
        }
    }
}
