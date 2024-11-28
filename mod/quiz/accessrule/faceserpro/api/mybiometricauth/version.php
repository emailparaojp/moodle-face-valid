<?php
defined('MOODLE_INTERNAL') || die();

$plugin->component = 'quizaccess_mybiometricauth';
$plugin->version = 2024112600; // Data no formato YYYYMMDDXX.
$plugin->requires = 2022041900; // Moodle 4.5 ou superior.
$plugin->release = '1.0.0';
$plugin->maturity = MATURITY_STABLE;
$plugin->dependencies = array('mod_quiz' => 2022041900);
