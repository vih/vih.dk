<?php
class VIH_Controller_LangtKursus_Tilmelding_Kvittering extends k_Component
{
    protected $template;
    protected $doctrine;

    function __construct(k_TemplateFactory $template, Doctrine_Connection_Common $doctrine)
    {
        $this->template = $template;
        $this->doctrine = $doctrine;
    }

    function GET()
    {
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($this->context->name());

        if (!$tilmelding->getId()) {
            throw new Exception('Du har ikke adgang til at være her');
        }

        $tilmelding->getPriserFromKursus();

        $this->document->setTitle('Kvittering for reservation af plads');

        return  $this->getKvittering($tilmelding) . '
            <h2>Betaling</h2>
        ' . $this->getBetaling($tilmelding). '
            <h2>Program og yderligere oplysninger</h2>
            <p>Vi sender flere oplysninger til dig, inden kurset starter, hvor du kan læse om vores forventninger til dig, hvad vi skal lave og hvad du skal have med. Vi glæder os til at se dig i Vejle.</p>
            <ul class="options">
                <li><a id="close" href="'.$this->url('../close').'">Luk tilmeldingen og gå tilbage til forsiden</a></li>
            </ul>
        ';
    }

    function getOplysninger($tilmelding)
    {
        $data = array('tilmelding' => $tilmelding,
                      'caption' => 'Vi har registreret følgende oplysninger');
        $tpl = $this->template->create('LangtKursus/Tilmelding/oplysninger');
        return $tpl->render($this, $data);

    }

    function getKvittering($tilmelding)
    {
        $data = array('headline' => 'Kvittering for reservation',
                      'explanation' => '
            <p>Tak for din tilmelding. Foreløbig har du reserveret en plads. Din reservation gælder i otte dage. Du er først endelig tilmeldt kurset, når du har gjort følgende:</p>
            <ul>
                <li><strong>betalt ' . number_format($tilmelding->kursus->get('pris_tilmeldingsgebyr'), 0, ',', '') . ' kroner</strong> som dækker tilmeldingsgebyret</li>
                <li><strong>modtaget bekræftelse</strong>. Den sender vi, når vi har modtaget tilmeldingsgebyret.</li>
            </ul>
        ',
                      'oplysninger' => $this->getOplysninger($tilmelding));

        $tpl = $this->template->create('LangtKursus/Tilmelding/kvittering');
        return $tpl->render($this, $data);
    }

    function getBetaling($tilmelding)
    {
        $data = array('login_uri' => $this->url('/login/langekurser/'. $tilmelding->get('code')),
                      'tilmelding' => $tilmelding);
        $tpl = $this->template->create('Tilmelding/betaling');
        return $tpl->render($this, $data);
    }
}