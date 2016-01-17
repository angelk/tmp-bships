<?php

namespace Controller;

use DataSaver\DataSaverInterface;

/**
 * Description of AbstractController
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class AbstractController
{
    private $eventDispacher;
    private $visualizerFactory;
    private $dataSaver;
    
    public function setEventDispacher(\EventDispatcher\EventDispacherInterface $eventDispacher)
    {
        $this->eventDispacher = $eventDispacher;
        
    }

    /**
     * @return \Model\Battlefield\Visualizer\VisualizerFactory
     */
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
    
    public function setDataSaver(DataSaverInterface $dataSaver)
    {
        $this->dataSaver = $dataSaver;
    }
    
    /**
     * @return DataSaverInterface
     */
    public function getDataSaver()
    {
        if (!$this->dataSaver) {
            throw new \Model\Exception\Exception("DataSaver not set");
        }
        return $this->dataSaver;
    }
}
