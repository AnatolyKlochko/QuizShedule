<?php

namespace mod_quizschedule\view;

class helper {
    
    public function add_styles( $view, $part ) {
        include \mod_quizschedule\helper::modroot() . "/view/styles/$view/$part.php";
    }
    
    public function add_part( $name, ...$params ) {
        include \mod_quizschedule\helper::modroot() . "/view/$name.php";
    }
    
}
