<?php
class VIH_Controller_KortKursus_PraktiskeOplysninger extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $title = 'Praktiske oplysninger om korte kurser';
        $meta['description'] = 'Praktiske oplysninger om de kortekurser.';
        $meta['keywords'] = 'korte, hï¿½jskolekurser, hï¿½jskolekursus, sommerkurser, sommerkursus, hï¿½jskoleophold, rettigheder, pligter';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $data = array('content' => '
        <h1>Praktiske oplysninger</h1>
        <h3>Vï¿½relser</h3>
        <p>Pï¿½ hï¿½jskolen: Indkvartering i dobbeltvï¿½relser, med bad og toilet pï¿½ gangene. I kursuscenter: Dobbeltvï¿½relser med bad og toilet. Enkeltvï¿½relser, hvor to personer deler bad og toilet.</p>
        <h3>Kursuspris</h3>
        <p>Den angivne kursuspris er en totalpris, som dï¿½kker helpension, logi med sengetï¿½j, undervisning og udflugter.</p>
        <h3>Faciliteter</h3>
        <p>Skolen rï¿½der over gode undervisnings- og opholdslokaler, TV-lokaler, sauna, mange idrï¿½tsfaciliteter og opvarmet, udendï¿½rs svï¿½mmebassin. Kig i ï¿½vrigt under <a href="'.url('/faciliteter/').'">faciliteterne</a>.</p>
        <h3>Tilmeldingsmateriale</h3>
        <p>Du kan bestille tilmeldingsmateriale pï¿½ <a href="'.url('/bestilling/').'">onlinebestillingsformularen</a>, eller du kan ringe til skolen. Du kan ogsï¿½ <a href="'.url('/kortekurser/').'">tilmelde dig et kursus</a> direkte fra vores side.</p>
        <h3>Flere spï¿½rgsmï¿½l</h3>
        <p>Hvis du ikke har fï¿½et svar pï¿½ alle dine spï¿½rgsmï¿½l, er du meget velkommen til at ringe til kontoret.</p>
        <h3>Beliggenhed - find vej</h3>
        <p>Kig her for skolens <a href="'.url('/kontakt/beliggenhed').'">beliggenhed</a>.</p>
        <h3 title="pligter">Undervisning</h3>
        <p>Der er mï¿½depligt til undervisningen. Det er et lovgivningskrav, da du modtager tilskud til kurset fra staten.</p>
        <h3>Kontakt</h3>
        <p>Her finder du <a href="'.url('/kontakt').'">kontaktinformation og ï¿½bningstider</a> til kontoret.</p>
        ');

        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);

    }
}