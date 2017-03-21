<?php

namespace Common\Register\Listener;

use Common\Event;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Session\Container;
use Zend\Stdlib\CallbackHandler;

/**
 * Class StoreFinishedRegisterContainerDataListener
 *
 * @package Common\Register\Listener
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class StoreFinishedRegisterContainerDataListener implements ListenerAggregateInterface
{
    /**
     * @var CallbackHandler[]
     */
    protected $sharedListeners = [];

    /**
     * @var Container
     */
    protected $sessionContainer;

    /**
     * @param Container $sessionContainer
     */
    public function __construct(Container $sessionContainer)
    {
        $this->sessionContainer = $sessionContainer;
    }

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->sharedListeners[] = $events->getSharedManager()->attach(
            '*',
            Event::REGISTRATION_FINISHED_INCOMPLETE,
            [ $this, 'storeRegisterData' ]
        );
        $this->sharedListeners[] = $events->getSharedManager()->attach(
            '*',
            Event::REGISTRATION_FINISHED_COMPLETE,
            [ $this, 'storeRegisterData' ]
        );
    }

    /**
     * @param EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->sharedListeners as $index => $listener) {
            if ($events->getSharedManager()->detach('*', $listener)) {
                unset($this->sharedListeners[$index]);
            }
        }
    }

    /**
     * @param EventInterface $event
     *
     * @return void
     */
    public function storeRegisterData(EventInterface $event)
    {
        $containerId = $event->getParam(Event::DATA_KEY_REGISTER_CONTAINER_ID);
        $stepData = $event->getParam(Event::DATA_KEY_REGISTER_STEP_DATA);

        $this->sessionContainer->offsetSet($containerId, $stepData);
    }

}