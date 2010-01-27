<?php
/*
class VIH_SignUp {

    const TABLE_SignUp = 'signup';
    private $db;
    private $id;
    public $name;
    public $cpr;
    public $course_id;
    private $payment = array();
    private $contact = array();
    private $product = array();

    function __construct($db, $id = 0) {
        $this->db = $db;
        $this->id = intval($id);
    }

    function getId() {
        return $this->id;
    }

    function save() {
        $fields = array(
            'name' => $this->name,
            'cpr' => $this->cpr,
            'course_id' => $this->course_id
        );

        $this->db->loadModule('Extended');
        if ($this->id > 0) {
            $result = $this->db->autoExecute(TABLE_TILMELDING, $fields, MDB2_AUTOQUERY_UPDATE, 'id='.$this->db->quote($this->id, 'integer'));
        }
        else {
            $fields['id'] = $this->db->nextId(TABLE_TILMELDING);
            $result = $this->db->autoExecute(TABLE_TILMELDING, $fields, MDB2_AUTOQUERY_INSERT);
        }

    }

    // følgende gør det til en invoice eller noget lignende
    // og det kommer til at ligne vores debtor system
    function addProduct(VIH_Product $product) {
        $this->product[] = $product;
        // kursusgebyr men også mange andre produkter
        // produkter skal sikkert bare oprettes on the fly
        // den her er ligeglad med om det er nye produkter
        // eller hvad det er
    }
    function getProducts() {
        return $this->product;
        // hvis vi bare lave en enkelt sql, der kalder alle produkter
        // og så fylder et array - eller måske er det smartere
        // at returnere objekter, men så sætte værdierne herfra
    }
    function getTotalPrice() {
        $total_price = 0;
        foreach ($this->getProducts() AS $product) {
            // hvordan tager vi højde for rabatterne?
        }
        // get all products and calculate
        return $total_price;
    }
    function addPayment($payment) {
        $this->payment[] = $payment;
    }
    function getPayments() {
        return $this->payment;
    }
    function getTotalPaid() {
        $is_paid = 0;
        return $is_paid;
    }
    function isPaid() {
        return ($this->getTotalPrice() - $this->getTotalPaid() >= 0);
    }
    // to make it possible to add more contacts
    // for instance højskole skal der være en forældre kontakt
    function addContact(VIH_Contact $contact) {
        $this->contact[] = $contact;
    }
    function getContacts() {
        return $this->contact;
    }

    function addCustomField() {}
    function getCustomFields() {}

    function getBirthDate() {
        return $this->cpr;
    }
    function getAgeOnThisDate($date) {
        return $this->getBirthDate() - $date;
    }
}

class VIH_Course {

    public $spots;
    public $price_pr_week;
    public $number_of_weeks;
    private $signup;
    private $waitinglist;

    function __construct() {}

    // skal kursus vide hvad den skal?
    function addSignup(VIH_Signup $signup) {
        if (!$this->isEmptySpot()) {
            return false;
        }
        $this->signup[] = $signup;
    }

    function getSignups() {
        return $this->signup;
    }

    function addToWaitingList(VIH_Signup $signup) {
        $this->waitinglist[] = $signup;
    }

    function getWaitingList() {
        return $waitinglist;
    }

    function getEmptySpots() {
        return ($this->spots - count($this->getSignups()));
    }

    function isEmptySpot() {
        if ($this->getEmptySpots() <= 0) return false;
        else return true;
    }

}

class VIH_Payment {
    function __construct() {}
}

class VIH_Product {
    function __construct() {}
    function save() {}

}
*/
?>