<?php
class VIH_Controller_LangtKursus_Login_Fag extends VIH_Controller_LangtKursus_Tilmelding_Fag
{
    function getRegistration()
    {
        return VIH_Model_LangtKursus_Tilmelding::factory($this->context->name);
    }

    function getPeriods()
    {
        $doctrine = $this->registry->get('doctrine');
        return Doctrine::getTable('VIH_Model_Course_Period')->findByCourseId($this->getRegistration()->getKursus()->getId());
    }

    function getRedirectUrl()
    {
        return $this->url();
    }

    function GET()
    {
        $this->document->title = 'Vælg fag';

        return parent::GET() .  '<p><a href="'.$this->context->url().'">Tilbage</a></p>';
    }
}