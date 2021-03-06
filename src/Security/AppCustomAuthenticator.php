<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * Class AppCustomAuthenticator
 * @package App\Security
 */
class AppCustomAuthenticator extends AbstractFormLoginAuthenticator
{
	use TargetPathTrait;
	/** @var EntityManagerInterface */
    private EntityManagerInterface $entityManager;
	/** @var UrlGeneratorInterface */
    private UrlGeneratorInterface $urlGenerator;
	/** @var CsrfTokenManagerInterface */
    private CsrfTokenManagerInterface $csrfTokenManager;
	/** @var UserPasswordEncoderInterface */
    private UserPasswordEncoderInterface $encoder;

	public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $encoder)
	{
		$this->entityManager = $entityManager;
		$this->urlGenerator = $urlGenerator;
		$this->csrfTokenManager = $csrfTokenManager;
		$this->encoder = $encoder;
	}

	public function supports(Request $request)
	{
		return 'login' === $request->attributes->get('_route') && $request->isMethod('POST');
	}

	public function getCredentials(Request $request)
	{
		$credentials = $request->request->get('authentication');
		$credentials['csrf_token'] = $request->request->get('_csrf_token');
		$request->getSession()->set(Security::LAST_USERNAME, $credentials['email']);

		return $credentials;
	}

	public function getUser($credentials, UserProviderInterface $userProvider)
	{
		$token = new CsrfToken('authenticate', $credentials['csrf_token']);
		if (!$this->csrfTokenManager->isTokenValid($token)) {
			throw new InvalidCsrfTokenException();
		}

		$user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

		if (!$user) {
			// fail authentication with a custom error
			throw new CustomUserMessageAuthenticationException('Email could not be found.');
		}

		return $user;
	}

	/**
	 * @param mixed $credentials
	 * @param UserInterface $user
	 * @return bool|void
	 * @throws Exception
	 */
	public function checkCredentials($credentials, UserInterface $user)
	{
		return true;//return $this->encoder->isPasswordValid($user, $credentials['password']);
	}

	/**
	 * @param Request $request
	 * @param TokenInterface $token
	 * @param string $providerKey
	 * @return RedirectResponse|Response|null
	 * @throws Exception
	 */
	public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
	{
		if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
			return new RedirectResponse($targetPath);
		}

		return new RedirectResponse($this->urlGenerator->generate('app_common_welcome_accueil'));
	}

	protected function getLoginUrl()
	{
		return $this->urlGenerator->generate('login');
	}
}
