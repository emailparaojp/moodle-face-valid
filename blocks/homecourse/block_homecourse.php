<?php

defined('MOODLE_INTERNAL') || die();
require_once('locallib.php');
 

class block_homecourse extends block_base {
    public function init() {
        $this->title = get_string('homecourse', 'block_homecourse');

    }
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.
    public function get_content() {
        
        global $USER, $CFG, $DB, $OUTPUT;
       // $this->page->requires->js_call_amd('block_homecourse/slick', 'init');
        
        if ($this->content !== null) {
          return $this->content;
        }
        
        $this->content         =  new stdClass;
        $this->content->text   = 'Content';
        
        if (function_exists('block_my_homecourses')) {
            $html = block_my_homecourses();
            $this->content->text = $html;
        }
        return $this->content; 
    }
     public function applicable_formats(): array {
        return array('all' => true);
    }
}


?>