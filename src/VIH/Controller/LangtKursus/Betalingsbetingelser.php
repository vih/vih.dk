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
        $title = 'Betalingsbetingelser for de lange højskolekurser';
        $meta['description'] = 'Betalingsbetingelser for de lange højskolekurser på Vejle Idrætshøjskole.';
        $meta['keywords'] = 'vejle idrætshøjskole, betaling, betalingsbetingelser, økonomi, indmeldelsesgebyr, indmelding, indmeldelse';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $data = array('kurser' => VIH_Model_LangtKursus::getList('open'));

        $this_year = date("Y");
        $next_year = $this_year + 1;

        $tpl = $this->template->create('LangtKursus/økonomi');

        return '

        <h1>Betalingsbetingelser ' .  $this_year . '/' . $next_year . '</h1>

        <h2>1. Indmeldelsesgebyr</h2>

        <p>Indmeldelsesgebyret er ' . LANGEKURSER_STANDARDPRISER_TILMELDINGSGEBYR . ' kr for alle kursusperioder. Gebyret skal betales ved tilmeldingen. Enten vedlægges en check til &#8221;ansøgning om optagelse&#8221;, beløbet betales online eller overføres til kontonummer 7244-1469664 i Jyske Bank. Ved eventuel framelding senest 1 måned får kursusstart refunderes halvdelen af indmeldelsesgebyret.</p>

        <h2>2. Materialegebyr samt rejse- og nøgledepositum</h2>

        '.$tpl->render($this, $data).'

        <p>Materialegebyret, rejse- og nøgledepositum indbetales senest 2 måneder før kursusstart. Ved framelding inden kursusstart refunderes rejse- og nøgledepositum, samt den del af materialegebyret, som vedrører endnu ikke indkøbte materialer.</p>

        <h2>3. Månedlige betalinger af kursusgebyr</h2>
        <p>Kursusgebyret indbetales i månedlige rater.</p>

        <ul>
            <li>Hold med start i august betaler 1. rate senest 1. august</li>
            <li>Hold med start i september betaler 1. rate senest 1. september</li>
            <li>Hold med start i januar betaler 1. rate senest 1. december</li>
            <li>Hold med start i februar betaler 1. rate senest 1. februar</li>
        </ul>

        <p>Udmeldelse under kursusforløbet medfører ifølge vejledning af undervisningsministeriet opkrævning af 4 ugers tillægsbetaling. Der ydes ikke kommunestøtte, individuel supplerende elevstøtte, indvandrerstøtte eller kompetencestøtte til reduktion af dette beløb.</p>

        <p>I henhold til lovgivningen trækkes tilsagn om kommunestøtte, indvandrerstøtte og kompetencestøtte tilbage, hvis eleven ikke gennemfører mindst 12 uger af et kursusforløb. Dette beløb skal altså efterbetales ved afbrydelse af kursus i utide.</p>

        <p>Eventuelt fravær under kurset medfører ikke ret til reduceret betaling.</p>

        <h2>4. Øvrige betalinger</h2>
        <p>Der opkræves særskilt betaling for rejser. Det indbetalte depositum ved kursusstart dækker kun en del af rejseudgifterne. Der kan forekomme særlige udgifter for dig til værkstedsfag og ekskursioner.</p>

        ';
    }
}