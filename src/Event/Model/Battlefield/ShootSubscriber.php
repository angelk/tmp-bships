<?php

namespace Event\Model\Battlefield;

/**
 * Description of ShootSubscriber
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

    
    public static function getSubscribedEvents()
    {
        return [
            'beforeShoot' => 'beforeShoot',
        ];
    }
    
    public function beforeShoot($event)
    {
        if ($event instanceof ShootEvent) {
            $this->visualizerFactory->setLastShot($event->getBattlefield(), $event->getShoot());
        }
    }
}
