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
            $battlefieldFactory = new \Model\Battlefield\BattlefieldFactory();
            $battlefield = $battlefieldFactory->createBattleField(
                [
                    new \Model\Battleship\Battleship(),
                    new \Model\Battleship\Destroyer(),
                    new \Model\Battleship\Destroyer(),
                ]
            );
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
