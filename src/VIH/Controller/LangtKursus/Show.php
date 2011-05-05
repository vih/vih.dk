<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Show extends k_Component
{
    protected $template;
    protected $doctrine;

    function __construct(k_TemplateFactory $template, Doctrine_Connection_Common $doctrine)
    {
        $this->template = $template;
        $this->doctrine = $doctrine;
    }

    function dispatch()
    {
        $kursus = new VIH_Model_LangtKursus($this->name());

        if (!$kursus->get('id') OR $kursus->get('dato_slut') < date('Y-m-d')) {
            throw new k_PageNotFound();
        }

        return parent::dispatch();
    }

    function map($name)
    {
        return 'VIH_Controller_LangtKursus_Tilmelding_Index';
    }

    function renderHtml()
    {
        $kursus = new VIH_Model_LangtKursus($this->name());

        $ansat = new VIH_Model_Ansat($kursus->get('ansat_id'));
        if ($ansat->get('id')) {
            $sprg_link = '<a href="'.$this->url('/underviser/' . $kursus->get('ansat_id')) . '">'.$ansat->get('navn').' svarer på spørgsmål</a>';
        } else {
            $sprg_link = '<a href="'.$this->url('/kontakt/') . '">Kontoret</a> svarer gerne på spørgsmål om kurset';
        }

        $pictures = $kursus->getPictures();
        $pic_html = '';

        if (count($pictures) > 0) {
            $pic_html .= '<div style="clear: both;">';
            foreach ($pictures as $pic) {
                $file = new VIH_FileHandler($pic['file_id']);
                if ($file->get('id')) $file->loadInstance('small');
                else continue;
                $pic_uri = $file->getImageHtml();

                $file->loadInstance('medium');

               $pic_html .= '<a href="'.htmlspecialchars($file->get('file_uri')).'" rel="lightbox">' . $pic_uri . '</a>';
            }
            $pic_html .= '</div>';
        }

        if ($kursus->get('title')) {
            $title = $kursus->get('title') . ' ' . $kursus->get('aar');
        } else {
            $title = $kursus->get('kursusnavn');
        }
        $meta['description'] = $kursus->get('description');
        $meta['keywords'] = $kursus->get('keywords');

        $this->document->setTitle($kursus->getKursusNavn());
        $this->document->meta = $meta;

        $data = array('kursus' => $kursus,
                      'fag' => $this->getSubjectsTable());

        $tpl = $this->template->create('LangtKursus/kursus');
        $content = array('content' => $tpl->render($this, $data)  . $this->getInformationAboutCourse($kursus),
                         'content_sub' => $this->getSubContent($sprg_link));

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $content);
    }

    private function isSubjectAvailable($period, $subject)
    {
        $subjectgroups = Doctrine::getTable('VIH_Model_Course_SubjectGroup')->findByPeriodId($period->getId());
        foreach ($subjectgroups as $grp) {
            foreach ($grp->Subjects as $subj) {
                if ($subj->getId() == $subject->getId()) return true;
            }
        }
        return false;
        
        /*
        $periods = Doctrine::getTable('VIH_Model_Course_Period')->findByCourseId($this->name());

        foreach ($periods as $p) {
            $col[$p->getId()] = $p->getName();
            $subjectgroups = Doctrine::getTable('VIH_Model_Course_SubjectGroup')->findByPeriodId($p->getId());
            foreach ($subjectgroups as $grp) {
                foreach ($grp->Subjects as $subj) {
                    if ($period->getId() == $p->getId() AND $subj->getId() == $subject->getId()) return true;
                }
            }
        }
        */

    }

    function getSubjectsTable()
    {
        $test = '';
        $i = 0;

        $subjects = VIH_Model_Fag::getPublishedWithDescription();
        $periods = Doctrine::getTable('VIH_Model_Course_Period')->findByCourseId($this->name());

        // columns for the table
        $col[] = '';
        foreach ($periods as $p) {
            $col[] = $p->getName();
        }

        // subject rows for the table
        $row = array();
        foreach ($subjects as $subject) {
            if (!$subject->get('published')) {
                continue;
            }

            if ($subject->get('faggruppe') != $test) {
                ++$i;
                $row[$i]['faggruppe'] = $subject->get('faggruppe') ;
                $test = $subject->get('faggruppe');
            }
            $row[$i]['fag'][$subject->getId()] = $subject;
        }

        // build table
        $attr = array('class' => 'skema');
        $table = new HTML_Table($attr);
        $table->addRow($col, null, 'th');

        foreach ($row as $r) {
            $table->addRow(array($r['faggruppe']), null, 'th');
            foreach ($r['fag'] as $fag) {
                $data = array();
                $data[] = '<a href="'.$this->url('/fag/' . $fag->get('identifier')).'">' . $fag->get('navn') . '</a>';
                foreach ($periods as $p) {
                    if ($this->isSubjectAvailable($p, $fag)) {
                    	$data[] = '&bull;';
                    } else {
                        $data[] = '';
                    }

                }
            	$table->addRow($data);
            }
        }

        return $table->toHtml();

    }

    function getSubContent($sprg_link)
    {
        return '
            <h2>Genveje</h2>
            <ul>
                <li>'.$sprg_link.'</li>
                <li><a href="'.$this->url('tilmelding') . '">Tilmeld dig</a></li>
                <li><a href="'.$this->url('../faq') . '">Ofte stillede spørgsmål</a></li>
            </ul>
            <h2>Støttemuligheder</h2>
            <ul>
                <li><a href="'.$this->url('../elevstotte') . '">Individuel elevstøtte</a></li>
                <li><a href="'.$this->url('../statsstotte') . '">Statsstøtte til særlige grupper</a></li>
            </ul>';
    }

    function getInformationAboutCourse($kursus)
    {
        return '
            <table class="skema">
                <caption>Information om kursus</caption>
                <tr>
                    <th>Periode</th>
                    <td>' . $kursus->getDateStart()->format('%d-%m-%Y') . ' til ' . $kursus->getDateEnd()->format('%d-%m-%Y') . '</td>
                </tr>
                <tr>
                    <th>Tilmeldingsgebyr</th>
                    <td>' . number_format($kursus->get('pris_tilmeldingsgebyr'), 0, ',', '.').' kroner</td>
                </tr>
                <tr>
                    <th>Ugepris</th>
                    <td>' . number_format($kursus->get('pris_uge'), 0, ',', '.').' kroner</td>
                </tr>
                <tr>
                    <th>Materialegebyr</th>
                    <td>' . number_format($kursus->get('pris_materiale'), 0, ',', '.').' kroner</td>
                </tr>
                <tr>
                    <th>Rejsedepositum</th>
                    <td>' . number_format($kursus->get('pris_rejsedepositum'), 0, ',', '.').' kroner</td>
                </tr>
            </table>

            <p>Ret til ændringer forbeholdes. Alle skal på en rejse af kortere varighed, som der opkræves et ekstra beløb til. <a href="'.$this->url('../betalingsbetingelser') . '">Læs betalingsbetingelserne</a> eller mere om <a href="'.$this->url('../okonomi') . '">økonomien</a>.</p>
        ';
    }
}
