<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Notificationeabc enrolment plugin.
 *
 * This plugin notifies users when an event occurs on their enrolments (enrol, unenrol, update enrolment)
 *
 * @package    enrol_notificationical
 * @copyright  2017 e-ABC Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Osvaldo Arriola <osvaldo@e-abclearning.com>
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/moodlelib.php');

/**
 * Lib class
 *
 * @package    enrol_notificationical
 * @copyright  2017 e-ABC Learning
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Osvaldo Arriola <osvaldo@e-abclearning.com>
 */
class enrol_notificationical_plugin extends enrol_plugin
{
    /** @var log.*/
    private $log = '';

    // Funcion que envia las notificaciones a los usuarios.

    public function send_to_all(stdClass $course, $type) {
        global $CFG, $DB;


    }
    /**
     * Send mail method
     * @param stdClass $user user instance
     * @param stdClass $course course instance
     * @param int $type notice enrollment, update or unenrollment
     * @return bool
     */
    public function send_email(stdClass $user, stdClass $course, $type, \core\event\base $event) {
        global $CFG, $DB;
        if (!empty($CFG->noemailever))
        {
            return;
        }

        $course->url = $CFG->wwwroot . '/course/view.php?id=' . $course->id;

        $enrol = $DB->get_record('enrol', array('enrol' => 'notificationical', 'courseid' => $course->id, 'status' => 0));

        $pluginconfig = get_config('enrol_notificationical');
        $enrolalert = $pluginconfig->enrolalert;
        $globalenrolalert = $pluginconfig->globalenrolalert;
        $unenrolalert = $pluginconfig->unenrolalert;
        $globalunenrolalert = $pluginconfig->globalunenrolalert;
        $method = "PUBLISH";
        $subject = get_string('subject', 'enrol_notificationical');
        $enrolupdatealert = $pluginconfig->enrolupdatealert;
        $globalenrolupdatealert = $pluginconfig->globalenrolupdatealert;
        $attachical = $pluginconfig->attachical;
        $sendtosupport = $pluginconfig->sendtosupport;
        $update = false;

        if (!isset($enrol->customtext1) || !$enrolmessage = $enrol->customtext1) { // Corse level.
            if (!$enrolmessage = $pluginconfig->enrolmessage) { // Plugin level.
                $enrolmessage = get_string('enrolmessagedefault', 'enrol_notificationical', $course);
            }
        }
        if (!isset($enrol->customtext2) || !$unenrolmessage = $enrol->customtext2) { // Corse level.
            if (!$unenrolmessage = $pluginconfig->unenrolmessage) { // Plugin level.
                $unenrolmessage = get_string('unenrolmessagedefault', 'enrol_notificationical', $course);
            }
        }
        if (!isset($enrol->customtext3) || !$enrolupdatemessage = $enrol->customtext3) { // Corse level.
            if (!$enrolupdatemessage = $pluginconfig->enrolupdatemessage) { // Plugin level.
                $enrolupdatemessage = get_string('enrolupdatemessagedefault', 'enrol_notificationical', $course);
            }
        }

        switch ((int)$type) {
            case 1:
                if (!empty($enrolalert) || !empty($globalenrolalert)) {
                    $message = $this->get_message($enrolmessage, $user, $course, $event);
                    $method = "PUBLISH";
                    $subject = get_string('enrolsubject', 'enrol_notificationical');
                }
                break;
            case 2:
                if (!empty($unenrolalert) || !empty($globalunenrolalert)) {
                    $message = $this->get_message($unenrolmessage, $user, $course, $event);
                    $method = "CANCEL";
                    $subject = get_string('unenrolsubject', 'enrol_notificationical');
                }
                break;
            case 3:
                if (!empty($enrolupdatealert) || !empty($globalenrolupdatealert)) {
                    $message = $this->get_message($enrolupdatemessage, $user, $course, $event);
                    $method = "REQUEST";
                    $subject = get_string('updatesubject', 'enrol_notificationical');
                    $update = true;
                }
                break;
            default:
                break;
        }
        $summary = '';
        $description = '';

        $supportuser = \core_user::get_support_user();

        $eventdata = new \core\message\message();
        $eventdata->courseid = $course->id;
        $eventdata->modulename = 'moodle';
        $eventdata->component = 'enrol_notificationical';
        $eventdata->name = 'notificationical_enrolment';
        $eventdata->userfrom = $supportuser;
        $eventdata->userto = $user->id;
        $eventdata->subject = $subject . " " . $course->fullname;
        $eventdata->fullmessage = '';
        $eventdata->fullmessageformat = FORMAT_HTML;
        $eventdata->fullmessagehtml = $message;
        $eventdata->smallmessage = '';
        $eventdata->timecreated = time();
        $supportdata = clone($eventdata);
        $supportdata->userto = $supportuser;
        $supportdata->subject .= " - User: " . fullname($user) . " (" . $user->username . ")";

        $file = null;
        if ($attachical) {
            $ical = $this->get_ical_attachment($user, $course, $supportuser, $summary, $description);
            $attachmenttext = $ical->get_attachment($method, $update);
            $attachname = md5(microtime() . $user->id) . $ical->get_name();
            $eventdata->attachname = $attachname;

            $usercontext = context_user::instance($user->id);
            $file = new stdClass();
            $file->contextid = $usercontext->id;
            $file->component = 'user';
            $file->filearea  = 'attachment';
            $file->itemid    = $user->id;
            $file->filepath  = '/';
            $file->filename  = $attachname;

            $fs = get_file_storage();
            $file = $fs->create_file_from_string($file, $attachmenttext);

            $eventdata->attachment = $file;
        }

        $strdata = new stdClass();
        $strdata->username = $user->username;
        $strdata->coursename = $course->fullname;
        if (message_send($eventdata)) {
            $this->log .= get_string('succefullsend', 'enrol_notificationical', $strdata);

            if ($sendtosupport) {
                message_send($supportdata);
            }
            return true;
        } else {
            $this->log .= get_string('failsend', 'enrol_notificationical', $strdata);

            if ($sendtosupport) {
                $supportdata->subject = "(Failed to send notification to user) " . $supportdata->subject;
                message_send($supportdata);
            }
            return false;
        }
        if ($file) {
            $file->delete();
        }

    } // End of function.

