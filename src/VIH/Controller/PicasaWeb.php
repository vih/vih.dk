<?php
class VIH_Controller_PicasaWeb extends k_Controller
{
    function GET()
    {
        $this->document->title = 'Fotoalbum';
        $this->document->theme = 'photogallery';

        $this->document->scripts[] = "http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js";
        $this->document->scripts[] = $this->url('/jquery.pwi/js/jquery.slimbox2/jquery.slimbox2.js');
        $this->document->scripts[] = $this->url('/jquery.pwi/js/jquery.slimbox2/jquery.slimbox2.js');
        $this->document->scripts[] = $this->url('/jquery.pwi/js/jquery.blockUI.js');
        $this->document->scripts[] = $this->url('/jquery.pwi/js/jquery.pwi.js');

        $this->document->styles[] = $this->url('/jquery.pwi/js/jquery.slimbox2/jquery.slimbox2.css');
        $this->document->styles[] = $this->url('/jquery.pwi/css/pwi.css');

        $content = '
        <script type="text/javascript">
		    $(document).ready(function() {

		        $("#picasaweb").pwi({
		            username: \'vejleih\',
					 maxResults: 5,
					 showAlbumDescription: false,
					 showPhotoCaption: true,
					 photoCaptionLength: 5,
					 showPhotoCaptionDate: true,
					 thumbSize: 160,
				     labels: {photo:"billede",	//-- override labels, to translate into your required language
					          photos: "billeder",
							  albums: "Tilbage til albums",
							  slideshow: "Vis slideshow",
							  loading: "Henter billeder...",
							  page: "Side",
						      prev: "Forrige",
							  next: "Næste",
							  devider: "|"
					},
					months: ["Januar","Februar","Marts","April","Maj","Juni","Juli","August","September","Oktober","November","December"]
		        });
		    });
		</script><h1>Billedgalleri</h1><div id="picasaweb"></div>';

        $data = array('content' => $content, 'content_sub' => $this->getSubContent());

        return $this->render('VIH/View/sidebar-wrapper.tpl.php', $data);
    }

    function getSubContent()
    {
        return '<h2>Årets højdepunkter</h2>' . $this->getNews();
    }

    function getNews()
    {
        $data = array('nyheder' => VIH_News::getList('', 3, 'Høj'));
        return $this->render('VIH/View/News/sidebar-featured.tpl.php', $data) . '<p><a href="'.$this->url('/nyheder').'">Flere nyheder</a></p>';
    }

    function forward($name)
    {
        $next = new VIH_Controller_Fotogalleri_Show($this, $name);
        return $next->handleRequest();
    }

    function handleRequest()
    {
        $this->document->trail[$this->name] = $this->url();
        return parent::handleRequest();
    }
}