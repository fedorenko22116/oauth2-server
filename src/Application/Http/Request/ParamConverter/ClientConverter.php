<?php declare(strict_types=1);

namespace App\Application\Http\Request\ParamConverter;

use App\Domain\Entity\Client;
use App\Infrastructure\Repository\ClientRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class ClientConverter implements ParamConverterInterface
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $credentials = trim(preg_replace('/.*Basic\s/', '', $request->headers->get('Authorization')));
        [$clientId, $clientSecret] = explode(':', $credentials);
        $client = $this->clientRepository->findBy([
            'id' => $clientId,
            'secret' => $clientSecret,
        ]);

        if ($client) {
            $request->attributes->set($configuration->getName(), $client);
        }

        return !!$client;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === Client::class;
    }
}
