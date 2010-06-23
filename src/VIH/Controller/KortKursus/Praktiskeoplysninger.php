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
        $meta['keywords'] = 'korte, h�jskolekurser, h�jskolekursus, sommerkurser, sommerkursus, h�jskoleophold, rettigheder, pligter';

        $this->document->setTitle($title);
        $this->document->meta = $meta;

        $data = array('content' => '
        <h1>Praktiske oplysninger</h1>
        <h3>V�relser</h3>
        <p>P� h�jskolen: Indkvartering i dobbeltv�relser, med bad og toilet p� gangene. I kursuscenter: Dobbeltv�relser med bad og toilet. Enkeltv�relser, hvor to personer deler bad og toilet.</p>
        <h3>Kursuspris</h3>
        <p>Den angivne kursuspris er en totalpris, som d�kker helpension, logi med senget�j, undervisning og udflugter.</p>
        <h3>Faciliteter</h3>
        <p>Skolen r�der over gode undervisnings- og opholdslokaler, TV-lokaler, sauna, mange idr�tsfaciliteter og opvarmet, udend�rs sv�mmebassin. Kig i �vrigt under <a href="'.url('/faciliteter/').'">faciliteterne</a>.</p>
        <h3>Tilmeldingsmateriale</h3>
        <p>Du kan bestille tilmeldingsmateriale p� <a href="'.url('/bestilling/').'">onlinebestillingsformularen</a>, eller du kan ringe til skolen. Du kan ogs� <a href="'.url('/kortekurser/').'">tilmelde dig et kursus</a> direkte fra vores side.</p>
        <h3>Flere sp�rgsm�l</h3>
        <p>Hvis du ikke har f�et svar p� alle dine sp�rgsm�l, er du meget velkommen til at ringe til kontoret.</p>
        <h3>Beliggenhed - find vej</h3>
        <p>Kig her for skolens <a href="'.url('/kontakt/beliggenhed').'">beliggenhed</a>.</p>
        <h3 title="pligter">Undervisning</h3>
        <p>Der er m�depligt til undervisningen. Det er et lovgivningskrav, da du modtager tilskud til kurset fra staten.</p>
        <h3>Kontakt</h3>
        <p>Her finder du <a href="'.url('/kontakt').'">kontaktinformation og �bningstider</a> til kontoret.</p>
        ');

        $tpl = $this->template->create('wrapper');
        return $tpl->render($this, $data);

    }
}