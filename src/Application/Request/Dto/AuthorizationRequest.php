<?php declare(strict_types=1);

namespace App\Application\Request\Dto;

use App\Entity\Client;
use App\Domain\Entity\Scope;
use App\Infrastructure\Service\Request\Host\HostComparatorInterface;
use LSBProject\RequestBundle\Configuration\Entity;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AuthorizationRequest extends AbstractRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^code$/")
     */
    public string $responseType;

    /**
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
