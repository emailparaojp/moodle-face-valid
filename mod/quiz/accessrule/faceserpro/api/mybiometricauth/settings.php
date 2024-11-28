<?php
defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext(
        'quizaccess_mybiometricauth/apiurl',
        get_string('apiurl', 'quizaccess_mybiometricauth'),
        get_string('apiurldesc', 'quizaccess_mybiometricauth'),
        '',
        PARAM_URL
    ));

    $settings->add(new admin_setting_configtext(
        'quizaccess_mybiometricauth/apitoken',
        get_string('apitoken', 'quizaccess_mybiometricauth'),
        get_string('apitokendesc', 'quizaccess_mybiometricauth'),
        '',
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configtext(
        'quizaccess_mybiometricauth/apikey',
        get_string('apikey', 'quizaccess_mybiometricauth'),
        get_string('apikeydesc', 'quizaccess_mybiometricauth'),
        '',
        PARAM_RAW
    ));

    $settings->add(new admin_setting_configtext(
        'quizaccess_mybiometricauth/apiuser',
        get_string('apiuser', 'quizaccess_mybiometricauth'),
        get_string('apiuserdesc', 'quizaccess_mybiometricauth'),
        '',
        PARAM_TEXT
    ));

    $settings->add(new admin_setting_configpasswordunmask(
        'quizaccess_mybiometricauth/apipassword',
        get_string('apipassword', 'quizaccess_mybiometricauth'),
        get_string('apipassworddesc', 'quizaccess_mybiometricauth'),
        ''
    ));
}
