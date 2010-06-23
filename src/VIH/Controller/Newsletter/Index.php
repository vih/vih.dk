<?php
class VIH_Controller_Newsletter_Index extends k_Component
{
    public $i18n = array(
        'Newsletter' => 'Nyhedsbrev',
        'You have now subscribed to the newsletter.' => 'Du er nu tilmeldt til nyhedsbrevet.',
        'subscribe' => 'Tilmeld',
        'unsubscribe' => 'Frameld',
        'Save' => 'Gem',
        'Email' => 'E-mail',
        'You have to supply an email address' => 'Du skal skrive en e-mail-adresse',
        'An error occured. You could not subscribe.' => 'Der skete en fejl, s� du kunne ikke tilmelde dig. Skriv til lars@vih.dk.',
        'You have unsubscribed from the newsletter.' => 'Du er nu frameldt nyhedsbrevet.',
        'An error occured. You could not be removed from the newsletter.' => 'Der skete en fejl, s� du kunne ikke framelde dig. Skriv til lars@vih.dk.',
        'Information about the newsletter.' => 'Vi udsender seks-otte nyhedsbreve om �ret. Nyhedsbrevene fort�ller om de vigtigste nyheder fra Vejle Idr�tsh�jskole. Du finder nyheder om de lange og korte kurser og om kursuscenteret. Nyhedsbrevet sendes i tekstformat.'
    );

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function wrapHtml()
    {
        $next = new IntrafacePublic_Newsletter_Controller_Index($this);
        $content = $next->handleRequest();

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, array('content' => $content));
    }
}