<?php

namespace Controller\Web;

/**
 * Description of IndexController
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class IndexController extends \Controller\AbstractController
{
    public function homeAction()
    {
        $info = null;
        $battlefield = $this->getDataSaver()->load('battlefield');
        if (!$battlefield) {
            $battlefieldFactory = new \Model\Battlefield\BattlefieldFactory();
            $battlefield = $battlefieldFactory->createDefaultBattlefield();
        }
        
        $battlefield->setEventDispacher($this->getEventDispacher());

        if (!empty($_POST)) {
            $shotData = $_POST['shot'];
            try {
                $pointFactory = new \Model\Battlefield\Point\PointFactory();
                $point = $pointFactory->createPoint($shotData);
                $battlefield->shoot($point);
                $this->getDataSaver()->save($battlefield, 'battlefield');
            } catch (\Model\Battlefield\Exception\HumanReadableException $e) {
                if ($e instanceof \Model\Exception\HumanReadableInterface) {
                    $info = $e->getMessage();
                } else {
                    $info = 'error';
                }
            }
        }
        
        $visualizer = $this->getVisualizerFactory()->create($battlefield);

        return [
            'visualizer' => $visualizer,
            'info' => $info,
        ];
    }
}
