<?php declare(strict_types=1);

namespace App\Request\Converter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class DoctrineRequestConverter extends DoctrineParamConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration): void
    {
        foreach ($configuration->getOptions()['params'] as $param) {
            $request->attributes->set($param, $request->get($param));
        }

        parent::apply($request, $configuration);
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getConverter() === 'app_doctrine' && parent::supports($configuration);
    }
}
