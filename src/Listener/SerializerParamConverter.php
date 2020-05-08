<?php

declare(strict_types=1);

namespace App\Listener;

use App\Exceptions\InvalidMessageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class SerializerParamConverter
 * @package App\Listener
 */
final class SerializerParamConverter implements ParamConverterInterface
{
    private SerializerInterface $serializer;

    /**
     * SerializerParamConverter constructor.
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = $request->getContent();
        if (!$content) {
            throw InvalidMessageException::missingContent();
        }

        $classTarget = $configuration->getClass();
        $name = $configuration->getName();

        $object = $this->serializer->deserialize($content, $classTarget, 'json');
        $request->attributes->set($name, $object);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        return !(null === $configuration->getClass() || null === $configuration->getName());
    }
}
