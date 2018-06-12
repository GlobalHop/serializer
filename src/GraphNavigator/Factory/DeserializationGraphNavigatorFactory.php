<?php

namespace JMS\Serializer\GraphNavigator\Factory;

use JMS\Serializer\Accessor\AccessorStrategyInterface;
use JMS\Serializer\Construction\ObjectConstructorInterface;
use JMS\Serializer\Context;
use JMS\Serializer\EventDispatcher\EventDispatcherInterface;
use JMS\Serializer\Expression\ExpressionEvaluatorInterface;
use JMS\Serializer\GraphNavigator\DeserializationGraphNavigator;
use JMS\Serializer\GraphNavigatorInterface;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\Selector\DefaultPropertySelector;
use Metadata\MetadataFactoryInterface;

final class DeserializationGraphNavigatorFactory implements GraphNavigatorFactoryInterface
{

    /**
     * @var MetadataFactoryInterface
     */
    private $metadataFactory;
    /**
     * @var HandlerRegistryInterface
     */
    private $handlerRegistry;
    /**
     * @var ObjectConstructorInterface
     */
    private $objectConstructor;
    /**
     * @var AccessorStrategyInterface
     */
    private $accessor;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    /**
     * @var ExpressionEvaluatorInterface
     */
    private $expressionEvaluator;

    public function __construct(
        MetadataFactoryInterface $metadataFactory,
        HandlerRegistryInterface $handlerRegistry,
        ObjectConstructorInterface $objectConstructor,
        AccessorStrategyInterface $accessor,
        EventDispatcherInterface $dispatcher = null,
        ExpressionEvaluatorInterface $expressionEvaluator = null
    ) {

        $this->metadataFactory = $metadataFactory;
        $this->handlerRegistry = $handlerRegistry;
        $this->objectConstructor = $objectConstructor;
        $this->accessor = $accessor;
        $this->dispatcher = $dispatcher;
        $this->expressionEvaluator = $expressionEvaluator;
    }

    public function getGraphNavigator(Context $context): GraphNavigatorInterface
    {
        $selector = new DefaultPropertySelector($context, $this->expressionEvaluator);

        return new DeserializationGraphNavigator($this->metadataFactory, $this->handlerRegistry, $this->objectConstructor, $this->accessor, $selector, $this->dispatcher, $this->expressionEvaluator);
    }
}
