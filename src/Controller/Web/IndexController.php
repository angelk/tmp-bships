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
        /* @var $battlefield \Model\Battlefield\Battlefield */
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
                if (!$battlefield->isThereNonSunkBattleship()) {
                    $this->setTemplate('Web' . DIRECTORY_SEPARATOR . 'endGame');
                    return $this->endGameAction();
                }
            } catch (\Model\Battlefield\Exception\HumanReadableException $e) {
                    $info = $e->getMessage();
            } catch (\Exception\Exception $e) {
                $info = 'error';
            }
        }
        
        $visualizer = $this->getVisualizerFactory()->create($battlefield);

        return [
            'visualizer' => $visualizer,
            'info' => $info,
        ];
    }
    
    public function endGameAction()
    {
        $battlefield = $this->getDataSaver()->load('battlefield');
        /* @var $battlefield \Model\Battlefield\Battlefield */
        if ($battlefield->isThereNonSunkBattleship()) {
            throw new \Model\Battlefield\Exception\HumanReadableException('Error. Game is not ended.');
        }

        $this->getDataSaver()->delete('battlefield');
        
        return [
            'shots' => $battlefield->getShots()->count(),
        ];
    }
}
