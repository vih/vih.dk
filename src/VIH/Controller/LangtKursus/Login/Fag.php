<?php
class VIH_Controller_LangtKursus_Login_Fag extends VIH_Controller_LangtKursus_Tilmelding_Fag
{
    function renderHtml()
    {
        $this->document->setTitle('Vï¿½lg fag');

        return parent::renderHtml() .  '<p><a href="'.$this->context->url().'">Tilbage</a></p>';
    }

    function getRegistration()
    {
        return VIH_Model_LangtKursus_Tilmelding::factory($this->context->name());
    }

    function getPeriods()
    {
        return Doctrine::getTable('VIH_Model_Course_Period')->findByCourseId($this->getRegistration()->getKursus()->getId());
    }

    function getRedirectUrl()
    {
        return $this->url();
    }
}