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
namespace enrol_notificationical;

defined('MOODLE_INTERNAL') || die();

/**
 * Support class for generating ical items Note - this code is based on the ical code from mod_facetoface
 *
 * @package enrol_notificationical
 * @copyright 2012-2017 Davo Smith, Synergy Learning, Andras Princic, David Bogner
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class ical {

    private $datesareset = false;

    protected $course;

    protected $user;

    protected $fromuser;

    protected $tempfilename = '';

    protected $times = '';

    protected $ical = '';

    protected $vevents = '';

    protected $dtstamp = '';

    protected $summary = '';

    protected $description = '';

    protected $location = '';

    protected $host = '';

    protected $status = '';

    protected $role = 'REQ-PARTICIPANT';

    protected $userfullname = '';

    protected $subjectprefix = '';

    protected $sequence = '0';


    /**
     * Create a new mod_booking\ical instance
     *
     * @param object $booking the booking activity details
     * @param object $option the option that is being booked
     * @param object $user the user the booking is for
     * @param string $subject The event type unenrol/enrol/enrolment update
     */
    public function __construct($user, $course, $userfrom, $subject) {
        global $DB, $CFG;

        $this->subjectprefix = $subject;
        $this->course = $course;
        $this->fromuser = $userfrom;
        $this->location = $this->course->url;
        $this->summary = $this->subjectprefix . $this->course->fullname;
        $this->description = strip_tags($this->course->summary);
        // Check if start and end dates exist.
        // NOTE: Newlines are meant to be encoded with the literal sequence
        // '\n'. But evolution presents a single line text field for location,
        // and shows the newlines as [0x0A] junk. So we switch it for commas
        // here. Remember commas need to be escaped too.

        $this->datesareset = true;
        $this->user = $DB->get_record('user', array('id' => $user->id));
        // Date that this representation of the calendar information was created -
        // See http://www.kanzaki.com/docs/ical/dtstamp.html.
        $this->dtstamp = $this->generate_timestamp($this->course->timemodified);
        $urlbits = parse_url($CFG->wwwroot);
        $this->host = $urlbits['host'];
        $this->userfullname = \fullname($this->user);

    }
    /**
     * Create an attachment to add to the notification email
     *
     * @param bool $cancel optional - true to generate a 'cancel' ical event
     * @return string the path to the attachment file empty if no dates are set
     */
    public function get_attachment($method, $update = false) {
        global $CFG;
        if (!$this->datesareset) {
            return '';
        }

        // UIDs should be globally unique. @$this->host: Hostname for this moodle installation.
        $uid = md5($CFG->siteidentifier . $this->course->id . 'ical_enrol') . '@' . $this->host;
        $dtstart = $this->generate_timestamp($this->course->startdate);
        $dtend = $this->generate_timestamp($this->course->enddate);
        if ($dtend < $dtstart){
            $dtend = $dtstart;
        }

        if ($method == "CANCEL"){
            $this->role = 'NON-PARTICIPANT';
            $this->status = "\nSTATUS:CANCELLED";
        }

        if ($update){
            $this->sequence = $this->course->timemodified;
        }

        $icalmethod = $method;


        $this->add_vevent($uid, $dtstart, $dtend);


        $this->vevents = trim($this->vevents);

        $template = <<<EOF
BEGIN:VCALENDAR
VERSION:2.0
METHOD:{$icalmethod}
PRODID:Data::ICal 0.22
CALSCALE:GREGORIAN
{$this->vevents}
END:VCALENDAR
EOF;


        $template = str_replace("\n", "\r\n", $template);

        return $template;
    }

    /**
     * Get the dates from the sessions and render them for ical. Events are saved in $this->vevents
     */
    protected function get_vevents_from_optiondates() {
        global $CFG;
        foreach ($this->times as $time) {
            $dtstart = $this->generate_timestamp($time->coursestarttime);
            $dtend = $this->generate_timestamp($time->courseendtime);
            $uid = md5($CFG->siteidentifier . $time->id . $this->course->id . 'mod_booking_option') . '@' . $this->host;
            $this->add_vevent($uid, $dtstart, $dtend);
        }
    }

    /**
     * Add data to ical string
     *
     * @param string $uid
     * @param string $dtstart
     * @param string $dtend
     */
    protected function add_vevent ($uid, $dtstart, $dtend) {
        $this->vevents .= <<<EOF
BEGIN:VEVENT
CLASS:PUBLIC
DESCRIPTION:{$this->description}
DTEND:{$dtend}
DTSTAMP:{$this->dtstamp}
DTSTART:{$dtstart}
LOCATION:{$this->location}
PRIORITY:5
SEQUENCE:{$this->sequence}
SUMMARY:{$this->summary}
TRANSP:OPAQUE{$this->status}
ORGANIZER;CN={$this->fromuser->email}:MAILTO:{$this->fromuser->email}
ATTENDEE;CUTYPE=INDIVIDUAL;ROLE={$this->role};PARTSTAT=NEEDS-ACTION;RSVP=false;CN={$this->userfullname};LANGUAGE=en:MAILTO:{$this->user->email}
UID:{$uid}
END:VEVENT

EOF;

    }

    public function get_name() {
        return '.ics';
    }

    protected function generate_timestamp($timestamp) {
        return gmdate('Ymd', $timestamp) . 'T' . gmdate('His', $timestamp) . 'Z';
    }

    protected function escape($text, $converthtml = false) {
        if (empty($text)) {
            return '';
        }

        if ($converthtml) {
            $text = html_to_text($text);
        }

        $text = str_replace(array('\\', "\n", ';', ','), array('\\\\', '\n', '\;', '\,'), $text);

        // Text should be wordwrapped at 75 octets, and there should be one whitespace after the newline that does the wrapping.
        $text = wordwrap($text, 75, "\n ", true);

        return $text;
    }
}
