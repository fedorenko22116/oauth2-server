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
        foreach (
            array_merge((array)$request->query->getIterator(), (array)$request->request->getIterator()) as $param
        ) {
            $request->attributes->set($param, $request->get($param));
        }

        $options = $configuration->getOptions();

        foreach ($options['params'] ?? [] as $name => $param) {
            $request->attributes->set($name, $request->get($param));
        }

        unset($options['params']);

        $configuration->setOptions($options);

        parent::apply($request, $configuration);
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getConverter() === 'app_doctrine' && parent::supports($configuration);
    }
}
