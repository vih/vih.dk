<?php
class VIH_Controller_LangtKursus_Tilmelding_Kvittering extends k_Controller
{
    function GET()
    {
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($this->context->name);

        if (!$tilmelding->getId()) {
            throw new Exception('Du har ikke adgang til at v�re her');
        }

        $tilmelding->getPriserFromKursus();

        $this->document->title = 'Kvittering for reservation af plads';

        return  $this->getKvittering($tilmelding) . '
            <h2>Betaling</h2>
        ' . $this->getBetaling($tilmelding). '
            <h2>Program og yderligere oplysninger</h2>
            <p>Vi sender flere oplysninger til dig, inden kurset starter, hvor du kan l�se om vores forventninger til dig, hvad vi skal lave og hvad du skal have med. Vi gl�der os til at se dig i Vejle.</p>
            <ul class="options">
                <li><a id="close" href="'.$this->url('../close').'">Luk tilmeldingen og g� tilbage til forsiden</a></li>
            </ul>
        ';
    }

    function getOplysninger($tilmelding)
    {
        $data = array('tilmelding' => $tilmelding,
                      'caption' => 'Vi har registreret f�lgende oplysninger');
        return $this->render('VIH/View/LangtKursus/Tilmelding/oplysninger-tpl.php', $data);

    }

    function getKvittering($tilmelding)
    {
        $data = array('headline' => 'Kvittering for reservation',
                      'explanation' => '
            <p>Tak for din tilmelding. Forel�big har du reserveret en plads. Din reservation g�lder i otte dage. Du er f�rst endelig tilmeldt kurset, n�r du har gjort f�lgende:</p>
            <ul>
                <li><strong>betalt ' . number_format($tilmelding->kursus->get('pris_tilmeldingsgebyr'), 0, ',', '') . ' kroner</strong> som d�kker tilmeldingsgebyret</li>
                <li><strong>modtaget bekr�ftelse</strong>. Den sender vi, n�r vi har modtaget tilmeldingsgebyret.</li>
            </ul>
        ',
                      'oplysninger' => $this->getOplysninger($tilmelding));
        return $this->render('VIH/View/LangtKursus/Tilmelding/kvittering-tpl.php', $data);
    }

    function getBetaling($tilmelding)
    {
        $data = array('login_uri' => $this->url('/login/langekurser/'. $tilmelding->get('code')),
                      'tilmelding' => $tilmelding);
        return $this->render('VIH/View/Tilmelding/betaling-tpl.php', $data);
    }
}