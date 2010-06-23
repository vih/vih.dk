<?php
function vih_get_ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_expl = explode('.', $_SERVER['HTTP_IP_CLIENT']);
        $referer = explode('.', $_SERVER['REMOTE_ADDR']);
        if ($referer[0] != $ip_expl[0]) {
            $ip = array_reverse($ip_expl);
            $return = implode('.', $ip);
        } else {
            // @todo an error here
            //$return = $client_ip;
            $return = '';
        }
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (strstr($_SERVER['HTTP_X_FORWARDED_FOR'], '.')) {
            $ip_expl = explode('.', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $return = end($ip_expl);
        } else {
            $return = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $return = $_SERVER['REMOTE_ADDR'];
    } else {
        $return = '';
    }
    return $return;
}

function vih_get_secure_server()
{
    if (defined('SECURE_SERVER_STATUS') AND SECURE_SERVER_STATUS != 'online') {
        return;
    }
    if (!isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != 'on' ) {
        header('Location: '.SECURE_HOST .$_SERVER['REQUEST_URI']);
        exit;
    }
}

function vih_split_name($name)
{
    $count = strrpos($name, ' ');
    $fornavn 	= trim(substr($name, 0, $count));
    $efternavn 	= trim(substr($name, $count));
    return array('fornavn' => $fornavn,
                 'efternavn' => $efternavn);
}

/**
 * Udregner deltagerens alder. Alderens skal udregnes på kursusstartdatoen.
 *
 * @param date $birthday ISO-format
 * @param date $date ISO-format
 *
 * @return integer
 */
function vih_calculate_age($birthday, $date)
{
    $tmp = explode('-',$birthday);
    if (empty($tmp[0]) OR empty($tmp[1]) OR empty($tmp[2]) or !is_numeric($tmp[1])) {
        return;
    }

    $birthday = mktime(0, 0, 0, $tmp[0], $tmp[1], $tmp[2]);

    $dato = $tmp[2];
    $maaned = $tmp[1];
    $aar = $tmp[0];

    if (!empty($date)) {
        $tmp = explode('-',$date);
        $date = mktime(0,0,0,$tmp[0],$tmp[1],$tmp[2]);

        $days = $tmp[2] - $dato ;
        $months = ( $tmp[1] - $maaned ) * 30 ;
        $years = ( $tmp[0] - $aar ) * 365 ;
    } else {
        $days = date('d') - $dato ;
        $months = (date('m') - $maaned) * 30 ;
        $years = (date('Y') - $aar) * 365 ;
    }

    $total = ($days + $months + $years) / 365 ;

    return $total;
}

function vih_random_code($length)
{
    $template = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $length =  (int)$length;

    $rndstring = '';
    for ($a = 0; $a <= $length; $a++) {
        $b = rand(0, strlen($template) - 1);
        $rndstring .= $template[$b];
    }
    return $rndstring;
}

function getBirthday($cpr)
{
    $month = substr($cpr,2,2);
    $day = substr($cpr,0,2);
    $year_last_two_digits = substr($cpr,4,2); // to sidste i årstallet taget fra cprnummeret
    $testyear = (substr(date('Y'), 0,2) - 1) . $year_last_two_digits; // trækker en fra aktuelle år
    if ($testyear < date('Y') AND (date('Y') - $testyear) < 100) {
        $year = (substr(date('Y'), 0,2) - 1) . $year_last_two_digits;
    } else {
        $year = substr(date('Y'), 0 , 2) . $year_last_two_digits;
    }
    return $year . '-' . $month . '-' . $day;
}

function vih_validate_cpr($cpr)
{
    if (substr($cpr, -4) == '9999') return true;
    return Validate_DK::ssn($cpr);
}

function vih_autoop($text)
{
    require_once 'markdown.php';
    require_once 'smartypants.php';
    $text = MarkDown($text);
    $text = SmartyPants($text);
    return $text;
}

function vih_url($href = '')
{
    $urlbuilder = new k_urlbuilder(PATH_WWW);
    return $urlbuilder->url($href);
}

function vih_e($string)
{
    return htmlentities($string);
}

function vih_email($email)
{
    return $email;
}

function vih_autoclicable($string)
{
    return make_clicable($string);
}

function vih_scramble_cpr($cpr)
{
    return substr($cpr,0,-4) . '-xxxx';
}

function vih_handle_microsoft($text)
{
    $text = str_replace(chr(145), "'", $text);
    $text = str_replace(chr(146), "'", $text);
    $text = str_replace(chr(147), '"', $text);
    $text = str_replace(chr(148), '"', $text);
    $text = str_replace(chr(148), '"', $text);
    $text = str_replace(chr(150), '-', $text);
    $text = str_replace(chr(151), '--', $text);
    $text = str_replace(chr(133), '...', $text);
    return $text;
}

function vih_print_error_msg($msg = '')
{
print '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Der er opstået en  fejl</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

        <style type="text/css">
            body {
                text-align: center;
                font-family: "trebuchet ms", arial, sans-serif;
            }
            #container {
                text-align: left;
                width: 60%;
                margin: auto;
                border: 8px solid #d1aad1;
                padding: 2em;
            }

            p strong {
                background: #eeccee;
                padding: 0.5em;
                width: 100%;
                line-height: 2em;
            }
        </style>

    </head>

    <body>

        <div id="container">
            <h1>Hm, noget gik galt</h1>
            <p><strong>' . $msg . '</strong></p>
            <p>Det burde ikke kunne ske. Hov, nu er vores webmaster ved at stikke af. Det kan vi godt forstå, for han har lovet, at du aldrig ville se denne side.</p>
            <p>Vores webmaster råber, at du måske kan prøve at gå tilbage på den foregående side og tjekke om alt er rigtig udfyldt.</p>
            <p>Hvis du har nogen spørgsmål, er du velkommen til at kontakte Vejle Idrætshøjskole på 75820811. Så skal vi nok pine webmasteren lidt.</p>
            <p>Vi beklager ulejligheden &mdash; og håber at du har en god dag alligevel.</p>
            <p>Med venlig hilsen<br>Vejle Idrætshøjskole</p>
        </div>
    </body>
</html>';
}