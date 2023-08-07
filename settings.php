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

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // General settings.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationical/attachical',
        'Include ical attachment',
        'Should an ical file be attached to the notifications?',
        ''
    ));

    // Enrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationical/enrolalert',
        get_string('enrolalert', 'enrol_notificationical'),
        get_string('enrolalert_help', 'enrol_notificationical'),
        '',
        '1')
    );
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationical/globalenrolalert',
        get_string('globalenrolalert', 'enrol_notificationical'),
        get_string('globalenrolalert_help', 'enrol_notificationical'),
        '')
    );
    $settings->add(new admin_setting_configtextarea(
        'enrol_notificationical/enrolmessage',
        get_string('enrolmessage', 'enrol_notificationical'),
        get_string('enrolmessage_help', 'enrol_notificationical'),
        null)
    );

    // Unenrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationical/unenrolalert',
        get_string('unenrolalert', 'enrol_notificationical'),
        get_string('unenrolalert_help', 'enrol_notificationical'),
        '',
        '1')
    );
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationical/globalunenrolalert',
        get_string('globalunenrolalert', 'enrol_notificationical'),
        get_string('globalunenrolalert_help', 'enrol_notificationical'),
        '')
    );
    $settings->add(new admin_setting_configtextarea(
        'enrol_notificationical/unenrolmessage',
        get_string('unenrolmessage', 'enrol_notificationical'),
        get_string('unenrolmessage_help', 'enrol_notificationical'),
        null)
    );

    // Update enrol notification.
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationical/enrolupdatealert',
        get_string('enrolupdatealert', 'enrol_notificationical'),
        get_string('enrolupdatealert_help', 'enrol_notificationical'),
        '',
        '1')
    );
    $settings->add(new admin_setting_configcheckbox(
        'enrol_notificationical/globalenrolupdatealert',
        get_string('globalenrolupdatealert', 'enrol_notificationical'),
        get_string('globalenrolupdatealert_help', 'enrol_notificationical'),
        '')
    );
    $settings->add(new admin_setting_configtextarea(
        'enrol_notificationical/enrolupdatemessage',
        get_string('enrolupdatemessage', 'enrol_notificationical'),
        get_string('enrolupdatemessage_help', 'enrol_notificationical'),
        null)
    );
}
