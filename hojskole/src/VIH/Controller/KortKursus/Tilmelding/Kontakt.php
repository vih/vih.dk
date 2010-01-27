<?php
/**
 * Indtaste kontaktoplysninger om kunden
 *
 * Hvis ordren skal afbrydes henvises til siden afbryd.php
 *
 * @author Lars Olesen <lars@legestue.net>
 */
class VIH_Controller_KortKursus_Tilmelding_Kontakt extends k_Controller
{
    private $form;

    function getForm()
    {
        if (is_object($this->form)) {
            return $this->form;
        }
        $tilmelding = $this->getTilmelding();
        $deltagere = $tilmelding->getDeltagere();

        $this->form = new HTML_QuickForm(null, 'post', $this->url(), '', null, true);
        $this->form->removeAttribute('name');
        $renderer = new HTML_QuickForm_Renderer_Tableless();

        $this->form->addElement('header', null, 'Kontaktperson');
        $this->form->addElement('text', 'kontaktnavn', 'Navn');
        $this->form->addElement('text', 'adresse', 'Adresse');
        $this->form->addElement('text', 'postnr', 'Postnummer');
        $this->form->addElement('text', 'postby', 'By');
        $this->form->addElement('text', 'telefonnummer', 'Telefonnummer');
        //$this->form->addElement('text', 'arbejdstelefon', 'Telefon (ml. 8 og 16)', 'Telefonnummer hvor du kan træffes mellem 8 og 16');
        //$this->form->addElement('text', 'mobil', 'Mobil');
        $this->form->addElement('text', 'email', 'E-mail'); // 'Bekræftelse sendes til denne e-mail-adresse. Hvis den udelades bruger vi Post Danmark.'
        $this->form->addElement('header', null, 'Vil du tegne afbestillingsforsikring');
        $this->form->addElement('radio', 'afbestillingsforsikring', 'Afbestillingsforsikring', 'Ja ('.$tilmelding->getKursus()->get('pris_afbestillingsforsikring').' kr ekstra)', 'Ja', 'id="forsikring_ja"');
        $this->form->addElement('radio', 'afbestillingsforsikring', '', 'Nej', 'Nej', 'id="forsikring_nej"');

        $this->form->addRule('kontaktnavn', 'Skriv venligst dit navn', 'required');
        $this->form->addRule('adresse', 'Skriv venligst din adresse', 'required');
        $this->form->addRule('postnr', 'Skriv venligst din postnummer', 'required');
        $this->form->addRule('postby', 'Skriv venligst din postby', 'required');
        $this->form->addRule('telefonnummer', 'Skriv venligst din telefonnummer', 'required');
        $this->form->addRule('arbejdstelefon', 'Skriv venligst din arbejdstelefon', 'required');
        $this->form->addRule('email', 'Den e-mail du har indtastet er ikke gyldig', 'email');
        $this->form->addRule('afbestillingsforsikring', 'Du skal vælge, om du vil have en afbestillingsforsikring', 'required');

        $defaults = array(
        	'kontaktnavn' => $tilmelding->get('navn'),
            'adresse' => $tilmelding->get('adresse'),
            'postnr' => $tilmelding->get('postnr'),
            'postby' => $tilmelding->get('postby'),
            'telefonnummer' => $tilmelding->get('telefonnummer'),
            'arbejdstelefon' => $tilmelding->get('arbejdstelefon'),
            'mobil' => $tilmelding->get('mobil'),
            'email' => $tilmelding->get('email'),
            'afbestillingsforsikring' => $tilmelding->get('afbestillingsforsikring'),
            'besked' => $tilmelding->get('besked'));

        $this->form->setDefaults($defaults);

        $deltager_nummer = 1;
        $i = 0;

        //$this->form->registerRule('validate_cpr', 'callback', 'validateCpr');
        foreach ($deltagere AS $deltager) {
            $this->form->addElement('header', null, 'Deltager ' .  $deltager_nummer);
            $this->form->addElement('hidden', 'id['.$i.']');
            $this->form->addElement('text', 'navn['.$i.']', 'Navn');
            $this->form->addElement('text', 'cpr['.$i.']', 'CPR-nummer', '(ddmmåå-xxxx)', null);
            $this->form->addRule('navn['.$i.']', 'Du skal skrive et navn', 'required');
            $this->form->addRule('cpr['.$i.']', 'Du skal skrive et cpr-nummer', 'required');
            //$this->form->addRule('cpr['.$i.']', 'Du skal skrive et gyldigt cpr-nummer', 'validate_cpr');
            $this->form->setDefaults(array('id['.$i.']' => $deltager->get('id'),
                                     'navn['.$i.']' => $deltager->get('navn'),
                                     'cpr['.$i.']' => $deltager->get('cpr')));
            $radio = array();

            /*
            switch ($tilmelding->kursus->get('indkvartering')) {
                case 'kursuscenteret':
                    $this->form->addElement('radio', 'enevaerelse['.$i.']', 'Der er indkvartering på eneværelser', '', 'ja', 'id="vaerelse_ja"');
                    $this->form->addElement('text', 'sambo['.$i.']', 'Jeg ønsker at dele toilet og bad med?');
                    $this->form->addRule('enevaerelse['.$i.']', 'Der er kun indkvartering på eneværelser', 'required');
                    // $this->form->addRule('sambo['.$i.']', 'Hvem vil du dele toilet og bad med?', 'required');
                    $this->form->setDefaults(array(
                    	'enevaerelse['.$i.']' => true,
                        'sambo['.$i.']' => $deltager->get('sambo')));
                    break;
                case 'hojskole og kursuscenter':
                    $this->form->addElement('radio', 'vaerelse['.$i.']', 'Indkvartering', 'Enkeltværelse (bad og toilet deles med en anden)', 'enkelt', 'id="vaerelse_1"');
                    $this->form->addElement('radio', 'vaerelse['.$i.']', '', 'Dobbeltværelse', 'dobbelt', 'id="vaerelse_2"');
                    $this->form->addElement('radio', 'vaerelse['.$i.']', '', 'Plads i rum til 3 personer', '3-personers', 'id="vaerelse_3"');
                    $this->form->addElement('text', 'sambo['.$i.']', 'Jeg ønsker at dele toilet og bad med?');
                    $this->form->addRule('vaerelse['.$i.']', 'Du skal vælge værelsestype', 'required');
                    // $this->form->addRule('sambo['.$i.']', 'Hvem vil du dele toilet og bad med?', 'required');
                    $this->form->setDefaults(array(
                    	'vaerelse['.$i.']' => $deltager->get('vaerelse'),
                        'sambo['.$i.']' => $deltager->get('sambo')));
                    break;
            }
            */
            if (!$tilmelding->kursus->isFamilyCourse()) {
                $indkvartering_headline = 'Indkvartering';
                foreach ($tilmelding->kursus->getIndkvartering() as $key => $indkvartering) {
                    $this->form->addElement('radio', 'indkvartering_key['.$i.']', $indkvartering_headline, $indkvartering['text'], $indkvartering['indkvartering_key'], 'id="vaerelse_'.$indkvartering['indkvartering_key'].'"');
                    $indkvartering_headline = '';
                }
                if (empty($indkvartering_headline)) {
                    $this->form->addElement('text', 'sambo['.$i.']', 'Vil gerne dele bad og toilet / værelse med?');
                    $this->form->setDefaults(array(
                        	'indkvartering_key['.$i.']' => $deltager->get('indkvartering_key'),
                            'sambo['.$i.']' => $deltager->get('sambo')));
                    $this->form->addRule('vaerelse['.$i.']', 'Du skal vælge en indkvarteringsform', 'required');
                }
            }
            switch ($tilmelding->kursus->get('gruppe_id')) {

                case 1: // golf
                    $this->form->addElement('text', 'handicap['.$i.']', 'Golfhandicap (begynder = 99)', '');
                    $this->form->addElement('text', 'klub['.$i.']', 'Klub');
                    $this->form->addElement('radio', 'dgu['.$i.']', 'DGU-medlem', 'Ja', 'Ja', 'id="dgu_ja"');
                    $this->form->addElement('radio', 'dgu['.$i.']', '', 'Nej', 'Nej', 'id="dgu_nej"');

                    $this->form->addRule('handicap['.$i.']', 'Du skal vælge dit handicap', 'required');
                    // nedenstående regel skal lige aktiveres
                    //$this->form->addRule('handicap['.$i.']', 'Du skal skrive et gyldig handicap', '');

                    $this->form->setDefaults(array('handicap['.$i.']' => $deltager->get('handicap'),
                                             'klub['.$i.']' => $deltager->get('klub'),
                                             'dgu['.$i.']' => $deltager->get('dgu')));
                    break;
                case 3: // bridge
                    //$niveau = array('Begynder' => 'Begynder', 'Let øvet' => 'Let øvet', 'Øvet' => 'Øvet', 'Meget øvet' => 'Meget øvet');
                    $niveau = array('Let øvet' => 'Let øvet', 'Øvet' => 'Øvet', 'Meget øvet' => 'Meget øvet');
                    $this->form->addElement('select', 'niveau['.$i.']', 'Bridgeniveau', $niveau);
                    $this->form->addRule('niveau['.$i.']', 'Hvilket bridgeniveau har du?', 'required');
                    $this->form->setDefaults(array('niveau['.$i.']' => $deltager->get('niveau')));
                    break;
                case 5:
                    $speciale = array('Vælg', 'adventure' => 'Adventure', 'outdoor' => 'Outdoor Energy', 'fitness' => 'Fitness', 'boldspil' => 'Boldspil', 'dans' => 'Dans');
                    $this->form->addElement('select', 'speciale['.$i.']', 'Idrætsspeciale', $speciale);
                    $this->form->setDefaults(array('speciale['.$i.']' => $deltager->get('speciale')));
                    break;
                default:
                    break;
            } // switch

            $deltager_nummer++;
            $i++;
        } // foreach

        $this->form->addElement('header', null, 'Øvrige oplysninger');
        $this->form->addElement('textarea', 'besked', 'Besked');
        $this->form->addElement('submit', null, 'Videre >>');

        $this->form->applyFilter('__ALL__', 'trim');
        $this->form->applyFilter('__ALL__', 'strip_tags');

        $this->form->accept($renderer);

        return $this->form;
    }

