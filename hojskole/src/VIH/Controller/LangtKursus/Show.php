<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Show extends k_Controller
{
    function GET()
    {
        $soegestreng = strip_tags($this->name);
        $kursus = new VIH_Model_LangtKursus($soegestreng);

        if (!$kursus->get('id') OR $kursus->get('dato_slut') < date('Y-m-d')) {
            throw new k_http_Response(404);
        }

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

        $this->document->title = $kursus->getKursusNavn();
        $this->document->meta = $meta;

        $data = array('kursus' => $kursus,
                      'fag' => $this->getSubjectsTable());

        $content = array('content' => $this->render('VIH/View/LangtKursus/kursus-tpl.php', $data)  . $this->getInformationAboutCourse($kursus),
                         'content_sub' => $this->getSubContent($sprg_link));

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $content);
    }

    /*
    function getSubjects()
    {
        $fag = '';
        $doctrine = $this->registry->get('doctrine');
        $period = Doctrine::getTable('VIH_Model_Course_Period')->findByCourseId($this->name);
        foreach ($period as $p) {
            $fag .= '<h2>'.$p->getName().'</h2>';
            $subjectgroups = Doctrine::getTable('VIH_Model_Course_SubjectGroup')->findByPeriodId($p->getId());
            foreach ($subjectgroups as $grp) {
                $fag .= '<h3>' . $grp->getName() . '</h3>';
                foreach ($grp->Subjects as $subj) {
                    $fag .= '<a href="'.$this->url('/fag/' . $subj->get('identifier')).'">' . $subj->getName() . '</a> ';
                }
            }
        }

        return $fag;
    }
    */

    private function isSubjectAvailable($period, $subject)
    {
        $doctrine = $this->registry->get('doctrine');
        $periods = Doctrine::getTable('VIH_Model_Course_Period')->findByCourseId($this->name);

        foreach ($periods as $p) {
            $col[$p->getId()] = $p->getName();
            $subjectgroups = Doctrine::getTable('VIH_Model_Course_SubjectGroup')->findByPeriodId($p->getId());
            foreach ($subjectgroups as $grp) {
                foreach ($grp->Subjects as $subj) {
                    if ($period->getId() == $p->getId() AND $subj->getId() == $subject->getId()) return true;
                }
            }
        }

    }

    function getSubjectsTable()
    {
        $test = '';
        $i = 0;

        $subjects = VIH_Model_Fag::getPublishedWithDescription();
        $doctrine = $this->registry->get('doctrine');
        $periods = Doctrine::getTable('VIH_Model_Course_Period')->findByCourseId($this->name);

        $attr = array('class' => 'skema');

        $table = new HTML_Table($attr);

        $col[] = '';

        foreach ($periods as $p) {
            $col[] = $p->getName();
        }

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
                <tr>
                    <th>Nøgledepositum</th>
                    <td>' . number_format($kursus->get('pris_noegledepositum'), 0, ',', '.').' kroner</td>
                </tr>
            </table>

            <p>Ret til ændringer forbeholdes. Alle skal på en rejse af kortere varighed, som der opkræves et ekstra beløb til. <a href="'.$this->url('../betalingsbetingelser') . '">Læs betalingsbetingelserne</a> eller mere om <a href="'.$this->url('../okonomi') . '">økonomien</a>.</p>
        ';
    }

    function forward($name)
    {
        if ($name == 'tilmelding') {
            $next = new VIH_Controller_LangtKursus_Tilmelding_Index($this, $name);
            return $next->handleRequest();
        }
    }
}