<?php

namespace Synolia\Bundle\OroneoBundle\EventSubscriber;

use Oro\Bundle\DataAuditBundle\EventListener\SendChangedEntitiesToMessageQueueListener;
use Oro\Bundle\EntityBundle\Event\OroEventManager;
use Oro\Bundle\EntityBundle\ORM\OroEntityManager;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Synolia\Bundle\OroneoBundle\Command\ImportCommand;

/**
 * Class CategoryListener
 * @package Synolia\Bundle\OroneoBundle\EventListener
 */
class CategorySubscriber implements EventSubscriberInterface
{
    /** @var OroEventManager $manager */
    protected $manager;

    /** @var  SendChangedEntitiesToMessageQueueListener $listener */
    protected $listener;

    /**
     * CategorySubscriber constructor.
     *
     * @param OroEntityManager                            $manager
     * @param SendChangedEntitiesToMessageQueueListener   $listener
     */
    public function __construct(OroEntityManager $manager, SendChangedEntitiesToMessageQueueListener $listener)
    {
        $this->manager  = $manager->getEventManager();
        $this->listener = $listener;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::COMMAND => 'onCommand',
        ];
    }

    /**
     * @param ConsoleCommandEvent $event
     */
    public function onCommand(ConsoleCommandEvent $event)
    {
        if ($event->getCommand() instanceof ImportCommand) {
            $type = $event->getInput()->getArgument(ImportCommand::ARGUMENT_TYPE);
            if ($type == 'category') {
                /**
                 * @TODO : fix this :
                 * In @see \Oro\Bundle\DataAuditBundle\Loggable\LoggableManager::getOldEntity
                 * the old values are badly fetched : only the first entry of arrays is recovered,
                 * making the import fail because it makes @see \Oro\Bundle\CatalogBundle\Entity\Category::$titles
                 * a LocalizedFallbackValue instead of a collection
                 */
                $this->manager->removeEventListener(
                    array('onFlush', 'loadClassMetadata', 'postPersist'),
                    $this->listener
                );
            }
        }
    }
}
