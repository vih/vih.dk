<?php
class VIH_Controller_Info_Index extends k_Controller
{
    public $map = array('organisation'   => 'VIH_Controller_Info_Organisation',
                        'vaerdigrundlag' => 'VIH_Controller_Info_Vaerdigrundlag',
                        'om'             => 'VIH_Controller_Info_Om',
                        'historie'       => 'VIH_Controller_Info_Historie',
                        'vejledning'     => 'VIH_Controller_Info_Vejledning',
                        'uden-ungdomsuddannelse' => 'VIH_Controller_Info_UdenUngdomsUddannelse',

    );

    function GET()
    {
        $title = 'Filosofi og information';
        $meta['description'] = 'Vejle Idr�tsh�jskole er en idr�tsh�jskole. H�jskolelivet d�kker over mange ting, det er umuligt at beskrive. Vi har alligevel fors�gt: L�s noget om det her.';
        $meta['keywords'] = 'Vejle, Idr�tsh�jskole, jyske, idr�tsskole, h�jskolekurser, h�jskolekursus, h�jskoleliv, weekend, lovtekster, love, statistik, fortolkning';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'widepicture';
        $this->document->theme = 'organisation';
        $this->document->widepicture = $this->url('/gfx/images/hojskole.jpg');

        $data = array('content' => '
            <h1>Vi tror p�...</h1>

            <blockquote>
                <p>...at sociale kompetencer er alt afg�rende for voksenlivets karrierer. Et godt liv handler om at kunne engagere og involvere sig i andre mennesker - i arbejdsrelationer s�vel som private.</p>
            </blockquote>
            <blockquote>
                <p>P� Vejle Idr�tsh�jskole har vi sporten som ramme. En sund krop - fysisk og psykisk - er en fundamentet for et godt og langt liv. Det er igennem sporten, du bliver udfordret, stimuleret og presset, for det er, n�r du rykkes ud af de trygge rammer, at der for alvor �bnes for en personlig udvikling. Livsgl�de handler om at alle muskler bliver aktiveret, ikke mindst hum�rmusklen.</p>
            </blockquote>',
            'content_sub' => $this->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
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
                	<li><a href="'.$this->url('vaerdigrundlag').'">V�rdigrundlag</a></li>
                	<li><a href="'.$this->url('vejledning').'">Vejledning</a></li>
                    <li><a href="'.$this->url('uden-ungdomsuddannelse').'">Indsats for elever uden ungdomsuddannelse</a></li>
                    <li><a href="'.$this->url('/gfx/pdf/aarsplan2010.pdf').'">�rsplan (pdf)</a></li>
                </ul>
            ';
    }

    function forward($name)
    {
        if (empty($this->map[$name])) {
            throw new k_http_Response(404);
        }
        $next = new $this->map[$name]($this, $name);
        $data = array('content' => $next->handleRequest(), 'content_sub' => $this->getSubContent());
        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        return parent::handleRequest();
    }
}