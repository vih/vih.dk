<?php
require_once 'config.local.php';
require_once 'konstrukt/konstrukt.inc.php';
require_once 'bucket.inc.php';
require_once 'Ilib/ClassLoader.php';

class VIH_Language_Root extends k_Component
{
    protected $templates;
    protected $cms;

    function __construct(k_TemplateFactory $templates, IntrafacePublic_CMS $cms)
    {
        $this->templates = $templates;
        $this->cms = $cms;
    }

    function renderHtml()
    {
        $page = $this->cms->getPage('frontpage');
        $parser = new IntrafacePublic_CMS_HTML_Parser($page);
        $content = $parser->getSection('content');
        $data = array('content' => $content['elements'][0]['html']);
        $tpl = $this->templates->create('main');
        return $tpl->render($this, $data);
    }
}

class ApplicationFactory {
  public $template_dir;
  function new_k_TemplateFactory($c) {
    return new k_DefaultTemplateFactory($this->template_dir);
  }

  function new_IntrafacePublic_CMS()
  {
        $credentials["private_key"] = $GLOBALS["private_key"];
        $credentials["session_id"] = md5(uniqid());
        $cms_id = 45;

        $debug = false;
        $client = new IntrafacePublic_CMS_Client_XMLRPC($credentials, $cms_id, $debug, '', 'utf-8');

        $options = array(
            "cacheDir" => $GLOBALS["cache_dir"],
            "lifeTime" => 1
        );

        return new IntrafacePublic_CMS($client, new Cache_Lite($options));
  }

}

function create_container() {
  $factory = new ApplicationFactory();
  $container = new bucket_Container($factory);
  $factory->template_dir = $GLOBALS['template_path'];
  return $container;
}

k()
  // Use container for wiring of components
  ->setComponentCreator(new k_InjectorAdapter(create_container()))
  // Location of debug logging
  ->setLog($debug_log_path)
  // Enable/disable in-browser debugging
  ->setDebug($debug_enabled)
  // Dispatch request
  ->run('VIH_Language_Root')
  ->out();



