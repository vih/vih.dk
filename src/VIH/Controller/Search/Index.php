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

        $main->set('title', 'S�gning');
        $main->set('body_class', 'sidebar');

        $search_tpl = new VIH_Frontend();
        $search_tpl->set('headline', 'S�g');
        $search_tpl->set('form', $form->toHTML());

        if ($form->validate()) {

            $google = new Services_Google(SEARCH_GOOGLE_API_KEY);

            // Setup query options, in this case limit to 100 results total.
            $google->queryOptions['limit'] = 10;

            // Run the search
            $google->search(utf8_encode('site:' . SEARCH_GOOGLE_SITE . ' ' . utf8_encode($_GET['q'])));

            $form->setDefaults(array('q' => $_GET['q']));


            $search_tpl->set('results_headline', 'S�geresultat');
            $search_tpl->set('results', $google);
            // $search_tpl->set('results_count', 'I alt fandt Google ' . $data['estimatedTotalResultsCount'] . ' sider');
            if ($google->numResults() > 10) {
                $search_tpl->set('page_nav', 'Google fandt flere end 10 resultater. Hvis du ikke fandt det, du s�gte efter, kan du specificere din s�gning yderligere.');
            }
        }

        $main->set('content_main', $search_tpl->fetch('searchresults-tpl.php'));

        $main->set('content_sub', '
            <h2 id="help">S�gevejledning</h3>
            <p>Her kan du s�ge p� Vejle Idr�tsh�jskoles sider. Du skriver bare dit s�geord i s�geboksen ovenover og klikker p� <em>S�g</em>. Hvis du ikke finder siden ved at s�ge, kan du kigge i vores <a href="'.url('/om/sitemap.php').'">sitemap</a> eller du kan <a href="'.url('/kontakt/').'">kontakte os</a>.</p>
            <p><strong>Hvordan s�ger man?</strong> Du skal f�rst g�re dig klart, hvad du gerne vil have svar p�. Afg�r hvad der er dine n�gleord og skriv evt. synonymer ned. Desto mere bevidst du s�ger, desto st�rre er chancen for, at du finder netop det, du leder efter.</p>
            <p><strong>S�gningen</strong>. Vores s�gemaskine s�ger p� alle de ord, du skriver i s�geboksen, og den sorterer resultaterne efter relevans, s� de mest relevante resultater for din s�gning st�r �verst. V�r opm�rksom p�, at s�gningen kun s�ger p� netop det, du skriver ind i s�geboksen. Hvis du s�ger efter fx vores priser, kan det alts� v�re en god ide b�de at skrive <samp>pris</samp> og <samp>priser</samp> ind i s�geboksen.</p>
            <p><strong>Stopord</strong>. S�gefunktionen s�ger ikke p� sm� ord, som fx &quot;og&quot;. S�gefunktionen kan heller ikke s�ge p� ord, som fremg�r p� de fleste sider, som fx &quot;vejle&quot; og &quot;idr�tsh�jskole&quot;. G�r derfor din s�gning mere specifik.</p>'
        );

        
    }
}
*/
?>