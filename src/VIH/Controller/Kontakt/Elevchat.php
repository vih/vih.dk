<?php
class VIH_Controller_Kontakt_Elevchat extends k_Component
{
    protected $form;
    protected $elevchatter;

    function renderHtml()
    {
        $title = 'Elevchat';
        $meta['description'] = 'Her kan du stille sp�rgsm�l til elever.';
        $meta['keywords'] = 'elevchat, feedback, debat, dialog';

        $elevchattere = VIH_Model_Ansat::getList('elevchatter');

        if (count($elevchattere) == 0) {
            return '<h1>Elevchat</h1><p>Vi har i �jeblikket ikke nogen elevchattere. Du kan skrive til en af <a href="'.$this->url('/underviser').'">l�rerne</a> eller til <a href="'.$this->url('/kontakt').'">kontoret</a>.</p>';
        }

        $file = new VIH_FileHandler($elevchattere[0]->get('pic_id'));
        $file->loadInstance('small');
        $pic_uri = $file->getImageHtml();
        $file->loadInstance(IMAGE_POPUP_SIZE);

        // Oplysninger om Elevchatter
        $this->elevchatter['navn'] = $elevchattere[0]->get('navn');
        $this->elevchatter['email'] = $elevchattere[0]->get('email');
        $this->elevchatter['billede'] = $pic_uri;
        $this->elevchatter['text'] = $elevchattere[0]->get('beskrivelse');

        $msg = '';
        $extra_text = '';

        $this->document->setTitle($title);
        $this->document->headline = $title;

        $this->document->meta = $meta;
        return '<h1>Elevchat</h1>' . $msg . vih_autoop($this->elevchatter['text']) . $extra_text = '<h2>Send en besked</h2>' . $this->getForm()->toHTML();
        //$main->set('content_sub', '<a rel="lightbox" title="'.$elevchatter['navn'].'" href="'.$file->get('file_uri').'">' . $elevchatter['billede'] . '</a>');
    }

    function postForm()
    {
        if ($this->getForm()->validate()) {
            $mail = new VIH_Email;
            $mail->setSubject('Fra hjemmesiden');
            $mail->setFrom($this->POST['email'], $this->POST['navn']);
            $mail->setBody($this->POST['besked'] . "\n\nFra\n" . $this->POST['navn'] . ' ('. $this->POST['email'].')');
            $mail->addAddress($this->elevchatter['email'], $this->elevchatter['navn']);
            $mail->addAddress('lars@vih.dk', 'Lars Olesen');
            if (!$mail->Send()) {
                $msg = '<h1>Elevchat</h1><p class="alert">E-mailen blev ikke sendt. Det plejer ikke at ske, pr�v igen eller ring evt. til os p� 75820811. I mellemtiden kan du fx lede efter svaret under <a href="'.url('/langekurser/faq').'">ofte stillede sp�rgsm�l</a>.</p>';
            } else {
                $msg = '<h1>Elevchat</h1><p class="notice"><strong>Tak for din e-mail. Jeg svarer p� den lige s� snart, jeg ser den.</strong></p>';
            }
            return $msg;
        }

        return $this->render();
    }

    function getForm()
    {
        if ($this->form) {
            return $this->form;
        }

        $form = new HTML_QuickForm('elevchat', 'POST', $this->url());
        $form->addElement('text', 'navn', 'Navn');
        $form->addElement('text', 'email', 'E-mail');
        $form->addElement('textarea', 'besked', 'Besked', array('cols' => 50, 'rows' => 10));
        $form->addElement('submit', null, 'Send');
        $form->addRule('navn', 'Du skal indtaste et navn', 'required');
        $form->addRule('email', 'Du skal indtaste en email', 'required');
        $form->addRule('email', 'Du skal indtaste en gyldig email', 'email');
        $form->addRule('besked', 'Du skal indtaste en gyldig besked', 'required');

        $form->applyFilter('__ALL__', 'trim');
        $form->applyFilter('__ALL__', 'strip_tags');
        $form->applyFilter('__ALL__', 'addslashes');

        return ($this->form = $form);
    }
}