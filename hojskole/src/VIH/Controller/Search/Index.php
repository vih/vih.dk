<?php
/*
require_once 'Services/Google.php';
require_once 'vih/frontend/forms/search.php';

class VIH_Search_Controller_Index extends k_Controller
{
    function GET()
    {
        $form = new VIH_Frontend_Form_Search;

        $main = new VIH_Frontend_Hojskole();

        $main->set('title', 'Søgning');
        $main->set('body_class', 'sidebar');

        $search_tpl = new VIH_Frontend();
        $search_tpl->set('headline', 'Søg');
        $search_tpl->set('form', $form->toHTML());

        if ($form->validate()) {

            $google = new Services_Google(SEARCH_GOOGLE_API_KEY);

            // Setup query options, in this case limit to 100 results total.
            $google->queryOptions['limit'] = 10;

            // Run the search
            $google->search(utf8_encode('site:' . SEARCH_GOOGLE_SITE . ' ' . utf8_encode($_GET['q'])));

            $form->setDefaults(array('q' => $_GET['q']));


            $search_tpl->set('results_headline', 'Søgeresultat');
            $search_tpl->set('results', $google);
            // $search_tpl->set('results_count', 'I alt fandt Google ' . $data['estimatedTotalResultsCount'] . ' sider');
            if ($google->numResults() > 10) {
                $search_tpl->set('page_nav', 'Google fandt flere end 10 resultater. Hvis du ikke fandt det, du søgte efter, kan du specificere din søgning yderligere.');
            }
        }

        $main->set('content_main', $search_tpl->fetch('searchresults-tpl.php'));

        $main->set('content_sub', '
            <h2 id="help">Søgevejledning</h3>
            <p>Her kan du søge på Vejle Idrætshøjskoles sider. Du skriver bare dit søgeord i søgeboksen ovenover og klikker på <em>Søg</em>. Hvis du ikke finder siden ved at søge, kan du kigge i vores <a href="'.url('/om/sitemap.php').'">sitemap</a> eller du kan <a href="'.url('/kontakt/').'">kontakte os</a>.</p>
            <p><strong>Hvordan søger man?</strong> Du skal først gøre dig klart, hvad du gerne vil have svar på. Afgør hvad der er dine nøgleord og skriv evt. synonymer ned. Desto mere bevidst du søger, desto større er chancen for, at du finder netop det, du leder efter.</p>
            <p><strong>Søgningen</strong>. Vores søgemaskine søger på alle de ord, du skriver i søgeboksen, og den sorterer resultaterne efter relevans, så de mest relevante resultater for din søgning står øverst. Vær opmærksom på, at søgningen kun søger på netop det, du skriver ind i søgeboksen. Hvis du søger efter fx vores priser, kan det altså være en god ide både at skrive <samp>pris</samp> og <samp>priser</samp> ind i søgeboksen.</p>
            <p><strong>Stopord</strong>. Søgefunktionen søger ikke på små ord, som fx &quot;og&quot;. Søgefunktionen kan heller ikke søge på ord, som fremgår på de fleste sider, som fx &quot;vejle&quot; og &quot;idrætshøjskole&quot;. Gør derfor din søgning mere specifik.</p>'
        );

        
    }
}
*/
?>