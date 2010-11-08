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
        $meta['keywords'] = 'korte, højskolekurser, højskolekursus, sommerkurser, sommerkursus, højskoleophold, rettigheder, pligter';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $data = array('content' => '
        <h1>Praktiske oplysninger</h1>
        <h3>Værelser</h3>
        <p>På højskolen: Indkvartering i dobbeltværelser, med bad og toilet på gangene. I kursuscenter: Dobbeltværelser med bad og toilet. Enkeltværelser, hvor to personer deler bad og toilet.</p>
        <h3>Kursuspris</h3>
        <p>Den angivne kursuspris er en totalpris, som dækker helpension, logi med sengetøj, undervisning og udflugter.</p>
        <h3>Faciliteter</h3>
        <p>Skolen råder over gode undervisnings- og opholdslokaler, TV-lokaler, sauna, mange idrætsfaciliteter og opvarmet, udendørs svømmebassin. Kig i øvrigt under <a href="'.$this->url('/faciliteter/').'">faciliteterne</a>.</p>
        <h3>Tilmeldingsmateriale</h3>
        <p>Du kan bestille tilmeldingsmateriale på <a href="'.$this->url('/bestilling/').'">onlinebestillingsformularen</a>, eller du kan ringe til skolen. Du kan også <a href="'.$this->url('/kortekurser/').'">tilmelde dig et kursus</a> direkte fra vores side.</p>
        <h3>Flere spørgsmål</h3>
        <p>Hvis du ikke har fået svar på alle dine spørgsmål, er du meget velkommen til at ringe til kontoret.</p>
        <h3>Beliggenhed - find vej</h3>
        <p>Kig her for skolens <a href="'.$this->url('/kontakt/beliggenhed').'">beliggenhed</a>.</p>
        <h3 title="pligter">Undervisning</h3>
        <p>Der er mødepligt til undervisningen. Det er et lovgivningskrav, da du modtager tilskud til kurset fra staten.</p>
        <h3>Kontakt</h3>
        <p>Her finder du <a href="'.$this->url('/kontakt').'">kontaktinformation og åbningstider</a> til kontoret.</p>
        ');

        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);
    }
}