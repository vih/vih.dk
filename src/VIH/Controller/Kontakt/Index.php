<?php
class VIH_Controller_Kontakt_Index extends k_Controller
{
    public $map = array('elevchat'    => 'VIH_Controller_Kontakt_Elevchat',
                        'beliggenhed' => 'VIH_Controller_Kontakt_Beliggenhed',
    );

    function GET()
    {
        $title = 'Kontakt';
        $meta['description'] = 'Her finder du kontaktinformation om højskolen. Adresse, telefonnumre og e-mail-adresser på det administrative personale på skolens kontor.';
        $meta['keywords'] = 'Vejle, idrætshøjskole, jyske, idrætsskole, beliggenhed, telefonnummer, kontakt, åbningstider, elevtelefon, administrativt personale, markedsføring, marketing, annoncer, forretningsfører, forstander, e-post, epost, email, e-mail, adresseliste, skolens kontor, telefon, telefontid';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'kontakt';

        $data = array('content' => '
        <h1>Kontakt</h1>
        <p>Du er altid velkommen til at kontakte os, hvis du har ubesvarede spørgsmål. Du kan kontakte os på forskellig vis - se nedenfor. Vi <a href="'.url('/om/persondata').'">håndterer altid informationer og henvendelser fortroligt</a>.</p>
        <p>Du er altid velkommen til at kigge forbi skolen. Det er dog en god ide at aftale et tidspunkt først, så du kan blive vist rundt.</p>

        <table class="vcard skema" summary="Kontaktoplysninger til Vejle Idrætshøjskole, e-mail, epost, e-post, email, telefon, fax, telefonnummer, faxnummer">
        <caption>Adresseoplysninger og telefonnumre</caption>
            <tbody>
            <tr>
                <th scope="row">Adresse</th>
                <td>
                    <span class="fn">Vejle Idrætshøjskole</span><br />
                    <span class="adr">Ørnebjergvej 28<br />
                    <span class="postal-code">7100</span> <span class="locality">Vejle</span>
                    <p><a href="'.url('/kontakt/beliggenhed').'">Kørselsvejledning >></a></p>
                </td>
            </tr>
            <tr>
                <th scope="row">Telefon</th>
                <td class="tel">(+45) 7582 0811</td>
            </tr>
            <tr>
                <th scope="row">Faxnummer</th>
                <td class="fax">(+45) 7582 0680</td>
            </tr>
            <tr>
                <th valign="top" scope="row">E-mail</th>
                <td>
                    <span class="email">' . email('kontor@vih.dk') . '</span>
                </td>
            </tr>
            <tr>
                <th scope="row">CVR-nummer</th>
                <td>36 85 07 28</td>
            </tr>
            <tr>
                <th valign="top" scope="row">Kontortid </th>
                <td>Mandag - fredag<br />
                    8.00-16.00
                </td>
            </tr>
            </tbody>
        </table>

        <table class="skema" summary="Kontaktoplysninger til den enkelte medarbejder">
        <caption>Kontaktpersoner</caption>
        <thead>
            <tr>
                <th scope="col" id="titelth">Titel</th>
                <th scope="col" id="navnth">Navn</th>
                <th scope="col" id="emailth">E-mail</th>
                <th scope="col" id="telefonth">Telefon</th>
            </tr>
        </thead>
        <tbody>
            <tr class="vcard">
                <th scope="row" headers="titelth">Forstander</th>
                <td headers="navnth" class="fn">Erik Sidenius</td>
                <td headers="emailth" class="email">' .  email('erik@vih.dk') . '</td>
               <td headers="telefonth" class="tel">(+45) 7982 0811</td>
            </tr>
            <tr class="vcard">
                <th scope="row" headers="titelth">Kursuscenter og booking</th>
                <td headers="navnth" class="fn">Trine Smed</td>
                <td headers="emailth" class="email">' . email('kursuscenter@vih.dk') . '</td>
                <td headers="telefonth" class="tel">(+45) 7572 6900</td>
            </tr>
            <tr class="vcard">
                <th scope="row" headers="titelth">Webmaster</th>
                <td headers="navnth" class="fn">Lars Olesen</td>
                <td headers="emailth" class="email">' . email('webmaster@vih.dk') . '</td>
                <td headers="telefonth" class="tel">(+45) 7582 0811</td>
            </tr>
            <tr class="vcard">
                <th scope="row" headers="titelth">Køkkenleder</th>
                <td headers="navnth" class="fn">Henrik Boysen</td>
                <td headers="emailth" class="email">' . email('kokken@vih.dk') . '</td>
                <td headers="telefonth" class="tel">(+45) 7942 5404</td>
            </tr>
            <tr class="vcard">
                <th scope="row" headers="titelth">Pedelformand</th>
                <td headers="navnth" class="fn">Niels Beck</td>
                <td headers="emailth" class="email">' . email('pedel@vih.dk') . '</td>
                <td headers="telefonth" class="tel">(+45) 7942 5409</td>
            </tr>
            <tr class="vcard">
                <th scope="row" headers="titelth">Bestyrelsen</th>
                <td headers="navnth" class="fn url"><a href="'.url('/info/organisation').'">Bestyrelsen</a></td>
                <td headers="emailth" class="email">' . email('kontor@vih.dk') . '</td>
                <td headers="telefonth" class="tel">(+45) 7582 0811</td>
            </tr>
        </tbody>
        </table>

        <p>Du kan skrive til lærerne fra <a href="'.url('/underviser/').'">lærersiden</a>.</p>
        ');

        return $this->render('VIH/View/wrapper-tpl.php', $data);
    }

    function forward($name)
    {
        if (empty($this->map[$name])) {
            throw new k_http_Response(404);
        }
        $nxt = new $this->map[$name]($this, $name);
        $data = array('content' => $nxt->handleRequest());
        return $this->render('VIH/View/wrapper-tpl.php', $data);
    }
}