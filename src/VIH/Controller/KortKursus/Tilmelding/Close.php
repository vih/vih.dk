<?php
class VIH_Controller_KortKursus_Tilmelding_Close extends k_Component
{
    function renderHtml()
    {
        return new k_SeeOther($this->url('/'));
    }

}