    // Procesa el mensaje para aceptar marcadores.
    /**
     * Proccess message method
     * @param String $message the raw message
     * @param stdClass $user user instance
     * @param stdClass $course course instance
     * @return String the processed message
     */
    public function get_message($message, stdClass $user, stdClass $course, \core\event\base $event) {
        global $DB;

        $m = $message;
        $startdate = $course->startdate;
        $enddate = $course->enddate;
        if ($event && $event instanceof \core\event\user_enrolment_created) {
            $ue = $DB->get_record('user_enrolments', array('id' => $event->objectid));
            if ($ue){
                if ($ue->timestart){
                    $startdate = $ue->timestart;
                }
                if ($ue->timeend) {
                    $enddate = $ue->timeend;
                }
                else {
                    $enddate = 0;
                }
            }
        }
        $startdate_formatted = userdate($startdate, get_string('strftimedaydate', 'core_langconfig'));
        $enddate_formatted = null;
        if ($enddate) {
            $enddate_formatted = userdate($enddate, get_string('strftimedaydate', 'core_langconfig'));;
        }
        else {
            $enddate_formatted = "(end date not yet set)";
        }
        $url = new moodle_url('/course/view.php', array('id' => $course->id));
        $m = str_replace('{COURSENAME}', $course->fullname, $m);
        $m = str_replace('{COURSESHORTNAME}', $course->shortname, $m);
        $m = str_replace('{USERNAME}', $user->username, $m);
        $m = str_replace('{FIRSTNAME}', $user->firstname, $m);
        $m = str_replace('{LASTNAME}', $user->lastname, $m);
        $m = str_replace('{URL}', $url, $m);
        $m = str_replace('{NOTIFICATION_URL}', (new moodle_url('/message/notificationpreferences.php'))->out(), $m);
        $m = str_replace('{STARTTIME}', $startdate_formatted, $m);
        $m = str_replace('{ENDTIME}', $enddate_formatted, $m);

        return $m;
    }
    /**
     * Get ical attachment
     *
     * @param int $courseid
     * @return \enrol_notificationical\ical
    */
    public function get_ical_attachment($user, $course, $userfrom, $summary, $description){
        $ical = new \enrol_notificationical\ical($user, $course, $userfrom, $summary, $description);
        return $ical;
    }
    /**
     * Returns link to page which may be used to add new instance of enrolment plugin in course.
     * @param int $courseid
     * @return moodle_url page url
     */
    public function get_newinstance_link($courseid) {
        global $DB;

        $numenrol = $DB->count_records('enrol', array('courseid' => $courseid, 'enrol' => 'notificationical'));
        $context = context_course::instance($courseid, MUST_EXIST);

        if (!has_capability('enrol/notificationical:manage', $context) or $numenrol >= 1) {
            return null;
        }

        return new moodle_url('/enrol/notificationical/edit.php', array('courseid' => $courseid));
    }


