<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Pakker_Index extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        if ($name == 'politi') {
        	return 'VIH_Controller_Fag_Pakker_Politi';
        } elseif ($name == 'outdoor') {
        	return 'VIH_Controller_Fag_Pakker_Outdoor';
        } elseif ($name == 'boldspil') {
            return 'VIH_Controller_Fag_Pakker_Boldspil';
        } elseif ($name == 'fitness') {
            return 'VIH_Controller_Fag_Pakker_Fitness';
        }
    }

    function wrapHtml($content)
    {
        $this->document->addCrumb($this->name, $this->url());
        $this->document->body_class  = 'widepicture';

        $data = array('content' => $content, 'content_sub' => $this->context->getSubContent());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getSkema()
    {
        $forklaring = '<p><strong>Herunder har du et skemaeksempel. Du kan selvfï¿½lgelig vï¿½lge mellem alle fagene ude i siden.</strong></p>';

        $skema = $this->createComponent('VIH_Controller_LangtKursus_Skema', '');
        return $forklaring . $skema->renderHtml();
    }

    function getWidePictureHTML($identifier)
    {
    	return $this->context->getWidePictureHTML($identifier);
    }
}