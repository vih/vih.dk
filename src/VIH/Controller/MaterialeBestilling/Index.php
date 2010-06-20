<?php
class VIH_Controller_MaterialeBestilling_Index extends k_Controller
{
    private $form;
    private $renderer;

    function getForm()
    {
        if ($this->form) {
            return $this->form;
        }

        $this->form = new HTML_QuickForm('bestilmateriale', 'post', $this->url('./'));
        $this->form->addElement('header', null, 'Hvilket materiale er du interesseret i?');
        $this->form->addElement('checkbox', 'langekurser', null, 'Lange kurser', array('id' => 'materiale_langekurser'));
        $this->form->addElement('checkbox', 'kortekurser', null, 'Korte kurser', 'id="materiale_kortekurser"');
        //$this->form->addElement('checkbox', 'efterskole', null, 'Efterskole', 'id="materiale_efterskole"');
        //$this->form->addElement('checkbox', 'kursuscenter', null, 'Kursuscenter', 'id="materiale_kursuscenter"');
        $this->form->addElement('header', null, 'Hvor skal materialet sendes hen?');
        $this->form->addElement('text', 'navn', 'Navn');
        $this->form->addElement('text', 'adresse', 'Adresse');
        $this->form->addElement('text', 'postnr', 'Postnummer');
        $this->form->addElement('text', 'postby', 'Postby');
        $this->form->addElement('text', 'email', 'E-mail');
        $this->form->addElement('text', 'telefon', 'Telefon');
        $this->form->addElement('header', null, '�vrige oplysninger');
        $this->form->addElement('textarea', 'besked', 'Besked', array('rows' => 5, 'cols' => 20));
        $this->form->addElement('submit', 'submit', 'Send mig ovenst�ende brochurer');
        $this->form->addRule('navn','Du skal skrive et navn', 'required');
        $this->form->addRule('adresse','Du skal skrive en adresse', 'required');
        $this->form->addRule('postnr','Du skal skrive et postnummer', 'required');
        $this->form->addRule('postby','Du skal skrive en postby', 'required');
        $this->form->addRule('telefon','Du skal skrive et telefonnummer', 'required');
        $this->form->addRule('email','Du skal skrive en e-mail', 'required');
        $this->form->addRule('email','E-mailen er ikke korrekt', 'email');

        $this->form->removeAttribute('name');

        $this->form->accept($this->getRenderer());

        return $this->form;
    }

    function getRenderer()
    {
        if (!empty($this->renderer)) {
        	return $this->renderer;
        }
    	return ($this->renderer = new HTML_QuickForm_Renderer_Tableless());
    }

