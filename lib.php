<?php
//echo 'mymodule___1';
//include $CFG->dirroot . '/mod/quizschedule/debug/lib.php';

//debug_log( 'Test message at ' . __FILE__, 'global' );


function mod_quizschedule_root( string $submodule = null ) {
    global $CFG;

    
    $root = '';
    
    if ( empty( $submodule ) ) {
        
        $root = $CFG->dirroot . '/mod/quizschedule';
        
    } else {
        
        $root = $CFG->dirroot . '/mod/quizschedule/' . $submodule;
        
    }
    
    
    return $root;
    
}

function mod_quizschedule_before_standard_top_of_body_html() {
    global $PAGE;
    //$PAGE->requires->js_init_code("alert('before_footer');");
    
    $dl_mess = '';
    $dl_mess .= 'Test message at ' . __FILE__ . ', ' . __FUNCTION__ .
        PHP_EOL . PHP_EOL .
        get_class( $PAGE ) .
        PHP_EOL . PHP_EOL;
    
    
    //$m = new moodle_page();
    //$m = block_manager();
    //$x = new block_html();
    //$x = new block();
    
    $blockmanager = $PAGE->blocks;

    $blockmanager->load_blocks(true);
    $dl_mess .= implode( ' - ', $blockmanager->get_regions() ) . PHP_EOL . PHP_EOL;
    
    
    //$missingblocks = self::$BLOCKS_TO_ENSURE_EXIST;
    //$desiredblockpositions = self::$BLOCK_ORDER;
    //$targetblockpositions = array();
    foreach ($blockmanager->get_regions() as $region) {
        
        $dl_mess .= $region . ': ';
        
        foreach ($blockmanager->get_blocks_for_region($region) as $block) {
            $instance = $block->instance;
            
            $dl_mess .= $instance->blockname . ' (' . get_class( $instance ) . '), ';
            
            if ( $instance->blockname === 'html'  ) {
//                $dl_mess .= PHP_EOL . PHP_EOL . var_export( $instance, true);
//                break 2;
                $instance->visible = 0;
            }
            
//            if ($instance->parentcontextid == $context->id && in_array($instance->blockname, self::$BLOCKS_TO_REMOVE)) {
//                blocks_delete_instance($instance);
//                $this->log_action('blockremoved', $this->block_type_name($instance->blockname));
//                continue;
//            }
//
//            if (isset($missingblocks[$instance->blockname])) {
//                unset($missingblocks[$instance->blockname]);
//            } else {
//                if (isset($desiredblockpositions[$instance->blockname])) {
//                    $tempname = $instance->blockname;
//                } else {
//                    $tempname = 'OTHER';
//                }
//                $targetblockpositions[$instance->id] =
//                        array($instance, $desiredblockpositions[$tempname]);
//                $desiredblockpositions[$tempname] += 1;
//            }
        }
        $dl_mess .= PHP_EOL;
    }
    
    //debug_log( $dl_mess );
    
    //$blockmanager->add_block( 'html', 'side-pre', -1, false);
    
    // block_manager has already prepared the blocks in region side-prefor output. It is too late to add a fake block.
//    $bc = new block_contents();
//    $bc->title = 'fake title';
//    $bc->attributes['class'] = 'fakeblock';
//    $bc->content = 'fake content';
//    $PAGE->blocks->add_fake_block($bc, 'side-pre');
}

