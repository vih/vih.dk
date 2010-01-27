<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Pakker_Index extends k_Controller
{
    function forward($name)
    {
        if ($name == 'politi') {
        	$next = new VIH_Controller_Fag_Pakker_Politi($this, $name);
        } elseif ($name == 'outdoor') {
        	$next = new VIH_Controller_Fag_Pakker_Outdoor($this, $name);
        } elseif ($name == 'boldspil') {
            $next = new VIH_Controller_Fag_Pakker_Boldspil($this, $name);
        } elseif ($name == 'fitness') {
            $next = new VIH_Controller_Fag_Pakker_Fitness($this, $name);
        }
        return $next->handleRequest();
    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        $this->document->body_class  = 'widepicture';

        $data = array('content' => parent::handleRequest(), 'content_sub' => $this->context->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function getSkema()
    {
        $forklaring = '<p><strong>Herunder har du et skemaeksempel. Du kan selvfølgelig vælge mellem alle fagene ude i siden.</strong></p>';

        $skema = new VIH_Controller_LangtKursus_Skema($this);
        return $forklaring . $skema->execute();
    }

    function getWidePictureHTML($identifier)
    {
    	return $this->context->getWidePictureHTML($identifier);
    }
}