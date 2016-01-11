<?php

namespace Controller\Web;

/**
 * Description of IndexController
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class IndexController
{
    public function homeAction()
    {
        $savedData = isset($_SESSION['battleship.progress']) ? $_SESSION['battleship.progress'] : null;
        if ($savedData) {
            $battlefield = unserialize($savedData);
        } else {
            $battlefield = new \Model\Battlefield\Battlefield(10, 10);
        }

        $visualizerFactory = new \Model\Battlefield\Visualizer\VisualizerFactory();

        $placer = new \Model\Battlefield\Placer(
            new \Model\Battleship\Destroyer(),
            new \Model\Battlefield\Point\Point(1, 2),
            new \Model\Battlefield\Point\Point(1, 6)
        );

        $battlefield->addBattleShip($placer);
        $battlefield->shoot(new \Model\Battlefield\Point\Point(1, 1));
        $battlefield->shoot(new \Model\Battlefield\Point\Point(0, 0));

        $battlefield->shoot(new \Model\Battlefield\Point\CheatPoint());

        $visualizer = $visualizerFactory->create($battlefield);

        return [
            'visualizer' => $visualizer,
        ];
    }
}
