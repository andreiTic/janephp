<?php

namespace Jane\JsonSchema\Guesser\JsonSchema;

use Jane\JsonSchema\Guesser\ChainGuesserAwareInterface;
use Jane\JsonSchema\Guesser\ChainGuesserAwareTrait;
use Jane\JsonSchema\Guesser\ClassGuesserInterface;
use Jane\JsonSchema\Guesser\GuesserInterface;
use Jane\JsonSchema\Model\JsonSchema;
use Jane\JsonSchema\Registry;

class DefinitionGuesser implements ChainGuesserAwareInterface, GuesserInterface, ClassGuesserInterface
{
    use ChainGuesserAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function guessClass($object, string $name, string $reference, Registry $registry): void
    {
        /**
         * @var string
         * @var JsonSchema $definition
         */
        foreach ($object->getDefinitions() as $key => $definition) {
            $this->chainGuesser->guessClass($definition, $key, $reference . '/definitions/' . $key, $registry);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportObject($object): bool
    {
        return ($object instanceof JsonSchema) && null !== $object->getDefinitions() && \count($object->getDefinitions()) > 0;
    }

    protected function getSchemaClass(): string
    {
        return JsonSchema::class;
    }
}