    function getTilmelding()
    {
        return new VIH_Model_KortKursus_OnlineTilmelding($this->context->name);
    }

    function GET()
    {
        $tilmelding = $this->getTilmelding();

        if (!$tilmelding->get('id')) {
            throw new Exception('Du har ikke ret til at være her');
        }

        $extra_text = '';
        $tilmelding->kursus->getBegyndere();
        if ($tilmelding->kursus->get('pladser_begyndere_ledige') <= 0 AND $tilmelding->kursus->get('gruppe_id') == 1): // golf
        $extra_text = '<p class="alert"><strong>Der er ikke flere ledige begynderpladser på dette kursus.</strong></p>';
        endif;

        $this->document->title = 'Indtast oplysninger';

        $data = array('headline' => 'Indtast oplysninger',
                      'explanation' => $extra_text . '
            <p>Du er ved at reservere en plads på ' . $tilmelding->kursus->get('kursusnavn') . '.</p>
        ',
                      'content' =>
            '<p class="notice" style="clear: both;"><strong>Vigtigt:</strong> Kontaktpersonen modtager al post angående tilmeldingen, og det er også kun kontaktpersonen, der modtager programmet. Hvis I er flere, der ønsker at få post, beder vi jer lave flere tilmeldinger.</p>'
            . $this->getForm()->toHTML());

            return $this->render('VIH/View/KortKursus/Tilmelding/tilmelding-tpl.php', $data);
    }

