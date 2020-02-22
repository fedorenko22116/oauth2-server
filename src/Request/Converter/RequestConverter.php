<?php declare(strict_types=1);

namespace App\Request\Converter;

use ReflectionClass;
use ReflectionProperty;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestConverter implements ParamConverterInterface
{
    private CamelCaseToSnakeCaseNameConverter $camelCaseConverter;
    private ValidatorInterface $validator;

    public function __construct(CamelCaseToSnakeCaseNameConverter $camelCaseConverter, ValidatorInterface $validator)
    {
        $this->camelCaseConverter = $camelCaseConverter;
        $this->validator = $validator;
    }

    public function apply(Request $request, ParamConverter $configuration): void
    {
        $class = $configuration->getClass();
        $meta = new ReflectionClass($class);
        $props = array_map(fn(ReflectionProperty $property) => $property->getName(), $meta->getProperties());
        $object = new $class();

        foreach ($props as $prop) {
            if (($var = $request->get($this->camelCaseConverter->normalize($prop)) !== null)) {
                if ($meta->hasMethod($method = 'set' . ucfirst($prop))) {
                    $object->$method($var);
                } else if ($meta->hasProperty($prop) && $meta->getProperty($prop)->isPublic()) {
                    $object->$prop = $var;
                }
            }
        }

        if (($result = $this->validator->validate($object))->count()) {
            throw new BadRequestHttpException($result->get(0)->getMessage());
        }

        $request->attributes->add([$configuration->getName() => $object]);
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getConverter() === 'app_request';
    }
}
