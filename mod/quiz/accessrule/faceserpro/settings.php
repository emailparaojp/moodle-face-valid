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
 * Settings for the quizaccess_faceserpro plugin.
 *
 * @package    quizaccess_faceserpro
 * @Copyright 2024 RCN
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $ADMIN;

if ($hassiteconfig) {
    $pageurl = new moodle_url('/mod/quiz/accessrule/faceserpro/deleteallimages.php');
    $btnlabel = get_string('settingscontroll:deleteall', 'quizaccess_faceserpro');
    $params = new stdClass();
    $params->pageurl = $pageurl->__toString();
    $params->btnlabel = $btnlabel;
    $params->formlabel = get_string('settings:deleteallformlabel', 'quizaccess_faceserpro');
    $params->deleteconfirm = get_string('settings:deleteallconfirm', 'quizaccess_faceserpro');

    $PAGE->requires->js_call_amd('quizaccess_faceserpro/deletebtnjs', 'setup', [$params]);

    $settings->add(new admin_setting_description('quizaccess_faceserpro/adminimage',
        get_string('setting:adminimagepage', 'quizaccess_faceserpro'),
        '<a
            class="mb-5" style="font-size: 20px;"
            href=" ' . new moodle_url('/mod/quiz/accessrule/faceserpro/userslist.php') .'">'.
            get_string('setting:userslist', 'quizaccess_faceserpro') .
            '</a>'),
            'admin image');

    $settings->add(new admin_setting_configtext('quizaccess_faceserpro/autoreconfigurecamshotdelay',
        get_string('setting:camshotdelay', 'quizaccess_faceserpro'),
        get_string('setting:camshotdelay_desc', 'quizaccess_faceserpro'), 30, PARAM_INT));

    $settings->add(new admin_setting_configtext('quizaccess_faceserpro/autoreconfigureimagewidth',
        get_string('setting:camshotwidth', 'quizaccess_faceserpro'),
        get_string('setting:camshotwidth_desc', 'quizaccess_faceserpro'), 230, PARAM_INT));

    $choices = array(
        'BS' => 'BS',
        'None' => 'None'
    );
    $settings->add(new admin_setting_configselect('quizaccess_faceserpro/fcmethod',
        get_string('setting:fc_method', 'quizaccess_faceserpro'),
        get_string('setting:fc_methoddesc', 'quizaccess_faceserpro'),
        'None',
        $choices
    ));

    $settings->add(new admin_setting_configtext('quizaccess_faceserpro/bsapi',
        get_string('setting:bs_api', 'quizaccess_faceserpro'),
        get_string('setting:bs_apidesc', 'quizaccess_faceserpro'), '', PARAM_TEXT));

    // New Option BS API KEY.
    $settings->add(new admin_setting_configpasswordunmask('quizaccess_faceserpro/bs_api_key',
        get_string('setting:bs_api_key', 'quizaccess_faceserpro'),
        get_string('setting:bs_api_keydesc', 'quizaccess_faceserpro'), '', PARAM_TEXT));


    $settings->add(new admin_setting_configtext('quizaccess_faceserpro/threshold',
        get_string('setting:bs_apifacematchthreshold', 'quizaccess_faceserpro'),
        get_string('setting:bs_bs_apifacematchthresholddesc', 'quizaccess_faceserpro'), '68', PARAM_INT));

    // $settings->add(new admin_setting_configtext('quizaccess_faceserpro/awskey',
    //     get_string('setting:aws_key', 'quizaccess_faceserpro'),
    //     get_string('setting:aws_keydesc', 'quizaccess_faceserpro'), '', PARAM_TEXT));

    // $settings->add(new admin_setting_configtext('quizaccess_faceserpro/awssecret',
    //     get_string('setting:aws_secret', 'quizaccess_faceserpro'),
    //     get_string('setting:aws_secretdesc', 'quizaccess_faceserpro'), '', PARAM_TEXT));

    $settings->add(new admin_setting_configtext('quizaccess_faceserpro/awschecknumber',
        get_string('setting:facematch', 'quizaccess_faceserpro'),
        get_string('setting:facematchdesc', 'quizaccess_faceserpro'), '', PARAM_INT));

    $settings->add(new admin_setting_configtext('quizaccess_faceserpro/awsfcthreshold',
        get_string('setting:fcthreshold', 'quizaccess_faceserpro'),
        get_string('setting:fcthresholddesc', 'quizaccess_faceserpro'), '80', PARAM_INT));

    $settings->add(new admin_setting_configcheckbox('quizaccess_faceserpro/fcheckstartchk',
        get_string('settings:fcheckquizstart', 'quizaccess_faceserpro'),
        get_string('settings:fcheckquizstart_desc', 'quizaccess_faceserpro'), 0));
}
