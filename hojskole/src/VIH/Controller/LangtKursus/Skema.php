<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Skema extends k_Controller
{
    public $i18n = array('Diskussionsfag' => 'Teori',
                         'Individuel træning' => 'Træning',
                         'Idrætsspeciale A' => 'Idræt A',
                         'Idrætsspeciale B' => 'Idræt B');

    function GET()
    {
        return $this->render('VIH/View/LangtKursus/skema-tpl.php');
    }
}