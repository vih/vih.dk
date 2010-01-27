<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Ansat_Kontakt extends k_Controller
{
    private $form;

    function getForm()
    {
        if ($this->form) {
            return $this->form;
        }

        $underviser = new VIH_Model_Ansat($this->name);

        $form = new HTML_QuickForm('underviser', 'POST', $this->url());
        $form->addElement('hidden', 'id', $underviser->get('id'));
        $form->addElement('text', 'navn', 'Navn');
        $form->addElement('text', 'email', 'E-mail');
        $form->addElement('textarea', 'besked', 'Besked', array('rows' => 12, 'cols' => 30));
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

    function GET()
    {
        $underviser = new VIH_Model_Ansat($this->context->name);

        if (!$underviser->get('id')) {
            throw new k_http_Response(404);
        }

        $msg = '';
        $extra_text = '';

        if (defined('EMAIL_STATUS') AND EMAIL_STATUS == 'online') {
            $extra_text = '<div id="form-underviser">' . $this->getForm()->toHTML() . '</div>';
        }

        $title = $underviser->get('navn');
        $meta['description'] = $underviser->get('description');
        $meta['keywords'] = '';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'sidepicture';
        $this->document->sidepicture = $this->context->getSidePicture($underviser->get('pic_id'));

        $data = array(
            'content' => '
            <div class="side-padding">
            <h1 class="fn">Send en besked til '.$underviser->get('navn').'</h1>'.$msg.'
            ' . $extra_text . '</div>
        ', 'content_sub' => $this->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function getSubContent()
    {
        $underviser = new VIH_Model_Ansat($this->context->name);

        $fag_html = '';

        if (count($underviser->getFag()) > 0) {
            $data = array('fag' => $underviser->getFag());
            $fag_html = '<h2>Underviser i</h2>'.$this->render('VIH/View/Fag/fag-tpl.php', $data);
        }
        return $fag_html;
    }

    function POST()
    {
        $underviser = new VIH_Model_Ansat($this->context->name);
        $this->document->title = $underviser->get('navn');

        if ($this->getForm()->validate()) {
            $mail = new VIH_Email;
            $mail->setSubject('Fra hjemmesiden');
            $mail->setFrom($this->POST['email'], $this->POST['navn']);
            $mail->setBody($this->POST['besked'] . "\n\nFra\n" . $this->POST['navn']);
            $mail->addAddress($underviser->get('email'), $underviser->get('navn'));
            if (!$mail->Send()) {
                $msg = '<p class="alert"><strong>Beskeden blev ikke sendt.</strong></p>';
            } else {
                $msg = '<p class="notice"><strong>Beskeden blev sendt - jeg svarer på den så snart jeg ser den.</strong></p>';
            }
            $data = array('content' => '
                <h1 class="fn">'.$underviser->get('navn').'</h1>' .
                $msg.'
            ', 'content_sub' => $this->getSubContent());

            return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);

        } else {
            $this->document->body_class = 'sidepicture';
            $this->document->sidepicture = $this->context->getSidePicture($underviser->get('pic_id'));

            $data = array('content' => '
                <h1 class="fn">'.$underviser->get('navn').'</h1><div id="form-underviser">' .
                $this->getForm()->toHTML().'</div>
            ', 'content_sub' => $this->getSubContent());

            return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
        }

    }
}