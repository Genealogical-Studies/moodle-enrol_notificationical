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

$string['failsend'] = 'WARNUNG: Es war nicht möglich {$a->username} über die Kurseinschreibung in {$a->coursename} zu informieren'."\n";
$string['messageprovider:notificationical_enrolment'] = 'Einschreibebenachrichtigungen';
$string['notificationical:config'] = 'Konfigurieren von E-Mail-Benachrichtigungen';
$string['notificationical:manage'] = 'Verwalten von Benachrichtigungen';
$string['pluginname'] = 'Einschreibebenachrichtung';
$string['status'] = 'Einschreibebenachrichtigung via E-Mail aktivieren';
$string['subject'] = 'Kurseinschreibung';
$string['succefullsend'] = 'Nutzer/in {$a->username} wurde über die Einschreibung in {$a->coursename} benachrichtigt'."\n";
$string['enrolsubject'] = 'Benachrichtigung über die Kurseinschreibung: ';
$string['unenrolsubject'] = 'Benachrichtigung über die Kursabmeldung: ';
$string['enrolupdatedsubject'] = 'Benachrichtigung über Kurseinschreibeänderungen: ';

// Enrol notifications.
$string['enrolalert'] = 'Kurseinschreibebenachrichtigung aktivieren';
$string['enrolalert_help'] = 'Hilfe zu Kurseinschreibebenachrichtigung';
$string['globalenrolalert'] = 'Globale Kurseinschreibebenachrichtigung aktivieren';
$string['globalenrolalert_help'] = 'Hile zur globalen Kurseinschreibebenachrichtigung';
$string['enrolmessage'] = 'Benachrichtigungstext';
$string['enrolmessage_help'] = 'Personalisieren Sie die Nachricht, für Anmeldebenachrichtigungen. Folgende Platzhalter werden dynamisch ersetzt:
<pre>
{COURSENAME} = Kursname
{USERNAME} = Nutzer/inname
{FIRSTNAME} = Vorname
{LASTNAME} = Nachname
{URL} = Kurs-URL
{STARTTIME} = Kursstart
{ENDTIME} = Kursende
</pre>';
$string['enrolmessagedefault'] = 'Sie wurden in {$a->fullname} ({$a->url}) eingeschrieben';

// Unenrol notifications.
$string['unenrolalert'] = 'Kursabmeldebenachrichtigung aktivieren';
$string['unenrolalert_help'] = 'Hilfe zu Kursabmeldebenachrichtigung';
$string['globalunenrolalert'] = 'Globale Kursabmeldebenachrichtigung';
$string['globalunenrolalert_help'] = 'Hilfe zur globaler Kursabmeldebenachrichtigung';
$string['unenrolmessage'] = 'Kursabmeldebenachrichtigungstext';
$string['unenrolmessage_help'] = 'Personalisieren Sie die Nachricht, für Abmeldebenachrichtigungen. Folgende Platzhalter werden dynamisch ersetzt:
<pre>
{COURSENAME} = Kursname
{USERNAME} = Nutzer/inname
{FIRSTNAME} = Vorname
{LASTNAME} = Nachname
{URL} = Kurs-URL
{STARTTIME} = Kursstart
{ENDTIME} = Kursende
</pre>';
$string['unenrolmessagedefault'] = 'Wie wurden von {$a->fullname} ({$a->url}) abgemeldet';

// Update enrol notifications.
$string['enrolupdatealert'] = 'Benachrichtigung über Kursanmeldungsänderungen aktivieren';
$string['enrolupdatealert_help'] = 'Hilfe zu Kursanmeldungsänderungen';
$string['globalenrolupdatealert'] = 'Globale Kursanmeldungsänderungen aktivieren';
$string['globalenrolupdatealert_help'] = 'Hilfe zu globle Kursanmeldungsänderungen';
$string['enrolupdatemessage'] = 'Text für Kursanmeldungsänderungen';
$string['enrolupdatemessage_help'] = 'Personalisieren Sie die Nachricht, für Kursanmeldungsänderungen. Folgende Platzhalter werden dynamisch ersetzt:
<pre>
{COURSENAME} = Kursname
{USERNAME} = Nutzer/inname
{FIRSTNAME} = Vorname
{LASTNAME} = Nachname
{URL} = Kurs-URL
{STARTTIME} = Kursstart
{ENDTIME} = Kursende
</pre>';
$string['enrolupdatemessagedefault'] = 'Ihre Anmeldung zu {$a->fullname} wurde aktualisiert ({$a->url})';


//Subjectnames
$string['enrolsubject'] = 'Bestätigung Kurseinschreibung';
$string['unenrolsubject'] = 'Abmeldung Kurs';
$string['updatesubject'] = 'Update Kurs';