    function POST()
    {
        $tilmelding = $this->getTilmelding();

        $deltagere = $tilmelding->getDeltagere();

        if ($this->getForm()->validate()) {

            if ($tilmelding->save($this->POST->getArrayCopy())) {
                $i = 0;
                $indkvartering = $this->POST['indkvartering_key'];
                $input = $this->POST->getArrayCopy();
                foreach ($deltagere AS $deltager) {
                    $var['id'] = $this->POST['id'][$i];
                    $var['navn'] = $this->POST['navn'][$i];
                    $var['cpr'] = $this->POST['cpr'][$i];

                    if (!empty($indkvartering[$i])) {
                        $var['indkvartering_key'] = $indkvartering[$i];
                        $var['sambo'] = $this->POST['sambo'][$i];
                    }
                    /*
                    switch ($tilmelding->kursus->get('indkvartering')) {
                        case 'kursucenteret':
                            $var['enevaerelse'] = $this->POST['enevaerelse'][$i];

                            break;
                        case 'hojskole og kursuscenter':
                            $var['vaerelse'] = $this->POST['vaerelse'][$i];
                            $var['sambo'] = $this->POST['sambo'][$i];
                            break;
                    }
                    */

                    switch ($tilmelding->kursus->get('gruppe_id')) {
                        case 1: // golf
                            $var['handicap'] = $this->POST['handicap'][$i];
                            $var['klub'] = $this->POST['klub'][$i];
                            $var['dgu'] = $this->POST['dgu'][$i];
                            break;
                        case 3: // bridge
                            $var['niveau'] = $this->POST['niveau'][$i];
                            break;
                        case 4: // golf og bridge
                            $var['handicap'] = $this->POST['handicap'][$i];
                            $var['klub'] = $this->POST['klub'][$i];
                            $var['dgu'] = $this->POST['dgu'][$i];
                            $var['niveau'] = $this->POST['niveau'][$i];
                            break;
                        case 5:
                            $var['speciale'] = $this->POST['speciale'][$i];
                        default:
                            break;
                    } // switch

                    $deltager_object = new VIH_Model_KortKursus_Tilmelding_Deltager($tilmelding, $this->POST['id'][$i]);

                    if (!$deltager_object->save($var)) {
                        throw new Exception('Oplysningerne om en af deltagerne kunne ikke gemmes');
                    }

                    $i++;
                } // foreach

                if (!$tilmelding->setCode()) {
                    throw new Exception('Tilmeldingen kunne ikke tilføjes en kode');
                }

                throw new k_http_Redirect($this->getRedirectUrl());

            } else {
                trigger_error('Tilmeldingen kunne ikke gemmes', E_USER_ERROR);
            }

        } else {
            return '<h1>Indtast oplysninger</h1><p class="notice" style="clear: both;"><strong>Vigtigt:</strong> Kontaktpersonen modtager al post angående tilmeldingen, og det er også kun kontaktpersonen, der modtager programmet. Hvis I er flere, der ønsker at få post, beder vi jer lave flere tilmeldinger.</p>' . $this->getForm()->toHTML();
        }

    }

    function getRedirectUrl()
    {
        return $this->context->url('confirm');
    }
}