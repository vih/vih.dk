<?php
/**
 * Sends emails
 *
 * @package VIH
 * @author  Lars Olesen <lars@legestue.net>
 */
require_once 'phpmailer/class.phpmailer.php';

class VIH_Email {

    private $mail;

    function __construct()
    {
        $this->mail = new Phpmailer;
        $this->mail->From = 'kontor@vih.dk';
        $this->mail->FromName = 'Vejle Idrætshøjskole';
        $this->mail->CharSet = 'UTF-8';
        //$this->mail->Host = 'mail.vih.dk';
    }

    function setSubject($string)
    {
        $this->mail->Subject = $string;
    }

    function addAddress($email, $name)
    {
        $this->mail->AddAddress($email, $name);
    }

    function setFrom($email, $name)
    {
        $this->mail->From = $email;
        $this->mail->FromName = $name;
    }

    function setBody($text)
    {
        $this->mail->Body = trim(strip_tags($text));
    }

    function send($type = 'instant')
    {
        switch ($type) {
            case 'instant':
                    return $this->mail->Send();
                break;
            case 'queue':
                    die('IKKE IMPLEMENTERET');
                break;
            default:
                    throw new Exception('Du skal vælge en måde at sende e-mails på');
                break;
        }
    }
}