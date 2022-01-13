<?php
namespace mod_quizschedule;

defined('MOODLE_INTERNAL') || die(); // throws ERROR or constant 'MOODLE_INTERNAL' is not defined

class access_helper {
    
    private $userid;
    
    // a moodle admin
    private  $is_admin = false;
    
    // the module developer
    private $is_moddev = false;
    
    // learning center
    private $is_lc = false;

    // responsible person
    private $is_rp = false;

    private $is_employee = true;


    /**
     * 
     */
    public function __construct( int $userid ) {
        
        $this->userid = $userid;
        
        $this->init();
        
    }
    
    /**
     * 
     */
    private function init( ) {
        
        $this->is_admin = self::is_admin( $this->userid );
        
        $this->is_moddev = self::is_moddev( $this->userid );
        
        $this->is_lc = self::is_lc( $this->userid );
        
        $this->is_rp = self::is_rp( $this->userid );
        
        $this->is_employee = self::is_employee( $this->userid );
        
    }


    /**
     * @param 
     */
    public function __get( $name ) {
        
        //$roles = get_user_roles(context_course::instance($course->id), $user->id);
        //$x  = get_user_roles_sitewide_accessdata($user->id);
        
        
        if (property_exists( $this, $name ) ) {
            
            return $this->$name;
            
        } else {
            
            return false;
            
        }
     
    }
    
    public static function is_admin( $userid ) {
        
        return is_siteadmin( $userid );
        
    }
    
    public static function is_moddev( $userid ) {
        
        
        
        // temporaty solution, later replace to 'group relation' way
        global $CFG;
        
        $md_list = include( helper::moddatadir() . '/md_list.php' );
                
        foreach ( $md_list as $userarr ) {
            
            if ( $userarr[ 'id' ] == $userid ) {
                
                return true;
                
            }
            
        }
        
        return FALSE;
        
    }
    
    public static function is_lc( $userid ) {
        
        
        
        // temporaty solution, later replace to 'group relation' way
        global $CFG;
        
        $lc_list = include( helper::moddatadir() . '/lc_list.php' );
        
        foreach ( $lc_list as $userarr ) {
            
            if ( $userarr[ 'id' ] == $userid ) {
                
                return true;
                
            }
            
        }
        
        return FALSE;
        
    }
    
    public static function is_rp( $userid ) {
        
        
        
        // temporaty solution, later replace to 'group relation' way
        global $CFG;
        
        $rp_list = include( helper::moddatadir() . '/rp_list.php' );
        
        foreach ( $rp_list as $userarr ) {
            
            if ( $userarr[ 'id' ] == $userid ) {
                
                return true;
                
            }
            
        }
        
        return FALSE;
        
    }
    
    public static function is_employee( $userid ) {
        global $DB;
        
        return
            $DB->record_exists( 'user', [
                'id' => $userid
            ] );

    }
    
    /**
     * 
     */
    public static function is_writer( $userid ) {
        
        if ( self::is_moddev( $userid ) || self::is_lc( $userid ) || self::is_rp($userid) ) {
            
            return true;
            
        }
        
        return false;
    }
    
    /**
     * 
     */
    public static function is_gr_viewer( $userid ) {
        
        if ( self::is_moddev( $userid ) || self::is_lc( $userid ) || self::is_rp($userid) ) {
            
            return true;
            
        }
        
        return false;
    }
    
    /**
     * 
     */
    private static function name_checker($param) {
        
    }

}
