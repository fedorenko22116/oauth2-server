<?php declare(strict_types=1);

namespace App\Security;

use App\Repository\UserRepository;
use App\Service\Token\TokenFacadeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JWTAuthenticator extends AbstractGuardAuthenticator
{
    private TokenFacadeInterface $tokenFacade;
    private UserRepository $userRepository;

    public function __construct(TokenFacadeInterface $tokenFacade, UserRepository $userRepository)
    {
        $this->tokenFacade = $tokenFacade;
        $this->userRepository = $userRepository;
    }

    public function start(Request $request, AuthenticationException $authException = null): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Authentication Required'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request): bool
    {
        return $request->headers->has('Authorization') &&
            preg_match('/^Bearer\s(.*)/', $request->headers->get('Authorization'));
    }

    public function getCredentials(Request $request): string
    {
        return preg_replace('/Bearer\s/', '', $request->headers->get('Authorization'));
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        $token = $this->tokenFacade->decode($credentials);

        if (!$token) {
            return null;
        }

        return $this->userRepository->findOneByName($token->username);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return (bool) $this->tokenFacade->decode($credentials);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse([
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        return null;
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }
}
