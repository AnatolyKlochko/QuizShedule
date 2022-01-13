<?php
namespace quizschedulemaincommission_group\format;

defined('MOODLE_INTERNAL') || die();

use quizschedulemaincommission_group\base\format\component;
use quizschedulemaincommission_group\format\report\{model, view};
use quizschedulemaincommission_group\format\report\{page, header, body, footer};



/**
 * Data Model Object
 * 
 * Formation Stage
 */
class report extends component {
    
    public function __construct() {
        
        // Model
        $this->molel = new model;
        
        // View
        $this->view = new view;
        
        
        // Components
        $this->component = [];

        // Page
        $this->component[] = new page();
               
        // Header
        $this->component[] = new header();
        
        // Body
        $this->component[] = new body();
                
        // Footer
        $this->component[] = new footer();
        
    }
    
}
//
//class datatable extends \stdClass {
//    
//    /**
//     * Data
//     */
//    
//    /**
//     * @var array Object Array of Employees.
//     */
//    public $employee;
//
//    
//    /**
//     * View Settings
//     */
//    public $headerheight; // to call magic __set()
//    public $headerfont;
//    public $font;
//    
//    // components
//    public $column;
//    public $subcolumn;
//
//
//    public function __construct( ) {
//        
//        // Verifying Raw Data
//        $data = $this->get_data();
//               
//        // Employees
//        $this->init_employees( $data );
//        
//        // Filters
//        // 
//        // Filter 'Double Quotes'
//        $this->filter_doublequotes( [ 'affiliate' ] );
//        // Filter 'Affiliate Number'
//        $this->filter_affiliatenumber( [ 'affiliate' ] );
//        
//        
//        
//        // Header Height, with units
//        $this->headerheight = get_config( 'quizschedulemaincommission_group', 'datatableheaderheight' );
//        // Header Font, whole CSS
//        $this->headerfont = get_config( 'quizschedulemaincommission_group', 'datatableheaderfont' );
//        // Font, whole CSS
//        $this->font = get_config( 'quizschedulemaincommission_group', 'datatablebodyfont' );
//                
//        // Column Definition
//        $this->column = [
//            'numbering' => new column( 'numb' ),            // Numbering
//            'employeeinfo' => new column( 'emplinfo' ),     // Employee Info
//            'sharetype' => new column( 'shrtype' ),         // Share Type
//        ];
//        
//        // Subcolumns, sharetype subcolumns
//        $raw_cfg = get_config( 'quizschedulemaincommission_group', 'datatablecolshrtypesubcols' );
//        
//        if ( $raw_cfg ) {
//            
//            $this->subcolumn = ( new helper )->admin_get_settingarrayassoc( $raw_cfg, ',' );
//            
//        }
//        
//    }
//    
//    private function verifying_data( &$data ) {
//        
//        //...
//        
//        return $data;
//        
//    }
//    
//    private function get_data() {
//        
//        $data = $this->verifying_data( $_POST );
//        
//        return $data;
//        
//    }
//    
//    private function init_employees( array &$data ) {
//        
//        foreach ( $data as $key => $value ) {
//            
//            if ( mb_stripos( $key, 'employee', 0, 'UTF-8' ) !== false ) {
//                
//                if ( isset( $value['fullname'] ) && mb_strlen( $value['fullname'], 'UTF-8' ) > 10 ) {
//                    
//                    $this->employee[] = new employee( $value );
//                    
//                }
//                                
//            }
//            
//        }
//        
//    }
//    
//    
//    /**
//     * Filters
//     */
//    
//    /**
//     * Filter double quotes.
//     * 
//     * Replaces every %DOUBLEQUOTE% word to double quote symbol - ":
//     * АТ %DOUBLEQUOTE%ПОЛТАВАОБЛЕНЕРГО%DOUBLEQUOTE% -> АТ "ПОЛТАВАОБЛЕНЕРГО"
//     */
//    private function filter_doublequotes( array $props ) {
//        
//        $word = get_config( 'quizschedulemaincommission_group', 'datafilterdoublequotes' ); // by default '%DOUBLEQUOTE%'
//        
//        foreach ( $this->employee as $employee ) {
//            
//            foreach ( $props as $prop ) {
//                
//                if ( isset( $employee->{$prop} ) ) {
//                    
//                    $employee->{$prop} = str_replace( $word, '"', $employee->{$prop} );
//                    
//                }
//                
//            }
//            
//        }
//        
//    }
//    
//    /**
//     * Filter 'Affiliate Number'.
//     * 
//     * Replaces every affiliate code to affiliate name:
//     * '0100' -> 'АТ "ПОЛТАВАОБЛЕНЕРГО"'
//     */
//    private function filter_affiliatenumber( array $props ) {
//        
//        $raw_cfg = get_config( 'quizschedulemaincommission_group', 'datafilteraffiliatenumber' );
//        
//        if ( $raw_cfg ) {
//            
//            $affiliatenumber = ( new helper )->admin_get_settingarrayassoc( $raw_cfg, ',' );
//            
//            foreach ( $this->employee as $employee ) {
//            
//                foreach ( $props as $prop ) {
//
//                    if ( isset( $employee->{$prop} ) ) {
//
//                        if ( array_key_exists( $employee->{$prop}, $affiliatenumber ) ) {
//
//                            $employee->{$prop} = $affiliatenumber[ $employee->{$prop} ];
//
//                        }
//
//                    }
//
//                }
//
//            }                    
//            
//        }
//        
//    }
//        
//}
//
//class employee extends \stdClass {
//    
//    public function __construct( $employee ) {
//        
//        $this->id = $employee['id'];
//                
//        $this->fullname = $employee['fullname'];
//
//        $this->affiliate = $employee['affiliate'];
//
//        $this->position = $employee['position'];
//        
//    }
//    
//    public function get_info() {
//        
//        return $this->fullname . '<br />' . $this->position . '<br />' . $this->affiliate;
//        
//    }
//    
//}
//
//class column extends \stdClass {
//    
//    public $key;
//    
//    /**
//     * Displayed name.
//     */
//    public $title;
//    
//    /**
//     * In pixels.
//     */
//    public $width;
//    
//    /**
//     * Whole CSS expression, short tag, like .
//     */
//    public $font;
//    
//    
//    /**
//     * @param string $key Column key to get appropriate settings from admin.
//     */
//    public function __construct( $key ) {
//        
//        $this->key = $key;
//        
//        $this->title = get_config( 'quizschedulemaincommission_group', "datatablecol{$key}title" );
//        
//        $this->width = get_config( 'quizschedulemaincommission_group', "datatablecol{$key}width" );
//        
//        $this->font = get_config( 'quizschedulemaincommission_group', "datatablecol{$key}font" );
//        
//    }
//
//}
