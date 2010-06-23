<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_LangtKursus_Betalingsbetingelser extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Betalingsbetingelser for de lange h�jskolekurser';
        $meta['description'] = 'Betalingsbetingelser for de lange h�jskolekurser p� Vejle Idr�tsh�jskole.';
        $meta['keywords'] = 'vejle idr�tsh�jskole, betaling, betalingsbetingelser, �konomi, indmeldelsesgebyr, indmelding, indmeldelse';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $data = array('kurser' => VIH_Model_LangtKursus::getList('open'));

        $this_year = date("Y");
        $next_year = $this_year + 1;

        $tpl = $this->template->create('LangtKursus/okonomi');

        return '

        <h1>Betalingsbetingelser ' .  $this_year . '/' . $next_year . '</h1>

        <h2>1. Indmeldelsesgebyr</h2>

        <p>Indmeldelsesgebyret er ' . LANGEKURSER_STANDARDPRISER_TILMELDINGSGEBYR . ' kr for alle kursusperioder. Gebyret skal betales ved tilmeldingen. Enten vedl�gges en check til &#8221;ans�gning om optagelse&#8221;, bel�bet betales online eller overf�res til kontonummer 7244-1469664 i Jyske Bank. Ved eventuel framelding senest 1 m�ned f�r kursusstart refunderes halvdelen af indmeldelsesgebyret.</p>

        <h2>2. Materialegebyr samt rejse- og n�gledepositum</h2>

        '.$tpl->render($this, $data).'

        <p>Materialegebyret, rejse- og n�gledepositum indbetales senest 2 m�neder f�r kursusstart. Ved framelding inden kursusstart refunderes rejse- og n�gledepositum, samt den del af materialegebyret, som vedr�rer endnu ikke indk�bte materialer.</p>

        <h2>3. M�nedlige betalinger af kursusgebyr</h2>
        <p>Kursusgebyret indbetales i m�nedlige rater.</p>

        <ul>
            <li>Hold med start i august betaler 1. rate senest 1. august</li>
            <li>Hold med start i september betaler 1. rate senest 1. september</li>
            <li>Hold med start i januar betaler 1. rate senest 1. december</li>
            <li>Hold med start i februar betaler 1. rate senest 1. februar</li>
        </ul>

        <p>Udmeldelse under kursusforl�bet medf�rer if�lge vejledning af undervisningsministeriet opkr�vning af 4 ugers till�gsbetaling. Der ydes ikke kommunest�tte, individuel supplerende elevst�tte, indvandrerst�tte eller kompetencest�tte til reduktion af dette bel�b.</p>

        <p>I henhold til lovgivningen tr�kkes tilsagn om kommunest�tte, indvandrerst�tte og kompetencest�tte tilbage, hvis eleven ikke gennemf�rer mindst 12 uger af et kursusforl�b. Dette bel�b skal alts� efterbetales ved afbrydelse af kursus i utide.</p>

        <p>Eventuelt frav�r under kurset medf�rer ikke ret til reduceret betaling.</p>

        <h2>4. �vrige betalinger</h2>
        <p>Der opkr�ves s�rskilt betaling for rejser. Det indbetalte depositum ved kursusstart d�kker kun en del af rejseudgifterne. Der kan forekomme s�rlige udgifter for dig til v�rkstedsfag og ekskursioner.</p>

        ';
    }
}