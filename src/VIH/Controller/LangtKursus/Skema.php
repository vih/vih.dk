<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Skema extends k_Controller
{
    public $i18n = array('Diskussionsfag' => 'Teori',
                         'Individuel tr�ning' => 'Tr�ning',
                         'Idr�tsspeciale A' => 'Idr�t A',
                         'Idr�tsspeciale B' => 'Idr�t B');

    function GET()
    {
        return $this->render('VIH/View/LangtKursus/skema-tpl.php');
    }
}