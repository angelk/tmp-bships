<?php

namespace Event\Model\Battlefield;

/**
 * Used to update visualizer factory with last battlefield shot.
 * Cheat shot should use VisualizerCheat
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class ShootSubscriber implements \EventDispatcher\EventSubscriberInterface
{
    private $visualizerFactory;
    
    public function __construct(\Model\Battlefield\Visualizer\VisualizerFactory $visualizerFactory)
    {
        $this->visualizerFactory = $visualizerFactory;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'beforeShoot' => 'beforeShoot',
        ];
    }

    /**
     * Update visualizer last shot data
     * @param \Event\Model\Battlefield\ShootEvent $event
     */
    public function beforeShoot($event)
    {
        if ($event instanceof ShootEvent) {
            $this->visualizerFactory->setLastShot($event->getBattlefield(), $event->getShoot());
        }
    }
}