/*
<?php
$page_title = 'English: Vejle College of Sports - a Danish Folk Highschool';
$description = 'Vejle College of Sports - a Danish Folk Highschool.';
$keywords = 'college sports, denmark, folk high school, highschool';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="uk">
<head>

<!-- Almindelig metadata -->
<title><?php echo $page_title; ?></title>

<!-- Max 500 bogstaver-->
<meta name="Description" content="<?php echo $description; ?>" />
<meta name="Keywords" content="<?php echo $keywords; ?>" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Language" content="us-en" />

<meta name="copyright" content="Vejle Idrætshøjskole" />
<meta name="Author" content="Lars Olesen" />

<!-- Stylesheets -->
<link rel="stylesheet" href="/css/layout.css" type="text/css" title="Standard" media="screen" />
<link rel="stylesheet" href="/css/print.css" type="text/css" media="print, aural, braille" />

<link rel="SHORTCUT ICON" href="http://www.vih.dk/favicon.ico" />

</head>

<body>
<div id="container">
  <h1>Vejle Idrætshøjskole - Vejle College of Sports</h1>
  <?php
	?>

  <p><strong>A Break before The rest of Your Life?<br />
    - Vejle College of Sports challenges you!</strong></p>
  <p>Are you in need of a break before the rest of your life begins? In Vejle
    College of Sports you will experience many things and develop as a human being
    when you have to interact with your new friends.<br />
    You will eat, stay and sleep at the school either in the spring, in the fall
    or even for a whole year.</p>
  <p> A stay at a college of sports can be a breathing-space. At the same time
    it contributes to qualifying you for many kinds of education. You will experience
    an active everyday life, where both body and mind will be exercised. This
    combination will help you understand life better. The close fellowship with
    others will give you invaluable social skills.</p>
  <p>This fellowship takes its starting point in athletics. You will become good
    at your chosen sport and you can obtain an education as a coach. Or maybe
    you just want to improve your form, find your new type of sport, or face new
    creative challenges.</p>
  <p>It is easy to get to Vejle College of Sports, and we are lucky enough to
    be situated in the middle of the woods, close to the bay and the centre of
    Vejle.</p>
  <p>We look forward to seeing you in Vejle.</p>
  <h2> What Are Your Choices?</h2>
  <h3> Autumn with Comprehensiveness</h3>
  <p> Autumn is a mixture of concentration and comprehensiveness. You choose one
    main subject and pit yourself against many other types of sport &#8211; new
    and well known. This comprehensive autumn is a good basis for e.g. a study
    of physical education or an education as a qualified teacher.</p>
  <h3>Winter Course with Plurality</h3>
  <p> From October until Christmas we concentrate on a main subject and try many
    different types of sport. From January we specialize in one sport - and two
    others according to your own choice.</p>


<div>
  <h3>Spring with Immersion</h3>
  <p>Spring we call the speciality period. You concentrate on one type of sport,
    your main subject. Besides that you choose two minor subjects. The focus will
    be on concentrating on one sport. You will get a deeper understanding of your
    chosen sport against e.g. getting an occupation as a coach, or reaching your
    personal goals.</p>
</div>
<div>
  <h3>One Whole Year with Everything</h3>
  <p>If you choose one whole year you get both the comprehensiveness of the autumn
    term and the specialization of the spring term. After Christmas you can choose
    a new main subject.</p>
</div>

<div>
<?php
?>
  <h2>Main Subjects</h2>
  <p> You choose one main subject on which you concentrate. In the main subject
    you can get your education as a coach, which you can use later in clubs.<br />
    In an exciting, amusing, and inspiring way you will improve, not only as a
    performer but also as a coach. If you choose being a student all year you
    may choose a new main subject after Christmas.<br />
    If you want to know more about what happens in the main subjects you may acquire
    our folder by phoning the office, or you may check www.vih.dk.</p>
  <h3>Aerobics</h3>
  <p> You will improve your agility and your teaching e.g. concerning your knowledge
    of the theory of music and the development of choreography. We primarily focus
    on high/low body toning and step, but also train many other forms of aerobics
    like funk and body combat or other trends.<br />
    The education as a coach you may later use in clubs and fitness centres. We
    combine high intensity and challenging choreography with the rhythmic movements
    of the age, and you develop your creativity and improve your joy of physical
    activity.</p>
  <h3>Badminton</h3>
  <p> We work on technical, tactical, and physical elements in the game: many
    different strokes and special strokes, various forms of footwork with leaps
    and jumps, training of speed and strokes, match training, offensive and defensive
    single, double and mix, that is: a multitude of exercises with various combinations.
    You experience the newest forms of training, learn about coaching, competitive
    training, and how to plan training, and you learn to use mental training in
    praxis. </p>
  <h3>Handball</h3>
	<p>Description will come...</p>
	  <h3>Soccer</h3>
			<p>Description will come...</p>
		  <h3>Volleyball</h3>
				<p>Description will come...</p>
  <h2>Minor Subjects</h2>
</div>
<ul>
  <li>
    <div> Outdoor Life (Spring And Autumn)</div>
  </li>
  <li>
    <div> Fitness (Autumn And Spring)</div>
  </li>
  <li>
    <div> Triathlon And Adventure Race (Spring)</div>
  </li>
  <li>
    <div> Project Designer (Spring)</div>
  </li>
  <li>
    <div> Children And Sports (Spring)</div>
  </li>
  <li>
    <div> Jumping (Spring)</div>
  </li>
  <li>
    <div> Athletics (Spring)</div>
  </li>
  <li>
    <div> Basketball (Spring)</div>
  </li>
</ul>
<h2>Practical Information</h2>

  <h4>Entry</h4>
  <p> You have entered when you have sent the entry form and the entry fee to
    us. When you are enrolled you shall have a written reply.</p>
  <h4>Lodging</h4>
  <p> You shall stay in a double room. When distributing the rooms we take into
    consideration whether you are a smoker or a non-smoker.</p>
  <h4>Fees and Financial Support</h4>
  <p> Your pay for the stay includes board, lodging and lessons. For travels abroad
    and materials (please see the enclosed list) we collect an additional amount.
    You may apply for financial support from your local authorities. You can get
    the application form from us. For further information on financial support
    please see the enclosure or www.ffd.dk.</p>
  <h4>Grants for Individual Students</h4>
  <p> The school has at its disposal a small amount, which can be applied for.
    The aim of the pool is to try to help so that financial problems do not prevent
    anyone from going through with a stay at a high school and ensuring that the
    students come from different social backgrounds. Individual financial support
    is 400 Danish kroner maximum per week. Please phone the school to clear up
    any questions or for getting an application form.<br />
    You may read about the precise criteria at www.vih.dk or ask to have them
    sent to you.</p>
  <h4>Leisure</h4>
  <p> You have the weekends off unless the school has planned an arrangement.
    You are of course always welcome to staying at the school in the weekends
    and in taking part in the various activities that you and the teacher on duty
    agree on. It is not possible to take a holiday during your course, but of
    course situations may arise which necessitate some days off.</p>
  <h4>Alcohol</h4>
  <p> We may drink beer and wine in the weekends, but we do not accept abuse.
    You will be informed about our policy on alcohol at your arrival. Spirits
    are not allowed. Hash and other euphoriants are of course forbidden. Doping
    also. Smoking is allowed in special areas.</p>
  <h4>Good Food</h4>
  <p> Vejle College of Sports is renowned for its good food. Both at lunch and
    dinner there is a salad bar where you are spoiled for choice. Of course special
    consideration is shown to people with allergy and others who cannot or must
    not eat all types of food.
  </p>
  <?php

?>
  <h2>Contact information </h2>
  <address>Vejle Idr&aelig;tsh&oslash;jskole<br />
    &Oslash;rnebjergvej 28<br />
    DK-7100 Vejle<br />
    Denmark</address>
  <p>Telephone: +45 7582 0811<br />
    E-mail: <a href="mailto:kontor@vih.dk">kontor@vih.dk</a><br />
    Internet: <a href="http://www.vih.dk">www.vih.dk</a> </p>
 <?php
?>
</div>
</body>
</html>

*/