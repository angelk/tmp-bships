<?php

namespace Controller;

use DataSaver\DataSaverInterface;
use EventDispatcher\EventDispacherInterface;
use Model\Battlefield\Visualizer\VisualizerFactory;

/**
 * Description of AbstractController
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class AbstractController
{
    /**
     * @var EventDispacherInterface
     */
    private $eventDispacher;
    private $visualizerFactory;
    private $dataSaver;
    private $template;
    
    public function setEventDispacher(EventDispacherInterface $eventDispacher)
    {
        $this->eventDispacher = $eventDispacher;
        
    }

    /**
     * @return VisualizerFactory
     */
    public function getVisualizerFactory()
    {
        return $this->visualizerFactory;
    }

    public function getTemplate()
    {
        return $this->template;
    }
        
    public function setTemplate($template)
    {
        $this->template = $template;
    }
        
    public function getEventDispacher()
    {
        return $this->eventDispacher;
    }

    public function setVisualizerFactory(VisualizerFactory $visualizerFactory)
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