function mod_quizschedule_before_footer() {
    global $PAGE;
    //$PAGE->requires->js_init_code("alert('before_footer');");
    
    $dl_mess = '';
    $dl_mess .= 'Test message at ' . __FILE__ . ', ' . __FUNCTION__ .
        PHP_EOL . PHP_EOL .
        get_class( $PAGE ) .
        PHP_EOL . PHP_EOL;
    
    
    //$m = new moodle_page();
    //$m = block_manager();
    //$x = new block_html();
    //$x = new block();
    
    $blockmanager = $PAGE->blocks;

    $blockmanager->load_blocks(true);
    $dl_mess .= implode( ' - ', $blockmanager->get_regions() ) . PHP_EOL . PHP_EOL;
    
    
    //$missingblocks = self::$BLOCKS_TO_ENSURE_EXIST;
    //$desiredblockpositions = self::$BLOCK_ORDER;
    //$targetblockpositions = array();
    foreach ($blockmanager->get_regions() as $region) {
        
        $dl_mess .= $region . ': ';
        
        foreach ($blockmanager->get_blocks_for_region($region) as $block) {
            $instance = $block->instance;
            
            $dl_mess .= $instance->blockname . ' (' . get_class( $instance ) . '), ';
            
            if ( $instance->blockname === 'html'  ) {
//                $dl_mess .= PHP_EOL . PHP_EOL . var_export( $instance, true);
//                break 2;
                $instance->visible = 0;
            }
            
//            if ($instance->parentcontextid == $context->id && in_array($instance->blockname, self::$BLOCKS_TO_REMOVE)) {
//                blocks_delete_instance($instance);
//                $this->log_action('blockremoved', $this->block_type_name($instance->blockname));
//                continue;
//            }
//
//            if (isset($missingblocks[$instance->blockname])) {
//                unset($missingblocks[$instance->blockname]);
//            } else {
//                if (isset($desiredblockpositions[$instance->blockname])) {
//                    $tempname = $instance->blockname;
//                } else {
//                    $tempname = 'OTHER';
//                }
//                $targetblockpositions[$instance->id] =
//                        array($instance, $desiredblockpositions[$tempname]);
//                $desiredblockpositions[$tempname] += 1;
//            }
        }
        $dl_mess .= PHP_EOL;
    }
    
    //debug_log( $dl_mess );
    
    //$blockmanager->add_block( 'html', 'side-pre', -1, false);
    
    // block_manager has already prepared the blocks in region side-prefor output. It is too late to add a fake block.
//    $bc = new block_contents();
//    $bc->title = 'fake title';
//    $bc->attributes['class'] = 'fakeblock';
//    $bc->content = 'fake content';
//    $PAGE->blocks->add_fake_block($bc, 'side-pre');
    
}

// + /course/modedit.php, /mod/quiz/view.php, /mod/quiz/edit.php
// - /course/index.php, 
// https://docs.moodle.org/dev/Navigation_API#Course_settings
function mod_quizschedule_extend_navigation_course( navigation_node $parentnode, stdClass $course, context_course $context ) {
    
    //debug_log( 'Test message at ' . __FILE__ . ', ' . __FUNCTION__ );
    //debug_log( '<div>' . __FILE__ . ', ' . __FUNCTION__ . '</div>' . '<div>navigation_node: </div>' . '<pre>' . var_export( $parentnode, true ) . '</pre>' );
    
}

// Doesn't work, because it's 'ONE-TO-ONE' callback
function mod_quizschedule_extend_settings_navigation($settingsnav, $context){
    
    $m = 2;
    $d = 3;
    $x = $settingsnav;
    //debug_log( 'Test message at ' . __FILE__ . ', ' . __FUNCTION__ );
}


function mod_quizschedule_extend_navigation_user_settings() {
    
    //debug_log( 'Test message at ' . __FILE__ . ', ' . __FUNCTION__ );
    
}

// + 
// - /course/modedit.php, /mod/quiz/view.php
function mod_quizschedule_navigation_category_settings() {
    
    //debug_log( 'Test message at ' . __FILE__ . ', ' . __FUNCTION__ );
    
}

// Guests (NOT logged in)
function mod_quizschedule_navigation_frontpage() {
    
    //debug_log( 'Test message at ' . __FILE__ . ', ' . __FUNCTION__ );
    
}

// Logged in users
function mod_quizschedule_navigation_user() {
    
    //debug_log( 'Test message at ' . __FILE__ . ', ' . __FUNCTION__ );
    
}
