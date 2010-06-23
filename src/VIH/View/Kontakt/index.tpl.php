        <h1>Kontakt</h1>
        <p>Du er altid velkommen til at kontakte os, hvis du har ubesvarede spørgsmål. Du kan kontakte os på forskellig vis - se nedenfor. Vi <a href="<?php e(url('/om/persondata')); ?>">håndterer altid informationer og henvendelser fortroligt</a>.</p>
        <p>Du er altid velkommen til at kigge forbi skolen. Det er dog en god ide at aftale et tidspunkt først, så du kan blive vist rundt.</p>

        <table class="vcard skema" summary="Kontaktoplysninger til Vejle Idrætshøjskole, e-mail, epost, e-post, email, telefon, fax, telefonnummer, faxnummer">
        <caption>Adresseoplysninger og telefonnumre</caption>
            <tbody>
            <tr>
                <th scope="row">Adresse</th>
                <td>
                    <span class="fn">Vejle Idrætshøjskole</span><br />
                    <span class="adr">Ørnebjergvej 28</span><br />
                    <span class="postal-code">7100</span> <span class="locality">Vejle</span>
                    <p><a href="<?php e(url('/kontakt/beliggenhed')); ?>">Kørselsvejledning <?php e('>>'); ?></a></p>
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
                    <span class="email"><?php e(email('kontor@vih.dk')); ?></span>
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
                <td headers="navnth" class="fn">Ole Damgaard</td>
                <td headers="emailth" class="email"><?php e(email('ole@vih.dk')); ?></td>
               <td headers="telefonth" class="tel">(+45) 7982 0811</td>
            </tr>
            <tr class="vcard">
                <th scope="row" headers="titelth">Kursuscenter og booking</th>
                <td headers="navnth" class="fn">Søs Pedersen</td>
                <td headers="emailth" class="email"><?php e(email('kursuscenter@vih.dk')); ?></td>
                <td headers="telefonth" class="tel">(+45) 7572 6900</td>
            </tr>
            <tr class="vcard">
                <th scope="row" headers="titelth">Webmaster</th>
                <td headers="navnth" class="fn">Lars Olesen</td>
                <td headers="emailth" class="email"><?php e(email('webmaster@vih.dk')); ?></td>
                <td headers="telefonth" class="tel">(+45) 7582 0811</td>
            </tr>
            <tr class="vcard">
                <th scope="row" headers="titelth">Køkkenleder</th>
                <td headers="navnth" class="fn">Henrik Boysen</td>
                <td headers="emailth" class="email"><?php e(email('kokken@vih.dk')); ?></td>
                <td headers="telefonth" class="tel">(+45) 7942 5404</td>
            </tr>
            <tr class="vcard">
                <th scope="row" headers="titelth">Pedelformand</th>
                <td headers="navnth" class="fn">Niels Beck</td>
                <td headers="emailth" class="email"><?php e(email('pedel@vih.dk')); ?></td>
                <td headers="telefonth" class="tel">(+45) 7942 5409</td>
            </tr>
            <tr class="vcard">
                <th scope="row" headers="titelth">Bestyrelsen</th>
                <td headers="navnth" class="fn url"><a href="<?php e(url('/info/organisation')); ?>">Bestyrelsen</a></td>
                <td headers="emailth" class="email"><?php e(email('kontor@vih.dk')); ?></td>
                <td headers="telefonth" class="tel">(+45) 7582 0811</td>
            </tr>
        </tbody>
        </table>

        <p>Du kan skrive til lærerne fra <a href="<?php e(url('/underviser/')); ?>">lærersiden</a>.</p>
