<?php
/**
 * @package VIH
 */
class VIH_Controller_LangtKursus_Tilmelding_Fag extends k_Controller
{
    function getPeriods()
    {
        $doctrine = $this->registry->get('doctrine');
        $tilmelding = new VIH_Model_LangtKursus_OnlineTilmelding($this->context->name);
        return Doctrine::getTable('VIH_Model_Course_Period')->findByCourseId($tilmelding->getKursus()->getId());
    }

    function getRegistration()
    {
        return new VIH_Model_LangtKursus_OnlineTilmelding($this->context->name);
    }

    function GET()
    {
        $this->document->title = 'Tilmelding: Vælg fag';

        $tilmelding = $this->getRegistration();

        $periods = $this->getPeriods();

        $data = array('periods' => $periods,
                      'tilmelding' => $tilmelding);

        return $this->render('VIH/View/LangtKursus/Tilmelding/fag-tpl.php', $data);
    }

    function POST()
    {
        if (!$this->validate()) {
            throw new Exception('Du skal vælge et af hvert fag');
        }

        $doctrine = $this->registry->get('doctrine');
        $registration = Doctrine::getTable('VIH_Model_Course_Registration')->findOneById($this->getRegistration()->getId());

        $current_subjects = Doctrine::getTable('VIH_Model_Course_Registration_Subject')->findByRegistrationId($this->getRegistration()->getId());

        foreach ($current_subjects as $subj) {
        	$subj->delete();
        }
        /*
        $subjects = array();
        foreach ($registration->Subjects as $subject) {
            $subjects[] = $subject->getId();
        }
        if (!empty($subjects)) {
            try {
                $registration->unlink('Subjects', $subjects);
            } catch (Doctrine_Query_Exception $e) {

            }
        }
        */

        if (!empty($this->POST['subject'])) {
            foreach ($this->POST['subject'] as $key => $value) {
                $registrationsubject = new VIH_Model_Course_Registration_Subject;
                $registrationsubject->period_id = $this->POST['subjectperiod'][$key];
                $registrationsubject->registration_id = $this->getRegistration()->getId();
                $registrationsubject->subject_id = $value;
                $registrationsubject->subjectgroup_id = $this->POST['subjectgroup'][$key];
                $registrationsubject->save();
            }
        }

        //$registration->save();

        throw new k_http_Redirect($this->getRedirectUrl());
    }

    function getRedirectUrl()
    {
        return $this->url('../confirm');
    }

    /**
     * This method should validate whether the correct number of subjects has
     * been chosen i the different periods and subjectgroups.
     */
    function validate()
    {
        // @hack FIXME @todo
        return true;
        /*
        if (empty($this->POST['subject'])) {
            return false;
        }
        return true;
        */
    }
}