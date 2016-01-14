<?php

namespace Controller;

/**
 * Description of AbstractController
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class AbstractController
{
    private $eventDispacher;
    private $visualizerFactory;
    
    public function setEventDispacher(\EventDispatcher\EventDispacherInterface $eventDispacher)
    {
        $this->eventDispacher = $eventDispacher;
        
    }

    public function getVisualizerFactory()
    {
        return $this->visualizerFactory;
    }
        
    public function getEventDispacher()
    {
        return $this->eventDispacher;
    }

    public function setVisualizerFactory(\Model\Battlefield\Visualizer\VisualizerFactory $visualizerFactory)
    {
        $this->visualizerFactory = $visualizerFactory;
    }
}
