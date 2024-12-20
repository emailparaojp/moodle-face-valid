<?php

class block_homecourse_edit_form extends block_edit_form {
        
    protected function specific_definition($mform) {
        
        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // A sample string variable with a default value.
        $mform->addElement('text', 'config_text', get_string('blockstring', 'block_homecourse'));
        $mform->setDefault('config_text', 'default value');
        $mform->setType('config_text', PARAM_RAW);        

    }
}