<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fag_Show extends k_Component
{
    protected $dbquery;
    protected $template;
    protected $kernel;

    function __construct(k_TemplateFactory $template, VIH_Intraface_Kernel $kernel)
    {
        $this->template = $template;
        $this->kernel = $kernel;
    }

    function renderHtml()
    {
        $fag = new VIH_Model_Fag($this->name());

        if (!$fag->get('id') OR $fag->get('active') != 1 OR $fag->get('published') != 1) {
            throw new k_PageNotFound();
        }

        $undervisere = $fag->getUndervisere();

        $title = $fag->get('title');
        if (empty($title)) {
            $title = $fag->get('navn');
        }
        $meta['description'] = $fag->get('description');
        $meta['keywords'] = $fag->get('keywords');

        $this->document->setTitle($title);
        $this->document->meta  = $meta;
        $this->document->theme = $fag->get('identifier');
        if ($this->query('show')) {
            $this->document->body_class  = 'sidepicture';
            $this->document->sidepicture = $this->getPictureHTML($fag->get('identifier'));
        } else {
            $this->document->body_class  = 'widepicture';
            $this->document->widepicture = $this->getWidePictureHTML($fag->get('identifier'));
        }
        $data = array('content' => '
            <div class="fit"><h1>'.$fag->get('navn').'</h1>
            '.autoop($fag->get('beskrivelse')).'
            ' . $this->getUdvidetBeskrivelse($fag) .'</div>',
                      'content_sub' =>
                            $this->getVideo() . '
            <h2>Sp�rgsm�l?</h2>
            ' . $this->getUndervisereHTML($fag->getUndervisere()) . $this->getSubContent($fag->get('identifier')));

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getSubContent($keyword)
    {
        $keywords = array($keyword);
        if(!is_array($keywords)) {
            throw new Exception('parameter should be an array with keywords');
        }

        $keyword_ids = array();
        foreach($keywords as $keyword) {
            $keyword_object = new Ilib_Keyword(new VIH_News);
            // @todo: This is not really good, but the only way to identify keyword on name!
            $keyword_ids[] = $keyword_object->save(array('keyword' => $keyword));
        }

        $this->getDBQuery()->setKeyword((array)$keyword_ids);

        $db = $this->getDBQuery()->getRecordset("nyhed.id", "", false);

        $news = array();

        while($db->nextRecord()) {
            $news[] = new VIH_News($db->f('id'));
        }

        $data = array('nyheder' => $news);
        $tpl = $this->template->create('News/sidebar-featured');
        return $tpl->render($this, $data);
    }

    function getUdvidetBeskrivelse($fag)
    {
        $udvidet_beskrivelse = '';
        if (!empty($this->GET['show']) AND $this->GET['show'] == 'udvidet') {
            //$udvidet_beskrivelse = $this->getLangeKurserHTML($fag);
            $udvidet_beskrivelse = '';
            if ($fag->get('udvidet_beskrivelse')) {
                $udvidet_beskrivelse .= '<h1>Udvidet beskrivelse af '.strtolower($fag->get('navn')).'</h1>
                '.autoop($fag->get('udvidet_beskrivelse')).'';
            }
        } else {
            if ($fag->get('udvidet_beskrivelse')) {
                $udvidet_beskrivelse = '<p><a href="'.$this->url(null, array('show' => 'udvidet')).'">Vis udvidet beskrivelse</a></p>';
            }
        }
        return $udvidet_beskrivelse;
    }

    function getVideo()
    {
        if ($this->name == 'musiklinje') {
            $url = $this->url('/gfx/flash/musiklinje.flv');
        } elseif ($this->name == 'rejselinje') {
            $url = $this->url('/gfx/flash/rejselinje.flv');
        } elseif ($this->name == 'politilinje') {
            $url = $this->url('/gfx/flash/politilinje.flv');
        } elseif ($this->name == 'fodboldakademi' OR $this->name == 'fodbold') {
            $url = $this->url('/gfx/flash/fodboldakademi.flv');
        } elseif ($this->name == 'underviser') {
            $url = $this->url('/gfx/flash/underviser.flv');
        } elseif ($this->name == 'fitnessogsundhed' OR $this->name == 'fitness') {
            $url = $this->url('/gfx/flash/fitnessogsundhed.flv');
        } else {
            return '';
        }

        $this->document->addScript($this->url('/scripts/swfobject.js'));
        $tpl = $this->template->create('flvplayer');
        return $tpl->render($this, array('url' => $url));
    }

    function getUndervisereHTML($undervisere = array())
    {
        $data = array('undervisere' => $undervisere);
        $tpl = $this->template->create('Ansat/undervisere');
        return $tpl->render($this, $data);
    }

    function getPictureHTML($identifier)
    {
        $filemanager = new Ilib_Filehandler_Manager($this->kernel);

        try {
            $img = new Ilib_Filehandler_ImageRandomizer($filemanager, array($identifier));
            $file = $img->getRandomImage();
        } catch (Exception $e) {
            return '';
        }

        $instance = $file->createInstance('sidepicture');
        $editor_img_uri = $instance->get('file_uri');
        $editor_img_height = $instance->get('height');
        $editor_img_width = $instance->get('width');

        return $this->url('/file.php') . $instance->get('file_uri_parameters');
    }

    function getWidePictureHTML($identifier)
    {
        return $this->context->getWidePictureHTML($identifier);
    }

    function getLangeKurserHTML($fag)
    {
        if (!$fag->showCourses()) {
            return '';
        }
        $data = array('kurser' => $fag->getKurser(),
                      'caption' => $fag->get('navn') . ' er p� f�lgende kurser',
                      'summary' => 'Oversigt over hvilke lange kurser, du kan f� ' . $fag->get('navn') . ' p�.');
        $tpl = $this->template->create('LangtKursus/kurser');
        return $tpl->render($this, $data);
    }

    function getDBQuery()
    {
        if ($this->dbquery) {
            return $this->dbquery;
        }
        $dbquery = new Ilib_DBQuery("nyhed", "nyhed.active = 1");
        return ($this->dbquery = $dbquery);
    }
}