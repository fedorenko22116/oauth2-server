<?php declare(strict_types=1);

namespace App\Application\Http\Security;

use App\Application\Service\Request\Extractor\BearerRequestExtractor;
use App\Domain\Service\Token\TokenEncrypterInterface;
use App\Infrastructure\Repository\UserRepository;
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
    private TokenEncrypterInterface $tokenEncrypter;
    private UserRepository $userRepository;
    private BearerRequestExtractor $bearerRequestExtractor;

    public function __construct(
        TokenEncrypterInterface $tokenEncrypter,
        UserRepository $userRepository,
        BearerRequestExtractor $bearerRequestExtractor
    ) {
        $this->tokenEncrypter = $tokenEncrypter;
        $this->userRepository = $userRepository;
        $this->bearerRequestExtractor = $bearerRequestExtractor;
    }

    public function start(Request $request, AuthenticationException $authException = null): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Authentication Required'
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request): bool
    {
        return $this->bearerRequestExtractor->has($request);
    }

    public function getCredentials(Request $request): string
    {
        return $this->bearerRequestExtractor->get($request);
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        $token = $this->tokenEncrypter->decode($credentials);

        if (!$token) {
            return null;
        }

        return $this->userRepository->findOneByName($token->username);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return (bool) $this->tokenEncrypter->decode($credentials);
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
