<?php
class VIH_Controller_PicasaWeb extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderHtml()
    {
        $this->document->setTitle('Fotoalbum');
        $this->document->addCrumb($this->name(), $this->url());
        $this->document->theme = 'photogallery';

        $this->document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js");
        $this->document->addScript($this->url('/jquery.pwi/js/jquery.slimbox2/jquery.slimbox2.js'));
        $this->document->addScript($this->url('/jquery.pwi/js/jquery.slimbox2/jquery.slimbox2.js'));
        $this->document->addScript($this->url('/jquery.pwi/js/jquery.blockUI.js'));
        $this->document->addScript($this->url('/jquery.pwi/js/jquery.pwi.js'));

        $this->document->addStyle($this->url('/jquery.pwi/js/jquery.slimbox2/jquery.slimbox2.css'));
        $this->document->addStyle($this->url('/jquery.pwi/css/pwi.css'));

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

        $tpl = $this->template->create('sidebar-wrapper');
        return $tpl->render($this, $data);
    }

    function getSubContent()
    {
        return '<h2>Årets højdepunkter</h2>' . $this->getNews();
    }

    function getNews()
    {
        $data = array('nyheder' => VIH_News::getList('', 3, 'Høj'));
        $tpl = $this->template->create('News/sidebar-featured');

        return $tpl->render($this, $data) . '<p><a href="'.$this->url('/nyheder').'">Flere nyheder</a></p>';
    }
}