    function GET()
    {
        $title = 'Materialebestilling';
        $meta['description'] = 'Bestil materiale til korte og lange kurser fra Vejle Idr�tsh�jskole.';
        $meta['keywords'] = 'materiale, bestil, bestilling, brochure, oplysninger, oplysning';

        $this->document->title = $title;
        $this->document->meta  = $meta;
        $this->document->theme  = 'bestilling';

        $form = $this->getForm();

        $data = array('text' => 'Du kan bestille vores magasin og dvd om de lange kurser eller vores brochure om de korte kurser.',
                      'form' => $this->getRenderer()->toHtml());

        $data = array('content' => $this->render('VIH/View/Materialebestilling/index.tpl.php', $data),
                      'content_sub' => $this->getSubContent());
        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function POST()
    {
        if ($this->getForm()->validate()) {

            $bestilling = new VIH_Model_MaterialeBestilling;
            if (!$bestilling->save($this->POST->getArrayCopy())) {
                throw new Exception('Det gik ikke ret godt. Vores webmaster skammer sig sikkert.');
            }
            if(defined('EMAIL_STATUS') && EMAIL_STATUS == 'online') {
                if (Validate::email($this->POST['email']) AND trim($this->POST['email']) != '') {
                    $error = '';
                    if(!defined('VIH_KONTAKTANSVARLIG_EMAIL') || VIH_KONTAKTANSVARLIG_EMAIL == '') {
                        throw new Exception('Konstanten VIH_KONTAKTANSVARLIG_EMAIL er ikke sat eller udfyldt');
                    } elseif(trim($this->POST['besked']) != '') {
                        $body = "Besked sendt i forbindelse med bestilling af materiale:\n\n".$this->POST['besked']."\n\n Sendt af ".$this->POST['navn']."\n\nSend gerne videre til fagansvarlig l�rer.";
                        $mailer = new VIH_Email;
                        $mailer->setSubject('Fra hjemmesiden');
                        $mailer->setFrom($this->POST['email'], $this->POST['navn']);
                        $mailer->setBody($body);

                        // i sommerperiden sendes e-mailen andetsteds hen.
                        if ((int)$this->POST['langekurser'] == 1 AND (date('Y-m-d') < date('y').'-06-25' OR date('Y-m-d') > date('y').'-08-01')) {
                            $mailer->addAddress(VIH_KONTAKTANSVARLIG_EMAIL, VIH_KONTAKTANSVARLIG);
                        } elseif ((int)$this->POST['kursuscenter'] == 1) {
                            $mailer->addAddress('kursuscenter@vih.dk', 'Kursuscenteret');
                        } else {
                            $mailer->addAddress('kontor@vih.dk', 'Vejle Idr�tsh�jskole');
                        }
                        if(!$mailer->send()) {
                            throw new Exception("Der er opst�et en fejl i email-senderen i forbindelse bestilling af materiale. E-mail til VIH_KONTAKTANSVARLIG er ikke sendt. Det drejer sig om en foresp�rgsel fra ".$this->POST['navn']);
                        }
                    }
                    if (trim($this->POST['email']) != '') {
                        $body = "K�re ".$this->POST['navn']."\n\nVi har modtaget din bestilling af materiale, og vi sender det s� hurtigt som muligt.\n\nHvis du har nogen sp�rgsm�l, er du meget velkommen til at ringe til os p� 7582 0811.\n\nMed venlig hilsen\nVejle Idr�tsh�jskole";

                        $mailer = new VIH_Email;
                        $mailer->setSubject("Bestilling af materiale fra VIH");
                        $mailer->addAddress($this->POST['email'], $this->POST['navn']);
                        $mailer->setBody($body);

                        if(!$mailer->send()) {
                            throw new Exception("Der er opst�et en fejl i email-senderen i forbindelse bestilling af materiale. Der er ikke sendt en bekr�ftelse til ".$this->POST['navn']);
                            $error = "<p>Det var ikke muligt at sende dig en bekr�ftelse p� din bestilling, men bare rolig vi har modtaget den, og sender hurtigst muligt materialet. Imens h�nger vi webmasteren op i flagstangen, indtil han siger undskyld.";
                        }
                    }
                }
            }
            $data = array('content' => '<h1>Tak for din bestilling</h1>
                    <p>Vi vil skynde os at pakke noget materiale til dig, og vi sender det s� hurtigt som muligt. Du skulle gerne have det i l�bet af 2-3 arbejdsdage alt efter hvor hurtigt postv�senet arbejder.</p>
                    <h2>Nyhedsbrev</h2>
                    <p>Hvis det har nogen interesse, kan du <a href="'.$this->url('/nyhedsbrev/').'">tilmelde dig vores nyhedsbrev</a>.</p>
                    '.$error);
            return $this->render('VIH/View/wrapper-tpl.php', $data);
        } else {

            $form = $this->getForm();
            $content = $this->render('VIH/View/Materialebestilling/index.tpl.php', array('text' => 'Der var fejl i formularen.', 'form' => $this->getRenderer()->toHtml()));

            $data = array('content' => $content, 'content_sub' => $this->getSubContent());
            return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
        }
    }

    function getSubContent()
    {
        return '
                <h2>Download</h2>
                <p><a href="'.$this->url('/gfx/folder/timeout2009.pdf').'"><img src="'.$this->url('/gfx/images/timeout-2008.jpg').'" /></a></p>
        ';
    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        return parent::handleRequest();
    }

}
