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

$string['failsend'] = 'WARNING: it has no been able to notify the {$a->username} user about his enrollment in the {$a->coursename} course'."\n";
$string['messageprovider:notificationical_enrolment'] = 'Enrol email notification messages';
$string['notificationical:config'] = 'Configure email notificationical instances';
$string['notificationical:manage'] = 'Manage email notificationical';
$string['pluginname'] = 'Enrol notification';
$string['status'] = 'Activate email notification';
$string['subject'] = 'Course enrollment';
$string['succefullsend'] = 'The user {$a->username} has been notified about his enrollment in the {$a->coursename} course'."\n";
$string['enrolsubject'] = 'Course enrolment notification: ';
$string['unenrolsubject'] = 'Course unenrolment notification: ';
$string['enrolupdatedsubject'] = 'Course enrolment update notfication: ';

// Enrol notifications.
$string['enrolalert'] = 'Enable enrol message';
$string['enrolalert_help'] = 'Enable enrol message';
$string['globalenrolalert'] = 'Enable global enrol message';
$string['globalenrolalert_help'] = 'Enable site wide enrol message';
$string['enrolmessage'] = 'Custom enrol message';
$string['enrolmessage_help'] = 'Personalize the message that users will come to be enrolled. This field accepts the following markers which then will be replaced by the corresponding values ​​dynamically
<pre>
{COURSENAME} = course fullname
{COURSESHORTNAME} = course shortname
{USERNAME} = username
{FIRSTNAME} = firstname
{LASTNAME} = lastname
{URL} = course url
{STARTTIME} = course start
{ENDTIME} = course end
{NOTIFICATION_URL} = URL for user to set notification preferences (unsubscribe)
</pre>';
$string['enrolmessagedefault'] = 'You have been enrolled in {$a->fullname} ({$a->url})';

// Unenrol notifications.
$string['unenrolalert'] = 'Enable unenrol message';
$string['unenrolalert_help'] = 'Enable unenrol message';
$string['globalunenrolalert'] = 'Enable global unenrol message';
$string['globalunenrolalert_help'] = 'Site wide unenrol message';
$string['unenrolmessage'] = 'Custom unenrol message';
$string['unenrolmessage_help'] = 'Personalize the message that users will come to be unenrolled. This field accepts the following markers which then will be replaced by the corresponding values ​​dynamically
<pre>
{COURSENAME} = course fullname
{COURSESHORTNAME} = course shortname
{USERNAME} = username
{FIRSTNAME} = firstname
{LASTNAME} = lastname
{URL} = course url
{STARTTIME} = course start
{ENDTIME} = course end
{NOTIFICATION_URL} = URL for user to set notification preferences (unsubscribe)
</pre>';
$string['unenrolmessagedefault'] = 'You have been unenrolled from {$a->fullname} ({$a->url})';

// Update enrol notifications.
$string['enrolupdatealert'] = 'Enable enrol update message';
$string['enrolupdatealert_help'] = 'Enable enrol update message';
$string['globalenrolupdatealert'] = 'Enable global enrol update message';
$string['globalenrolupdatealert_help'] = 'Site wide enrol update message';
$string['enrolupdatemessage'] = 'Custom enrol update message';
$string['enrolupdatemessage_help'] = 'Personalize the message that users will come to be updated. This field accepts the following markers which then will be replaced by the corresponding values ​​dynamically
<pre>
{COURSENAME} = course fullname
{COURSESHORTNAME} = course shortname
{USERNAME} = username
{FIRSTNAME} = firstname
{LASTNAME} = lastname
{URL} = course url
{STARTTIME} = course start
{ENDTIME} = course end
{NOTIFICATION_URL} = URL for user to set notification preferences (unsubscribe)
</pre>';
$string['enrolupdatemessagedefault'] = 'Your enrolment to {$a->fullname} has been updated ({$a->url})';

//Subjectnames
$string['enrolsubject'] = 'Enrol notification';
$string['unenrolsubject'] = 'Unenrol notification';
$string['updatesubject'] = 'Course Updated';