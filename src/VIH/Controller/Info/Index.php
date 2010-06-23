<?php
class VIH_Controller_Info_Index extends k_Component
{
    public $map = array('organisation'   => 'VIH_Controller_Info_Organisation',
                        'værdigrundlag' => 'VIH_Controller_Info_Værdigrundlag',
                        'om'             => 'VIH_Controller_Info_Om',
                        'historie'       => 'VIH_Controller_Info_Historie',
                        'vejledning'     => 'VIH_Controller_Info_Vejledning',
                        'uden-ungdomsuddannelse' => 'VIH_Controller_Info_UdenUngdomsUddannelse',

    );

    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function map($name)
    {
        return $this->map[$name];
    }

    function renderHtml()
    {
        $title = 'Filosofi og information';
        $meta['description'] = 'Vejle Idrætshøjskole er en idrætshøjskole. Højskolelivet dækker over mange ting, det er umuligt at beskrive. Vi har alligevel forsøgt: Læs noget om det her.';
        $meta['keywords'] = 'Vejle, Idrætshøjskole, jyske, idrætsskole, højskolekurser, højskolekursus, højskoleliv, weekend, lovtekster, love, statistik, fortolkning';

        $this->document->setTitle($title);
        $this->document->addCrumb($this->name(), $this->url());
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';
        $this->document->theme = 'organisation';
        $this->document->widepicture = $this->url('/gfx/images/hojskole.jpg');

        $data = array('content' => '
            <h1>Vi tror på...</h1>

            <blockquote>
                <p>...at sociale kompetencer er alt afgørende for voksenlivets karrierer. Et godt liv handler om at kunne engagere og involvere sig i andre mennesker - i arbejdsrelationer såvel som private.</p>
            </blockquote>
            <blockquote>
                <p>På Vejle Idrætshøjskole har vi sporten som ramme. En sund krop - fysisk og psykisk - er en fundamentet for et godt og langt liv. Det er igennem sporten, du bliver udfordret, stimuleret og presset, for det er, når du rykkes ud af de trygge rammer, at der for alvor åbnes for en personlig udvikling. Livsglæde handler om at alle muskler bliver aktiveret, ikke mindst humørmusklen.</p>
            </blockquote>',
            'content_sub' => $this->getSubContent());

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getSubContent()
    {
        return '
                <h2>Sidelinjen</h2>
                <p><a href="'.$this->url('/gfx/folder/historie.pdf').'"><img src="' . $this->url('/gfx/images2/histogramthumb.jpg') . '" alt="Historiegram" width="152" height="108"></a></p>

                <blockquote class="statement">
                    <p>Du er dyb, har det sjovt og er svedig, nysgerrig og udfordret. Du er kort og godt 100% livsglad.</p>
                </blockquote>

                <ul>
                	<li><a href="'.$this->url('værdigrundlag').'">Værdigrundlag</a></li>
                	<li><a href="'.$this->url('vejledning').'">Vejledning</a></li>
                    <li><a href="'.$this->url('uden-ungdomsuddannelse').'">Indsats for elever uden ungdomsuddannelse</a></li>
                    <li><a href="'.$this->url('/gfx/pdf/årsplan2010.pdf').'">Årsplan (pdf)</a></li>
                </ul>
            ';
    }

    function wrapHtml($content)
    {
        $data = array('content' => $content, 'content_sub' => $this->getSubContent());
        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }
}