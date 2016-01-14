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
        $savedData = isset($_SESSION['battleship.progress']) ? $_SESSION['battleship.progress'] : null;
        if ($savedData) {
            $battlefield = unserialize($savedData);
        } else {
            $battlefield = new \Model\Battlefield\Battlefield(10, 10);
            $placer = new \Model\Battlefield\Placer(
                new \Model\Battleship\Destroyer(),
                new \Model\Battlefield\Point\Point(1, 2),
                new \Model\Battlefield\Point\Point(1, 6)
            );
            $battlefield->addBattleShip($placer);
            $_SESSION['battleship.progress'] = serialize($battlefield);
        }
        
        $battlefield->setEventDispacher($this->getEventDispacher());

        if (!empty($_POST)) {
            $shotData = $_POST['shot'];
            try {
                $pointFactory = new \Model\Battlefield\Point\PointFactory();
                $point = $pointFactory->createPoint($shotData);
                $battlefield->shoot($point);
                $_SESSION['battleship.progress'] = serialize($battlefield);
            } catch (\Model\Battlefield\Exception\HumanReadableException $e) {
                $info = $e->getMessage();
            }
        }
        
        $visualizer = $this->getVisualizerFactory()->create($battlefield);

        return [
            'visualizer' => $visualizer,
            'info' => $info,
        ];
    }
}