    /**
     * Returns defaults for new instances.
     * @return array
     */
    public function get_instance_defaults() {

        $fields = array();
        $fields['enrolmessage'] = $this->get_config('enrolmessage');
        $fields['unenrolmessage'] = $this->get_config('unenrolmessage');
        $fields['enrolupdatemessage'] = $this->get_config('enrolupdatemessage');
        $fields['status'] = 1;
        $fields['enrolalert'] = $this->get_config('enrolalert');
        $fields['unenrolalert'] = $this->get_config('unenrolalert');
        $fields['enrolupdatealert'] = $this->get_config('enrolupdatealert');

        return $fields;
    }

    /**
     * Get icons
     * @param stdClass $instance
     * @return array
     * @throws coding_exception
     */
    public function get_action_icons(stdClass $instance) {
        global $OUTPUT;

        $context = context_course::instance($instance->courseid);

        $icons = array();

        if (has_capability('enrol/notificationical:manage', $context)) {
            $editlink = new moodle_url(
                '/enrol/editinstance.php',
                array('courseid' => $instance->courseid, 'id' => $instance->id, 'type' => 'notificationical')
            );
            $icons[] = $OUTPUT->action_icon(
                $editlink,
                new pix_icon( 't/edit', get_string('edit'), 'core', array('class' => 'icon iconsmall'))
            );
        }

        return $icons;
    }

    /**
     * Is it possible to delete enrol instance via standard UI?
     *
     * @param object $instance
     * @return bool
     */
    public function can_delete_instance($instance) {
        $context = context_course::instance($instance->courseid);
        if (!has_capability('enrol/notificationical:manage', $context)) {
            return false;
        }

        return true;
    }

    /**
     * Is it possible to hide/show enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_hide_show_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/notificationical:config', $context);
    }

    /**
     * get info icons method
     * @param array $instances
     * @return array
     */
    public function get_info_icons(array $instances) {
        $icons = array();
        $icons[] = new pix_icon('email', get_string('pluginname', 'enrol_notificationical'), 'enrol_notificationical');
        return $icons;
    }

    /**
     * We are a good plugin and don't invent our own UI/validation code path.
     *
     * @return boolean
     */
    public function use_standard_editing_ui() {
        return true;
    }

