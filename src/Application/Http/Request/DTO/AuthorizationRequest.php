<?php

declare(strict_types=1);

namespace App\Application\Http\Request\DTO;

use App\Application\Service\Request\Host\HostComparatorInterface;
use App\Domain\Client\Entity\Client;
use App\Domain\Scope\Entity\Scope;
use LSBProject\RequestBundle\Configuration\Entity;
use LSBProject\RequestBundle\Configuration\RequestStorage;
use LSBProject\RequestBundle\Request\AbstractRequest;
use OpenApi\Annotations\Property;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @RequestStorage({RequestStorage::QUERY})
 */
class AuthorizationRequest extends AbstractRequest
{
    public const RESPONSE_TYPE_CODE = 'code';
    public const RESPONSE_TYPE_TOKEN = 'token';
    public const RESPONSE_TYPES = [
        self::RESPONSE_TYPE_TOKEN,
        self::RESPONSE_TYPE_CODE,
    ];

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(AuthorizationRequest::RESPONSE_TYPES)
     */
    public string $responseType;

    /**
     * @Assert\NotBlank()
     * @Property(type="string")
     * @Entity(options={"id": "client_id"})
     */
    public Client $client;

    /**
     * @Assert\Url()
     */
    public string $redirectUri = '';
    public string $state = '';
    public string $scope = Scope::INFO;

    public function validate(ContainerInterface $container): bool
    {
        return $container->get(HostComparatorInterface::class)->equals($this->redirectUri, $this->client->getHost());
    }

    public function getErrorMessage(): string
    {
        return 'Invalid redirect url provided';
    }
}
