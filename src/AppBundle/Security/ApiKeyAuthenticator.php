<?php

namespace AppBundle\Security;

use AppBundle\Util\JsonResponseUtil;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    protected $response;
    protected $translator;

    /**
     * @param JsonResponseUtil $jsonResponse
     * @param Translator $trans
     */
    public function __construct(JsonResponseUtil $jsonResponse, Translator $trans)
    {
        $this->response = $jsonResponse;
        $this->translator = $trans;
    }

    /**
     * @param Request $request
     * @param string $providerKey
     * @return PreAuthenticatedToken
     */
    public function createToken(Request $request, $providerKey)
    {
        return new PreAuthenticatedToken(
            'anon.',
            $request->headers->get('Authorization'),
            $providerKey
        );
    }

    /**
     * @param TokenInterface $token
     * @param $providerKey
     * @return boolean
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * @param TokenInterface $token
     * @param UserProviderInterface $userProvider
     * @param $providerKey
     * @return null|PreAuthenticatedToken
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof ApiKeyUserProvider) {
            return null;
        }

        $apiKey = $token->getCredentials();
        $username = $userProvider->getUsernameForApiKey($apiKey);
        if (!$username) {
            return null;
        }

        $user = $userProvider->loadUserByUsername($username);
        if (!$user) {
            return null;
        }

        return new PreAuthenticatedToken(
            $user,
            $apiKey,
            $providerKey,
            $user->getRoles()
        );
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return $this->response->error(
            $this->translator->trans('error.unauthorized'),
            Response::HTTP_UNAUTHORIZED
        );
    }
}