    /**
     * Return an array of valid options for the status.
     *
     * @return array
     */
    protected function get_status_options() {
        $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                         ENROL_INSTANCE_DISABLED => get_string('no'));
        return $options;
    }

    /**
     * Add elements to the edit instance form.
     *
     * @param stdClass $instance
     * @param MoodleQuickForm $mform
     * @param context $context
     * @return bool
     */
    public function edit_instance_form($instance, MoodleQuickForm $mform, $context) {

        $textareaparams = array('rows' => 8, 'cols' => 60);

        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));
        $mform->setType('name', PARAM_RAW);
        $mform->setDefault('name', get_string('pluginname', 'enrol_notificationical'));

        $options = $this->get_status_options();
        $mform->addElement('select', 'status', get_string('status', 'enrol_notificationical'), $options);
        $mform->setDefault('status', $this->get_config('status'));

        // Enrol notifications -> 'enrolalert'.
        $mform->addElement('advcheckbox', 'customint1', get_string('enrolalert', 'enrol_notificationical'));
        $mform->addHelpButton('customint1', 'enrolalert', 'enrol_notificationical');
        $mform->setDefault('customint1', $this->get_config('enrolalert'));

        // Enrol notifications -> 'enrolmessage'
        $mform->addElement('textarea', 'customtext1', get_string('enrolmessage', 'enrol_notificationical'), $textareaparams);
        $mform->addHelpButton('customtext1', 'enrolmessage', 'enrol_notificationical');
        $mform->setType('customtext1', PARAM_RAW);
        $mform->setDefault('customtext1', $this->get_config('enrolmessage'));

        // Unenrol notifications -> 'unenrolalert'.
        $mform->addElement('advcheckbox', 'customint2', get_string('unenrolalert', 'enrol_notificationical'));
        $mform->addHelpButton('customint2', 'unenrolalert', 'enrol_notificationical');
        $mform->setDefault('customint2', $this->get_config('unenrolalert'));

        // Unenrol notifications -> 'unenrolmessage'.
        $mform->addElement('textarea', 'customtext2', get_string('unenrolmessage', 'enrol_notificationical'), $textareaparams);
        $mform->addHelpButton('customtext2', 'unenrolmessage', 'enrol_notificationical');
        $mform->setType('customtext2', PARAM_RAW);
        $mform->setDefault('customtext2', $this->get_config('unenrolmessage'));

        // Update enrolment notifications -> 'enrolupdatealert'.
        $mform->addElement('advcheckbox', 'customint3', get_string('enrolupdatealert', 'enrol_notificationical'));
        $mform->addHelpButton('customint3', 'enrolupdatealert', 'enrol_notificationical');
        $mform->setDefault('customint3', $this->get_config('enrolupdatealert'));

        // Update enrolment -> 'enrolupdatemessage'.
        $mform->addElement('textarea', 'customtext3', get_string('enrolupdatemessage', 'enrol_notificationical'), $textareaparams);
        $mform->addHelpButton('customtext3', 'enrolupdatemessage', 'enrol_notificationical');
        $mform->setType('customtext3', PARAM_RAW);
        $mform->setDefault('customtext3', $this->get_config('enrolupdatemessage'));

        if (enrol_accessing_via_instance($instance)) {
            $warntext = get_string('instanceeditselfwarningtext', 'core_enrol');
            $mform->addElement('static', 'selfwarn', get_string('instanceeditselfwarning', 'core_enrol'), $warntext);
        }
    }

    /**
     * Perform custom validation of the data used to edit the instance.
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @param object $instance The instance loaded from the DB
     * @param context $context The context of the instance we are editing
     * @return array of "element_name"=>"error_description" if there are errors,
     *         or an empty array if everything is OK.
     * @return void
     */
    public function edit_instance_validation($data, $files, $instance, $context) {
        $errors = array();
        $validstatus = array_keys($this->get_status_options());
        $tovalidate = array('status' => $validstatus);

        $typeerrors = $this->validate_param_types($data, $tovalidate);
        $errors = array_merge($errors, $typeerrors);

        return $errors;
    }
} // End of class.

