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
 * Notificationical enrolment plugin.
 *
 * This plugin notifies users when an event occurs on their enrolments (enrol, unenrol, update enrolment)
 *
 * @package    enrol_notificationical
 * @copyright  based on the work by 2017 e-ABC Learning
 * @copyright  2019 by Thomas Winkler, Wunderbyte GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Osvaldo Arriola <osvaldo@e-abclearning.com>
 */

$string['failsend'] = 'WARNING: unable notify the \'{$a->username}\' user about their enrollment in the {$a->coursename} course'."\n";
$string['messageprovider:notificationical_enrolment'] = 'Enroll email notification messages';
$string['notificationical:config'] = 'Configure email notificationical instances';
$string['notificationical:manage'] = 'Manage email notificationical';
$string['pluginname'] = 'Enroll notification';
$string['status'] = 'Activate email notification';
$string['subject'] = 'Course enrollment';
$string['succefullsend'] = 'The user {$a->username} has been notified about their enrollment in the {$a->coursename} course'."\n";
$string['enrolsubject'] = 'Course enrollment notification: ';
$string['unenrolsubject'] = 'Course unenrollment notification: ';
$string['enrolupdatedsubject'] = 'Course enrollment update notfication: ';

// Enrol notifications.
$string['enrolalert'] = 'Enable enroll message';
$string['enrolalert_help'] = 'Enable enroll message';
$string['globalenrolalert'] = 'Enable global enroll message';
$string['globalenrolalert_help'] = 'Enable site wide enroll message';
$string['enrolmessage'] = 'Custom enroll message';
$string['enrolmessage_help'] = 'Personalize the message that users will come to be enrolled. This field accepts the following markers which then will be replaced by the corresponding values ​​dynamically
<pre>
{COURSENAME} = course fullname
{USERNAME} = username
{FIRSTNAME} = firstname
{LASTNAME} = lastname
{URL} = course url
{STARTTIME} = course start
{ENDTIME} = course end
</pre>';
$string['enrolmessagedefault'] = 'You have been enrolled in {$a->fullname} ({$a->url})';

// Unenrol notifications.
$string['unenrolalert'] = 'Enable unenroll message';
$string['unenrolalert_help'] = 'Enable unenroll message';
$string['globalunenrolalert'] = 'Enable global unenroll message';
$string['globalunenrolalert_help'] = 'Site wide unenroll message';
$string['unenrolmessage'] = 'Custom unenroll message';
$string['unenrolmessage_help'] = 'Personalize the message that users will come to be unenrolled. This field accepts the following markers which then will be replaced by the corresponding values ​​dynamically
<pre>
{COURSENAME} = course fullname
{USERNAME} = username
{FIRSTNAME} = firstname
{LASTNAME} = lastname
{URL} = course url
{STARTTIME} = course start
{ENDTIME} = course end
</pre>';
$string['unenrolmessagedefault'] = 'You have been unenrolled from {$a->fullname} ({$a->url})';

// Update enrol notifications.
$string['enrolupdatealert'] = 'Enable enroll update message';
$string['enrolupdatealert_help'] = 'Enable enroll update message';
$string['globalenrolupdatealert'] = 'Enable global enroll update message';
$string['globalenrolupdatealert_help'] = 'Site wide enroll update message';
$string['enrolupdatemessage'] = 'Custom enroll update message';
$string['enrolupdatemessage_help'] = 'Personalize the message that users will come to be updated. This field accepts the following markers which then will be replaced by the corresponding values ​​dynamically
<pre>
{COURSENAME} = course fullname
{USERNAME} = username
{FIRSTNAME} = firstname
{LASTNAME} = lastname
{URL} = course url
{STARTTIME} = course start
{ENDTIME} = course end
</pre>';
$string['enrolupdatemessagedefault'] = 'Your enrollment to {$a->fullname} has been updated ({$a->url})';

//Subjectnames
$string['enrolsubject'] = 'Enroll notification';
$string['unenrolsubject'] = 'Unenroll notification';
$string['updatesubject'] = 'Course Updated';