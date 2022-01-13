<?php

//defined('MOODLE_INTERNAL') || die();


namespace mod_quizschedule\output;

class index_renderer {
    
    private $data;
        
    public function display( array &$d ) {
        global $PAGE, $OUTPUT;
        
        $this->data = &$d;
        
        $url = new \moodle_url('/mod/quizschedule/index.php', []);
        $PAGE->set_url($url);
        $PAGE->set_pagelayout('report');
        $PAGE->set_title( get_string( 'pluginname', 'quizschedule' ) );
        $PAGE->set_heading( get_string( 'pluginname', 'quizschedule' ) );

        echo $OUTPUT->header();
        
        
        $aco = $d['user_groups'];
        
        if ( $aco->is_lc || $aco->is_moddev) {
            
            self::display_navigation();
            
        }
        
        self::display_search();
        
        $this->display_schedule();
    }
    public static function display_navigation() {
        include \mod_quizschedule\helper::modroot() . '/view/navigation.php';
    }
    public static function display_search(){
        include \mod_quizschedule\helper::modroot() . '/view/search.php';
    }
    private function display_schedule(){
        // View Data
        $schedule = &$this->data['employee_schedule'];
        // Display View
        include \mod_quizschedule\helper::modroot() . '/view/schedule.php';
    }
}
