<?php declare(strict_types=1);

namespace App\Application\Http\Request\ParamConverter;

use App\Application\Service\Request\Extractor\BasicRequestExtractor;
use App\Domain\Entity\Client;
use App\Infrastructure\Repository\ClientRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class ClientConverter implements ParamConverterInterface
{
    private ClientRepository $clientRepository;
    private BasicRequestExtractor $basicRequestExtractor;

    public function __construct(ClientRepository $clientRepository, BasicRequestExtractor $basicRequestExtractor)
    {
        $this->clientRepository = $clientRepository;
        $this->basicRequestExtractor = $basicRequestExtractor;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $credentials = $this->basicRequestExtractor->get($request);
        [$clientId, $clientSecret] = explode(':', $credentials);
        $client = $this->clientRepository->findByCredentials($clientId, $clientSecret);

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
