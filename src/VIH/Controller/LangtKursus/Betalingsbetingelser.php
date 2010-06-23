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
        $title = 'Betalingsbetingelser for de lange hï¿½jskolekurser';
        $meta['description'] = 'Betalingsbetingelser for de lange hï¿½jskolekurser pï¿½ Vejle Idrï¿½tshï¿½jskole.';
        $meta['keywords'] = 'vejle idrï¿½tshï¿½jskole, betaling, betalingsbetingelser, ï¿½konomi, indmeldelsesgebyr, indmelding, indmeldelse';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $data = array('kurser' => VIH_Model_LangtKursus::getList('open'));

        $this_year = date("Y");
        $next_year = $this_year + 1;

        $tpl = $this->template->create('LangtKursus/okonomi');

        return '

        <h1>Betalingsbetingelser ' .  $this_year . '/' . $next_year . '</h1>

        <h2>1. Indmeldelsesgebyr</h2>

        <p>Indmeldelsesgebyret er ' . LANGEKURSER_STANDARDPRISER_TILMELDINGSGEBYR . ' kr for alle kursusperioder. Gebyret skal betales ved tilmeldingen. Enten vedlï¿½gges en check til &#8221;ansï¿½gning om optagelse&#8221;, belï¿½bet betales online eller overfï¿½res til kontonummer 7244-1469664 i Jyske Bank. Ved eventuel framelding senest 1 mï¿½ned fï¿½r kursusstart refunderes halvdelen af indmeldelsesgebyret.</p>

        <h2>2. Materialegebyr samt rejse- og nï¿½gledepositum</h2>

        '.$tpl->render($this, $data).'

        <p>Materialegebyret, rejse- og nï¿½gledepositum indbetales senest 2 mï¿½neder fï¿½r kursusstart. Ved framelding inden kursusstart refunderes rejse- og nï¿½gledepositum, samt den del af materialegebyret, som vedrï¿½rer endnu ikke indkï¿½bte materialer.</p>

        <h2>3. Mï¿½nedlige betalinger af kursusgebyr</h2>
        <p>Kursusgebyret indbetales i mï¿½nedlige rater.</p>

        <ul>
            <li>Hold med start i august betaler 1. rate senest 1. august</li>
            <li>Hold med start i september betaler 1. rate senest 1. september</li>
            <li>Hold med start i januar betaler 1. rate senest 1. december</li>
            <li>Hold med start i februar betaler 1. rate senest 1. februar</li>
        </ul>

        <p>Udmeldelse under kursusforlï¿½bet medfï¿½rer ifï¿½lge vejledning af undervisningsministeriet opkrï¿½vning af 4 ugers tillï¿½gsbetaling. Der ydes ikke kommunestï¿½tte, individuel supplerende elevstï¿½tte, indvandrerstï¿½tte eller kompetencestï¿½tte til reduktion af dette belï¿½b.</p>

        <p>I henhold til lovgivningen trï¿½kkes tilsagn om kommunestï¿½tte, indvandrerstï¿½tte og kompetencestï¿½tte tilbage, hvis eleven ikke gennemfï¿½rer mindst 12 uger af et kursusforlï¿½b. Dette belï¿½b skal altsï¿½ efterbetales ved afbrydelse af kursus i utide.</p>

        <p>Eventuelt fravï¿½r under kurset medfï¿½rer ikke ret til reduceret betaling.</p>

        <h2>4. ï¿½vrige betalinger</h2>
        <p>Der opkrï¿½ves sï¿½rskilt betaling for rejser. Det indbetalte depositum ved kursusstart dï¿½kker kun en del af rejseudgifterne. Der kan forekomme sï¿½rlige udgifter for dig til vï¿½rkstedsfag og ekskursioner.</p>

        ';
    }
}