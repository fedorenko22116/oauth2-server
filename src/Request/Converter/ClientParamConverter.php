<?php declare(strict_types=1);

namespace App\Request\Converter;

use App\Constants;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClientParamConverter implements ParamConverterInterface
{
    private ClientRepository $clientRepository;
    private ValidatorInterface $validator;

    public function __construct(ClientRepository $clientRepository, ValidatorInterface $validator)
    {
        $this->clientRepository = $clientRepository;
        $this->validator = $validator;
    }

    public function apply(Request $request, ParamConverter $configuration): void
    {
        $options = $configuration->getOptions();

        $id = $request->get($options['id'] ?? Constants::ARG_CLIENT_ID);
        $uri = $request->get($options['redirectUri'] ?? Constants::ARG_REDIRECT_URI);

        if (null === $id || null === $uri) {
            throw new BadRequestHttpException("'{$id}' and '{$uri}' must be provided");
        }

        /** @var Client|null $client */
        $client = $this->clientRepository->find($id);

        if (!$client) {
            throw new NotFoundHttpException("Client not found");
        }

        $client->setRedirectUri($uri);

        if (count($errors = $this->validator->validate($client)) !== 0) {
            throw new BadRequestHttpException($errors->get(0)->getMessage());
        }

        $request->attributes->set($configuration->getName(), $client);
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getClass() === Client::class;
    }
}
