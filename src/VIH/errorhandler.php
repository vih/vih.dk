<?php
/**
 * ErrorHandler
 *
 * Funktionen håndterer fejl. Kaldes med
 * set_error_handler("errorHandler"); Parameterne sættes
 * automatisk med den funktion, hvis siden render på fejl. Når
 * man har sat sin error handler rapporteres ingen fejl, så du bør
 * sikkert udvikle siden uden at have sat fejlhåndteringen til.
 *
 * @param $errno
 * @param $errmsg
 * @param $filename
 * @param $linenum
 * @param $vars
 *
 * @author Sune Jensen <sj@sunet.dk>
 * From: http://dk.php.net/manual/en/ref.errorfunc.php
 */
function vih_error_handler($errno, $errmsg, $filename, $linenum, $vars)
{
    // timestamp for the error entry
    $dt = date("Y-m-d H:i:s (T)");

    // define an assoc array of error string
    // in reality the only entries we should
    // consider are E_WARNING, E_NOTICE, E_USER_ERROR,
    // E_USER_WARNING and E_USER_NOTICE

    $errortype = array (
        E_ERROR          => "Error",
        E_WARNING        => "Warning",
        E_PARSE          => "Parsing Error",
        E_NOTICE          => "Notice",
        E_CORE_ERROR      => "Core Error",
        E_CORE_WARNING    => "Core Warning",
        E_COMPILE_ERROR  => "Compile Error",
        E_COMPILE_WARNING => "Compile Warning",
        E_USER_ERROR      => "User Error",
        E_USER_WARNING    => "User Warning",
        E_USER_NOTICE    => "User Notice",
        E_STRICT          => "Runtime Notice" // Denne virker vist kun i PHP 5.
        );


    // Hvilke fejl skal ikke logges og afbryde script
    $do_not_log = array(E_STRICT);
    $do_not_kill_script = array(E_USER_NOTICE, E_NOTICE, E_ALL, E_STRICT);

    if(!in_array($errno, $do_not_log)) {
        $err = "<errorentry>\n";
        $err .= "\t<datetime>" . $dt . "</datetime>\n";
        $err .= "\t<errornum>" . $errno . "</errornum>\n";
        $err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
        $err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
        $err .= "\t<scriptname>" . $filename . "</scriptname>\n";
        $err .= "\t<filename>" . $_SERVER['PHP_SELF'] . "</filename>\n";
        $err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";
        $err .= "</errorentry>\n\n";

        error_log($err, 3, dirname(__FILE__) . '/vih-hojskole-error.log');
    }

    if(!in_array($errno, $do_not_kill_script)) {
        if(defined('SHOW_DEBUG') AND SHOW_DEBUG) {
            die("<br /><p><strong>".$errortype[$errno].": </strong>".$errmsg." in <strong>".$filename."</strong> on line <strong>".$linenum."</strong><br />Genereret af ErrorHandler</p>");
        } else {
            // Bliver fejlen ikke logget, skal den udskrive på brugerens skærm.
            // Hvis der er en fatal fejl, skal den både logges og udskrives på brugerens skærm med en eller anden mulighed for at kontakte os eller indskrive en bug.
            if(in_array($errno, $do_not_log)) {
            	vih_print_error_msg($errmsg);
                exit;
            } else {
            	vih_print_error_msg($errmsg);
                exit;
            }
        }
    }
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