<?php
/**
 * Controller for the intranet
 */
class VIH_Intranet_Controller_Index extends k_Controller
{
    function GET()
    {
        $hilsener = array(
            'Str�k armene op over hovedet og r�b jubii.',
            'K�r h�nden gennem h�ret og sig: Gud, hvor har jeg l�kkert h�r.',
            'Dupont er ikke ret stor, men han er stadig meget flink.',
            'Det var dog en us�dvanlig dejlig dag i dag.',
            'S�t dig da ned et minuts tid og nyd livet. Det er sk�nt.',
            'N�r du kan h�re fuglene fl�jte, m� det v�re en vidunderlig dag.',
            'Str�k den ene arm over p� ryggen og klap dig selv p� skulderen.',
            'Skynd dig over p� kontoret - de har slik og gaver til dig i dag.',
            'Faktisk er vi nok alt for seje.',
            'Det g�r den rigtige vej.',
            'Det er ikke s� ringe endda.',
            'Mon k�kkenet serverer hindb�rsnitter i dag?',
            'Har du rost en anden i dag',
            'VIH er landets bedste idr�tsh�jskole',
            'Der er ingen gr�nser for, hvad vi kan opn�.'
        );

        $special_data = array('special_days' => VIH_Model_Ansat::getBirthdays());

        $this->document->title = 'Forside: Velkommen';
        $this->document->help = $hilsener[array_rand($hilsener)];

        return $this->render('vih/intranet/view/special_day-tpl.php', $special_data). '
            <ul class="navigation-frontpage">
                <li><a href="'.$this->url('/protokol').'">Protokol</a></li>
                <li><a href="https://mail.vih.dk/exchange/">Tjek din e-mail</a></li>
                <li><a href="http://www.google.com/calendar/embed?src=scv5aba9r3r5qcs1m6uddskjic%40group.calendar.google.com">H�jskolens kalender</a></li>
            </ul>
            ';
    }
}