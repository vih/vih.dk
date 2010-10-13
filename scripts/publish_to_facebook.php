<?php
require_once 'config.local.php';
set_include_path('/home/vih/pear/php/' . PATH_SEPARATOR . get_include_path());
require_once 'Ilib/ClassLoader.php';
require_once 'facebook.php';

exit($page_id);

if (empty($_GET['id'])) {
    exit('No args given');
}

$id = intval($_GET['id']);

$gateway = new VIH_Model_KortKursusGateway(new DB_Sql);
$kursus = $gateway->findById($id);


class VIH_Host implements Event_Host
{
    function getName() {
        return 'Vejle Idrætshøjskole';
    }
    function getContactPerson() {
        return 'Peter Sebastian Pedersen';
    }
    function getAddress() {
        return 'Ørnebjergvej 28';
    }
    function getZipcode() {
        return '7100';
    }
    function getEmail() {
        return 'ps@vih.dk';
    }
    function getPhone() {
        return '75820811';
    }
    function getCity() {
        return 'Vejle';
    }
}

class VIH_Event implements Event
{
    protected $kursus;

    function __construct($kursus)
    {
        $this->kursus = $kursus;
    }

      /**
     * Gets the host of the event
     *
     * @return object Event_Host
     */
    function getHost() {
        return new VIH_Host;
    }

    /**
     * Gets the location on the host
     *
     * @return string
     */
    function getLocation() {
        return 'Vejle Idrætshøjskole, højskolen';
    }

    /**
     * Gets title
     *
     * @return string
     */
    function getTitle() {
        return $this->kursus->getKursusNavn();
    }

    /**
     * Gets tagline
     *
     * @return string
     */
    function getTagline() {
        return 'Sommerkursus på Vejle Idrætshøjskole';
    }

    /**
     * Gets short teaser
     *
     * @return string
     */
    function getTeaser() {
        return '';
    }

    /**
     * Gets description
     *
     * @return string
     */
    function getDescription() {
        return strip_tags($this->kursus->get('description')) . "\n\nTilmelding på " . $this->getLink();
    }

    /**
     * Gets price in smallest amount, for instance cents and øre
     *
     * @return integer
     */
    function getPrice() {
        return $this->kursus->get('pris');
    }

    /**
     * Gets description
     *
     * @return string
     */
    function getCategory() {
        return 'Sport';
    }

    /**
     * Gets sub category
     *
     * @return string
     */
    function getSubcategory() {
        return 'Sportstræning';
    }

    /**
     * Gets start time
     *
     * @return object DateTime
     */
    function getStartAt() {
        return new DateTime($this->kursus->get('dato_start') . ' 17:00:00');
    }

    /**
     * Gets end time
     *
     * @return object DateTime
     */
    function getEndAt() {
        return new DateTime($this->kursus->get('dato_slut') . ' 10:00:00');
    }

    function getLink()
    {
        return 'http://vih.dk/kortekurser/' . $this->kursus->getId();
    }
}

$facebook = new Facebook($appapikey, $appsecret);

if (!empty($_GET['auth_token'])) {
    $auth_token = $_GET['auth_token'];
}

try {
    if (!$facebook->api_client->users_hasAppPermission('create_event')){
        echo '<script type="text/javascript">window.open("http://www.facebook.com/authorize.php?api_key='.$facebook->api_key.'&v=1.0&ext_perm=create_event", "Permission");</script>'; echo'<meta http-equiv="refresh" content="0; URL=javascript:history.back();">'; exit;
    }
} catch (Exception $e) {
    echo '<script type="text/javascript">window.open("http://login.facebook.com/login.php?api_key='.$appapikey.'&v=1.0", "Permission");</script>'; echo'<meta http-equiv="refresh" content="0; URL=javascript:history.back();">'; exit;
}

$event = new VIH_Event($kursus);

$publisher = new Event_Publisher_Facebook($facebook);
$publisher->setPageId($page_id); // the page id you want to publish to
$event_id = $publisher->publish($event);

echo $event_id;

