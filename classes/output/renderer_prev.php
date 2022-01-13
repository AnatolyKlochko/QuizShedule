<?php

namespace mod_quizschedule\output;
defined('MOODLE_INTERNAL') || die();

use mod_quizschedule\model\row;
use \mod_quizschedule\helper;
use \mod_quizschedule\view\helper as vhelper;
use \mod_quizschedule\view\report_helper as rhelper;

class renderer {
    
    const MISSED_EXAM = 'missed_exam';
    
    /**
     * Report Data.
     */
    private $report;
    
    /**
     * Helpers
     */
    private $helper;
    private $vhelper;
    private $rhelper;


    /**
     * Header Elements Tags
     */
    private $hrow_tag = 'tr';
    private $hcol_tag = 'th';
    private $hcolwrap_tag = 'div';
    private $hcol_class = 'rh-col'; // ReportHeader-Column
    private $hcolwrap_class = 'rh-col-wrapper'; // ReportHeader-Column-Wrapper
    
    /**
     * Content Elements Tags
     */
    private $row_tag = 'tr';
    private $col_tag = 'td';
    private $colwrap_tag = 'div';
    private $col_class = 'r-col'; // ReportColumn
    private $colwrap_class = 'r-col-wrapper'; // ReportColumn-Wrapper
    
    
    
    public function __construct( ) {
        
        $this->helper = new helper();
        
        $this->vhelper = new vhelper();
        
        $this->rhelper = new rhelper();
        
    }
    
    /**
     * Helpers.
     */
    
    /**
     * 
     */
    private static function get_rowclassattr( row $row, ...$classes ) : string {
        
        $classattr = ' class="';
        
        if ( self::is_active( $row ) ) {
            
            if ( self::is_active_today( $row ) ) {
                
                $classattr .= 'table-success';
                
            }
                        
        } else {
            
            $classattr .= 'table-danger';
            
        }
        
        
        // 
        if ( ! empty( $classes ) )
            $classattr .= ' ' . implode( ' ', $classes );
        
        
        $classattr .= '"';
        
        return $classattr;
        
    }

    /**
     * 
     */
    private static function multicol_init_empty( ) {
        
        return [ 
            'plan' => '', 
            'fact' => '', 
            'next' => '' 
        ];
        
    }
    
    /**
     * 
     */
    private static function is_active( row $row ) : bool {
        
        foreach ( $row->columns as $column ) {
            
            if ( isset( $column['object'] ) && isset( $column['object']->is_active ) ) {
                
                return $column['object']->is_active;
                
            }
            
        }
        
        // By default make row as active.
        return true;
        
    }
    
    /**
     * Note: default value returning by is_active is equal TRUE.
     */
    private static function is_active_today( row $row ) : bool {
        
        foreach ( $row->columns as $column ) {
            
            if ( isset( $column['next'] ) && ! empty( $column['next'] ) ) {
                
                $daysleft = intval( floor( ( time() - strtotime( $column['next'] ) ) / 3600 / 24 ) );
                
                return $daysleft === 0;
                
            }
            
        }
        
        // By default make row as not active today.
        return false;
        
    }
    
    /**
     * 
     * @param array $column_value An array with keys 'next', 'object'.
     */
    private static function coltagattr_missedexam( $column_value ) {
        
        // HTML Options
        
        // Popover Options
        $data_toggle = 'popover';
        
        $data_trigger = 'click';
        
        $data_placement = 'left';
        
        
        // Nearest Schedule
        $nearestschedulepoint = self::coltagattr_missedexam_quizpointhtml( $column_value['next'], $column_value['object'] );
        
        // Schedule List
        $data_content = '';
        
        if ( $column_value['list'] ) {
            foreach ( $column_value['list'] as $point ) {
                $data_content = self::coltagattr_missedexam_quizpointhtml( $point->datenextquiz, $point ) . $data_content;
            }
        }
        
        // Merge
        $data_content .= $nearestschedulepoint;
                
        // Tag Attributes string
        $attrstr = 'data-toggle="'.$data_toggle.'" data-trigger="'.$data_trigger.'" data-placement="'.$data_placement.'"';
                
        // Data
        $data = '<popover>'.$data_content.'</popover>';
        
        
        return [
            'attrs' => $attrstr,
            'data' => $data
        ];
        
    }
    
    private static function coltagattr_missedexam_quizpointarr( $nextdate ) {
        $msdiff = time() - strtotime( $nextdate );
        $msfloor = floor( ( $msdiff ) / 3600 / 24 );
        $daysleft = intval( $msfloor );
        
        if ( $daysleft < 0 ) {
            
            $daysleft = '+' . abs( $daysleft );
            
            $daysword = get_string( 'report_daysbeforeword', 'quizschedule' );
            
        } elseif ( $daysleft === 0 ) {
            
            $daysleft = '';
            
            $daysword = get_string( 'report_todayquizword', 'quizschedule' );
            
        } elseif ( $daysleft > 0 ) {
            
            $daysleft = '-' . abs( $daysleft );
            
            $daysword = get_string( 'report_daysword', 'quizschedule' );
            
        }
        
        return [ $daysleft, $daysword ];
    }
    
    private static function coltagattr_missedexam_quizpointhtml( $nextdate, $schedulepoint ) {
        
        // Compute days count before or after Quiz
        list( $daysleft, $daysword ) = self::coltagattr_missedexam_quizpointarr( $nextdate );
        
        // Check if current user is LC or RP, and give it ability change Schedule
        // data or print reports
        $toolbox_html = self::coltagattr_missedexam_toolboxhtml( $schedulepoint );
        
        // Whole Schedule Point HTML
        $quizpointhtml = '
            <div class="schedulepoint-wrapper">
                <div class="days-wrapper">
                    <span class="left">'.$daysleft.'</span>&nbsp<span class="word">'.$daysword.'</span>
                </div>
                <div class="quiz-name-wrapper">
                    <span class="title">'.$schedulepoint->quizname.'</span>
                </div>' .
                $toolbox_html . '
            </div>';
        
        return $quizpointhtml;
    }
    
    private static function coltagattr_missedexam_toolboxhtml( $schedulepoint ) {
        
        $html = '';
        
        if ( 0 ) {
            
            $html = ' 
                <div class="toolbox-wrapper">
                    
                </div>
            ';
            
        }
                
        
        return $html;
        
    }
    
    /**
     * 
     * 
     * @param string $key Column key. For example 'occupational_health'.
     * @param string $subkey Sub column key. For example 'subcol_C'.
     */
    private static function get_coltagattrs( $key, $subkey, $row ) {
        
        $handler = 'get_coltagattrs_' . $key . ( empty( $subkey ) ? '' : "_$subkey" );
        
        if ( method_exists( new self, $handler ) ) {
            
            return self::$handler( $row );
            
        }
        
    }
    
    private static function add_coltagattrs( array &$total, array $data ) {
        
        $total['attrs'] .= $data['attrs'];
        
        $total['data'] .= $data['data'];
        
    }
    
    /**
     * Returns array with additional html-attributes (as a string) for column tag for sub 
     * column 'subcol_C' of 'occupational_health' column and a data as HTML-string (for JS script).
     * 
     * @param mixed $value A static column/cell value or column object stdClass.
     */
    private static function get_coltagattrs_occupational_health_subcol_C( $row ) {
        
        // Column Value
        $column_value = &$row->columns[ 'occupational_health' ];
        
        // Tag Attributes array
        $attrsarray = [
            'attrs' => '',  // tag attributes string
            'data' => ''    // HTML string (a data as HTML tags)
        ];
        
        // Returns info about how many days left and Quiz Name
        $data = self::coltagattr_missedexam( $column_value );
        // Add to aggregated array
        self::add_coltagattrs( $attrsarray, $data );
        
        
        return $attrsarray;
        
    }
    
    /**
     * Returns array with additional html-attributes (as a string) for column tag for sub 
     * column 'subcol_C' of 'occupational_health' column and a data as HTML-string (for JS script).
     * 
     * @param mixed $value A static column/cell value or column object stdClass.
     */
    private static function get_coltagattrs_technology_works_subcol_C( $row ) {
        
        // Column Value
        $column_value = &$row->columns[ 'technology_works' ];
        
        // Tag Attributes array
        $attrsarray = [
            'attrs' => '',  // tag attributes string
            'data' => ''    // HTML string (a data as HTML tags)
        ];
        
        
        // 1. Returns info about how many days left and Quiz Name
        $data = self::coltagattr_missedexam( $column_value );
        
        // Add to aggregated array
        self::add_coltagattrs( $attrsarray, $data );
        
        
        // 2.
        // ...
        
        
        return $attrsarray;
        
    }
    
    /**
     * Returns array with additional html-attributes (as a string) for column tag for sub 
     * column 'subcol_C' of 'occupational_health' column and a data as HTML-string (for JS script).
     * 
     * @param mixed $value A static column/cell value or column object stdClass.
     */
    private static function get_coltagattrs_fire_safety_rules_subcol_C( $row ) {
        
        // Column Value
        $column_value = &$row->columns[ 'fire_safety_rules' ];
        
        // Tag Attributes array
        $attrsarray = [
            'attrs' => '',  // tag attributes string
            'data' => ''    // HTML string (a data as HTML tags)
        ];
        
        
        // 1. Returns info about how many days left and Quiz Name
        $data = self::coltagattr_missedexam( $column_value );
        
        // Add to aggregated array
        self::add_coltagattrs( $attrsarray, $data );
        
        
        // 2.
        // ...
        
        
        return $attrsarray;
        
    }
    
    /**
     * Returns array with additional html-attributes (as a string) for column tag for sub 
     * column 'subcol_C' of 'occupational_health' column and a data as HTML-string (for JS script).
     * 
     * @param mixed $value A static column/cell value or column object stdClass.
     */
    private static function get_coltagattrs_safe_operation_of_lifts_subcol_C( $row ) {
        
        // Column Value
        $column_value = &$row->columns[ 'safe_operation_of_lifts' ];
        
        // Tag Attributes array
        $attrsarray = [
            'attrs' => '',  // tag attributes string
            'data' => ''    // HTML string (a data as HTML tags)
        ];
        
        
        // 1. Returns info about how many days left and Quiz Name
        $data = self::coltagattr_missedexam( $column_value );
        
        // Add to aggregated array
        self::add_coltagattrs( $attrsarray, $data );
        
        
        // 2.
        // ...
        
        
        return $attrsarray;
        
    }
    
    /**
     * Returns array with additional html-attributes (as a string) for column tag for sub 
     * column 'subcol_C' of 'occupational_health' column and a data as HTML-string (for JS script).
     * 
     * @param mixed $value A static column/cell value or column object stdClass.
     */
    private static function get_coltagattrs_safe_operation_of_cranes_subcol_C( $row ) {
        
        // Column Value
        $column_value = &$row->columns[ 'safe_operation_of_cranes' ];
        
        // Tag Attributes array
        $attrsarray = [
            'attrs' => '',  // tag attributes string
            'data' => ''    // HTML string (a data as HTML tags)
        ];
        
        
        // 1. Returns info about how many days left and Quiz Name
        $data = self::coltagattr_missedexam( $column_value );
        
        // Add to aggregated array
        self::add_coltagattrs( $attrsarray, $data );
        
        
        // 2.
        // ...
        
        
        return $attrsarray;
        
    }
    
    
    
    /**
     * 
     */
    public function display( array &$report ) {
        global $PAGE, $OUTPUT, $CFG;
        
        
        
        $this->report = &$report;
        
        $url = new \moodle_url('/mod/quizschedule/report.php', []);
        $PAGE->set_url($url);
        $PAGE->set_pagelayout('report');
                
        
        
        // CSS
        //   
        // Libraries
        //
        // Bootstrap
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/bootstrap/4.0.0/css/bootstrap.min.css' ) );
        // Iconic
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/iconic/1.1.0/font/css/open-iconic-bootstrap.min.css' ) );
        // basictable
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/basictable/1.0.9/basictable.css' ) );
        // dataTables
        //$PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/css/jquery.dataTables.min.css' ) );
        //$PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/datatables.min.css' ) ); // NOT WORK. work
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/dataTables.bootstrap4.min.css' ) ); // NO EFFECT
        //     
        // Custom CSS
        $PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/report/report.css' ) );
        
        
        
        // JS
        // 
        // Libraries
        // 
        // jQuery
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/3.4.1/jquery-3.4.1.min.js' ), true );
        $PAGE->requires->jquery();
        // Bootstrap
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/bootstrap/4.0.0/js/bootstrap.min.js' ) );
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/bootstrap/4.0.0/js/bootstrap.bundle.min.js' ), true );
        // dataTables
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/datatables.min.js' ), true ); // NOT WORK. work
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/js/jquery.dataTables.min.js' ), true );
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/1.10.19/dataTables.bootstrap4.min.js' ), true ); // NO EFFECT
        // DataTables Extentions
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/extentions/fixedHeader/3.1.5/dataTables.fixedHeader.min.js' ), true );
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatables/extentions/responsive/2.2.3/dataTables.responsive.min.js' ), true );
        // jQuery UI
        //$PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/ui/1.12.1/themes/base/jquery-ui.min.css' ) );
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/ui/1.12.1/jquery-ui.min.js' ), true );
        // 
        // basictable
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/basictable/1.0.9/jquery.basictable.min.js' ), true );
        // Custom scripts
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/datatable.options.js' ), true );
        $PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/report.js' ) );
        
        
        // JS
        // 
        // Libraries
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/3.4.1/jquery-3.4.1.min.js' ), true );
        // 
        // Custom scripts
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/jquery/report.js' ) );
        
        // CSS
        //   
        // Libraries
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/bootstrap/4.0.0/js/bootstrap.bundle.min.js' ), true );
        //$PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/bootstrap/4.0.0/css/bootstrap.min.css' ) );
        //$PAGE->requires->js( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/bootstrap/4.0.0/js/bootstrap.min.js' ) );
        //     
        // Custom CSS
        //$PAGE->requires->css( new \moodle_url( $CFG->wwwroot . '/mod/quizschedule/styles/report/report.css' ) );
        
        
        
        
        // Page
        $PAGE->set_title( get_string( 'report_title', 'quizschedule' ) );
        $PAGE->set_heading( get_string( 'report_title', 'quizschedule' ) );

        echo $OUTPUT->header();
        
        $this->display_report();
        
    }
    
    /**
     * 
     */
    private function display_report() {
                 
        // Display View
        include helper::modroot() . '/view/report.php';
        
    }
    
    
    /**
     * Header
     */
    
    /**
     * 
     */
    private function output_header() {
        
        $rowtag = $this->hrow_tag;
        
        $rows = [
            1 => 'upper',
            2 => 'middle',
            3 => 'bottom',
        ];
        
        $columns = rhelper::get_columns();
        
        // Header rows
        foreach ( $rows as $row ) {
            
            echo '<'.$rowtag.'>';
            
            // Header columns
            foreach ( $columns as $column ) {

                $this->output_header_col( $row, $column );

            }
            
            echo '</'.$rowtag.'>';
            
        }
        
        
    }
    
    /**
     * Wrapper / Mapper to output a particular Header column.
     */
    private function output_header_col( $row, $column ) {
        
        $handler = "output_header_col_{$column->key}";
        
        $this->$handler( $row, $column );
        
    }
    
    /**
     * Header Column 'Numbering'.
     */
    private function output_header_col_numbering( $row, $column ) {
        
        if ( $row === 'upper' ) {
            
            $tag = $this->hcol_tag;
        
            $class = $this->hcol_class;

            $wrap = $this->hcolwrap_tag;

            $wrapclass = $this->hcolwrap_class;

            echo '<'.$tag.' rowspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
            
        }
                
    }
    
    /**
     * Header Column 'Affiliate'.
     */
    private function output_header_col_affiliate( $row, $column) {
        
        if ( $row === 'upper' ) {
            
            $tag = $this->hcol_tag;
        
            $class = $this->hcol_class;

            $wrap = $this->hcolwrap_tag;

            $wrapclass = $this->hcolwrap_class;

            echo '<'.$tag.' rowspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
            
        }
        
    }
    
    /**
     * Header Column 'Employee Number'.
     */
    private function output_header_col_employee_number( $row, $column) {
        
        if ( $row === 'upper' ) {
            
            $tag = $this->hcol_tag;
        
            $class = $this->hcol_class;

            $wrap = $this->hcolwrap_tag;

            $wrapclass = $this->hcolwrap_class;

            echo '<'.$tag.' rowspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
            
        }
        
    }
    
    /**
     * Header Column 'Full Name'.
     */
    private function output_header_col_fullname( $row, $column) {
        
        if ( $row === 'upper' ) {
            
            $tag = $this->hcol_tag;
        
            $class = $this->hcol_class;

            $wrap = $this->hcolwrap_tag;

            $wrapclass = $this->hcolwrap_class;

            echo '<'.$tag.' rowspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
            
        }
        
    }
    
    /**
     * Header Column 'Position'.
     */
    private function output_header_col_position( $row, $column) {
        
        if ( $row === 'upper' ) {
            
            $tag = $this->hcol_tag;
        
            $class = $this->hcol_class;

            $wrap = $this->hcolwrap_tag;

            $wrapclass = $this->hcolwrap_class;

            echo '<'.$tag.' rowspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
            
        }
        
    }
    
    /**
     * Header Column 'Group of Electrical Safety'.
     */
    private function output_header_col_group_of_electrical_safety( $row, $column) {
        
        if ( $row === 'upper' ) {
            
            $tag = $this->hcol_tag;
        
            $class = $this->hcol_class;

            $wrap = $this->hcolwrap_tag;

            $wrapclass = $this->hcolwrap_class;

            echo '<'.$tag.' rowspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
            
        }
        
    }
        
    /**
     * Header Column 'Occupational Health'.
     */
    private function output_header_col_occupational_health( $row, $column) {
        
        $tag = $this->hcol_tag;
        
        $class = $this->hcol_class;
        
        $wrap = $this->hcolwrap_tag;
        
        $wrapclass = $this->hcolwrap_class;
        
        
        if ( $row === 'upper' ) {
            
            echo
                '<'.$tag.' colspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        '<div class="upper">'.
                            get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                        '</div>' . 
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
        }
        
        if ( $row === 'middle' ) {
            
            echo
                '<'.$tag.' colspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        '<div class="middle">'.
                            get_string( 'report_hcol_short_'.$column->key, 'quizschedule' ) .
                        '</div>' . 
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
        }
        
        if ( $row === 'bottom' ) {
            
            echo 
            '<'.$tag.' class="'.$class.' rh-col-subcol-A rh-col-subcol-A-'.$column->key.'">'.get_string( 'report_hcol_subcol_A', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-B rh-col-subcol-B-'.$column->key.'">'.get_string( 'report_hcol_subcol_B', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-C rh-col-subcol-C-'.$column->key.'">'.get_string( 'report_hcol_subcol_C', 'quizschedule' ).'</'.$tag.'>';
            
        }
                
    }
    
    /**
     * Header Column 'Technology Works'.
     */
    private function output_header_col_technology_works( $row, $column) {
        
        $tag = $this->hcol_tag;
        
        $class = $this->hcol_class;
        
        $wrap = $this->hcolwrap_tag;
        
        $wrapclass = $this->hcolwrap_class;
        
        if ( $row === 'upper' ) {
            
            echo
                '<'.$tag.' colspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        '<div class="upper">'.
                            get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                        '</div>' . 
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
        }
        
        if ( $row === 'middle' ) {
            
            echo
                '<'.$tag.' colspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        '<div class="middle">'.
                            get_string( 'report_hcol_short_'.$column->key, 'quizschedule' ) .
                        '</div>' . 
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
        }
        
        if ( $row === 'bottom' ) {
            
            echo 
            '<'.$tag.' class="'.$class.' rh-col-subcol-A rh-col-subcol-A-'.$column->key.'">'.get_string( 'report_hcol_subcol_A', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-B rh-col-subcol-B-'.$column->key.'">'.get_string( 'report_hcol_subcol_B', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-C rh-col-subcol-C-'.$column->key.'">'.get_string( 'report_hcol_subcol_C', 'quizschedule' ).'</'.$tag.'>';
            
        }
        
    }
    
    /**
     * Header Column 'Fire Safety Rules'.
     */
    private function output_header_col_fire_safety_rules( $row, $column) {
        
        $tag = $this->hcol_tag;
        
        $class = $this->hcol_class;
        
        $wrap = $this->hcolwrap_tag;
        
        $wrapclass = $this->hcolwrap_class;
        
        if ( $row === 'upper' ) {
            
            echo
                '<'.$tag.' colspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        '<div class="upper">'.
                            get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                        '</div>' . 
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
        }
        
        if ( $row === 'middle' ) {
            
            echo
                '<'.$tag.' colspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        '<div class="middle">'.
                            get_string( 'report_hcol_short_'.$column->key, 'quizschedule' ) .
                        '</div>' . 
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
        }
        
        if ( $row === 'bottom' ) {
            
            echo 
            '<'.$tag.' class="'.$class.' rh-col-subcol-A rh-col-subcol-A-'.$column->key.'">'.get_string( 'report_hcol_subcol_A', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-B rh-col-subcol-B-'.$column->key.'">'.get_string( 'report_hcol_subcol_B', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-C rh-col-subcol-C-'.$column->key.'">'.get_string( 'report_hcol_subcol_C', 'quizschedule' ).'</'.$tag.'>';
            
        }
        
    }
    
    /**
     * Header Column 'Safe Operation of Lifts'.
     */
    private function output_header_col_safe_operation_of_lifts( $row, $column) {
        
        $tag = $this->hcol_tag;
        
        $class = $this->hcol_class;
        
        $wrap = $this->hcolwrap_tag;
        
        $wrapclass = $this->hcolwrap_class;
        
        if ( $row === 'upper' ) {
            
            echo
                '<'.$tag.' rowspan="2" colspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        '<div class="upper">'.
                            get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                        '</div>' . 
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
        }
        
//        if ( $row === 'middle' ) {
//            
//            echo
//                '<'.$tag.' colspan="3" class="'.$class.' hcol-'.$column->key.'">' . 
//                    '<'.$wrap.' class="'.$wrapclass.'">'.
//                        '<div class="middle">'.
//                            get_string( 'report_hcol_short_'.$column->key, 'quizschedule' ) .
//                        '</div>' . 
//                    '</'.$wrap.'>' . 
//                '</'.$tag.'>';
//        }
        
        if ( $row === 'bottom' ) {
            
            echo 
            '<'.$tag.' class="'.$class.' rh-col-subcol-A rh-col-subcol-A-'.$column->key.'">'.get_string( 'report_hcol_subcol_A', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-B rh-col-subcol-B-'.$column->key.'">'.get_string( 'report_hcol_subcol_B', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-C rh-col-subcol-C-'.$column->key.'">'.get_string( 'report_hcol_subcol_C', 'quizschedule' ).'</'.$tag.'>';
            
        }
        
    }
    
    /**
     * Header Column 'Safe Operation of Cranes'.
     */
    private function output_header_col_safe_operation_of_cranes( $row, $column) {
        
        $tag = $this->hcol_tag;
        
        $class = $this->hcol_class;
        
        $wrap = $this->hcolwrap_tag;
        
        $wrapclass = $this->hcolwrap_class;
        
        if ( $row === 'upper' ) {
            
            echo
                '<'.$tag.' rowspan="2" colspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        '<div class="upper">'.
                            get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                        '</div>' . 
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
        }
        
//        if ( $row === 'middle' ) {
//            
//            echo
//                '<'.$tag.' colspan="3" class="'.$class.' hcol-'.$column->key.'">' . 
//                    '<'.$wrap.' class="'.$wrapclass.'">'.
//                        '<div class="middle">'.
//                            get_string( 'report_hcol_short_'.$column->key, 'quizschedule' ) .
//                        '</div>' . 
//                    '</'.$wrap.'>' . 
//                '</'.$tag.'>';
//        }
        
        if ( $row === 'bottom' ) {
            
            echo 
            '<'.$tag.' class="'.$class.' rh-col-subcol-A rh-col-subcol-A-'.$column->key.'">'.get_string( 'report_hcol_subcol_A', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-B rh-col-subcol-B-'.$column->key.'">'.get_string( 'report_hcol_subcol_B', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-C rh-col-subcol-C-'.$column->key.'">'.get_string( 'report_hcol_subcol_C', 'quizschedule' ).'</'.$tag.'>';
            
        }
        
    }
    
    /**
     * Header Column 'Physical Examination'.
     */
    private function output_header_col_physical_examination( $row, $column) {
        
        $tag = $this->hcol_tag;
        
        $class = $this->hcol_class;
        
        $wrap = $this->hcolwrap_tag;
        
        $wrapclass = $this->hcolwrap_class;
        
        if ( $row === 'upper' ) {
            
            echo
                '<'.$tag.' rowspan="2" colspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        '<div class="upper">'.
                            get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                        '</div>' . 
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
        }
        
//        if ( $row === 'middle' ) {
//            
//            echo
//                '<'.$tag.' colspan="3" class="'.$class.' hcol-'.$column->key.'">' . 
//                    '<'.$wrap.' class="'.$wrapclass.'">'.
//                        '<div class="middle">'.
//                            get_string( 'report_hcol_short_'.$column->key, 'quizschedule' ) .
//                        '</div>' . 
//                    '</'.$wrap.'>' . 
//                '</'.$tag.'>';
//        }
        
        if ( $row === 'bottom' ) {
            
            echo 
            '<'.$tag.' class="'.$class.' rh-col-subcol-A rh-col-subcol-A-'.$column->key.'">'.get_string( 'report_hcol_subcol_A', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-B rh-col-subcol-B-'.$column->key.'">'.get_string( 'report_hcol_subcol_B', 'quizschedule' ).'</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' rh-col-subcol-C rh-col-subcol-C-'.$column->key.'">'.get_string( 'report_hcol_subcol_C', 'quizschedule' ).'</'.$tag.'>';
            
        }
        
    }
    
    /**
     * Header Column 'Commission Type'.
     */
    private function output_header_col_commission_type( $row, $column) {
        
        if ( $row === 'upper' ) {
            
            $tag = $this->hcol_tag;
        
            $class = $this->hcol_class;

            $wrap = $this->hcolwrap_tag;

            $wrapclass = $this->hcolwrap_class;

            echo '<'.$tag.' rowspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
            
        }
        
    }
    
    /**
     * Header Column 'Notes'.
     */
    private function output_header_col_notes( $row, $column) {
        
        if ( $row === 'upper' ) {
            
            $tag = $this->hcol_tag;
        
            $class = $this->hcol_class;

            $wrap = $this->hcolwrap_tag;

            $wrapclass = $this->hcolwrap_class;

            echo '<'.$tag.' rowspan="3" class="'.$class.' rh-col-'.$column->key.'">' . 
                    '<'.$wrap.' class="'.$wrapclass.'">'.
                        get_string( 'report_hcol_'.$column->key, 'quizschedule' ).
                    '</'.$wrap.'>' . 
                '</'.$tag.'>';
            
        }
        
    }
    
    
    /**
     * Content
     */
    
    /**
     * 
     */
    private function output_content() {
        
        $rowtag = $this->row_tag;
                
        
        $columns = rhelper::get_columns();
        
        // Report rows
        foreach ( $this->report as $row ) {
            
            echo '<'.$rowtag . ' ' . self::get_rowclassattr( $row ) .'>'; // Example get_rowclassattr( $row, 'classA', 'classB' )
            
            // Report columns
            foreach ( $columns as $column ) {

                $this->output_col( $row, $column );

            }
            
            echo '</'.$rowtag.'>';
            
        }
        
        
    }
    
    /**
     * Wrapper / Mapper to output a particular column.
     */    
    private function output_col( &$row, &$column ) {
        
        $handler = "output_col_{$column->key}";
        
        $this->$handler( $row, $column );
        
    }
    
    /**
     * Column 'Numbering'.
     */
    private function output_col_numbering( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;

        echo '<'.$tag.' class="'.$class.' r-col-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $row->columns[ $column->key ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Affiliate'.
     */
    private function output_col_affiliate( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;
        
        $val = $row->columns[ $column->key ];
        
        // Filters
        
        // -if val is equal to "АТ "ПОЛТАВАОБЛЕНЕРГО"" then add &nbsp to.
        if ( $val === "АТ \"ПОЛТАВАОБЛЕНЕРГО\"" ) {
            
            $valarr = explode( ' ', $val );
            
            $val = $valarr[0] . '&nbsp' . $valarr[1];
            
        }

        echo '<'.$tag.' class="'.$class.' r-col-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $val .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Employee Number'.
     */
    private function output_col_employee_number( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;

        echo '<'.$tag.' class="'.$class.' r-col-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $row->columns[ $column->key ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Full Name'.
     */
    private function output_col_fullname( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;

        echo '<'.$tag.' class="'.$class.' r-col-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $row->columns[ $column->key ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Position'.
     */
    private function output_col_position( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;

        echo '<'.$tag.' class="'.$class.' r-col-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $row->columns[ $column->key ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Group of Electrical Safety'.
     */
    private function output_col_group_of_electrical_safety( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;

        echo 
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $row->columns[ $column->key ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Occupational Health'.
     */
    private function output_col_occupational_health( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;
        $class_colC = '';

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;
        
        if ( isset( $row->columns[ $column->key ] ) ) {
            
            // Column value ( Column array )
            $value = $row->columns[ $column->key ];
            
            // Date Format 'd.m.Y' instead 'Y-m-d'
            if ( isset( $value[ 'plan' ] ) ) {
                
                $value[ 'plan' ] = date( 'd.m.Y', strtotime( $value[ 'plan' ] ) );
                
            }
            if ( isset( $value[ 'fact' ] ) ) {
                
                $value[ 'fact' ] = date( 'd.m.Y', strtotime( $value[ 'fact' ] ) );
                
            }
            if ( isset( $value[ 'next' ] ) ) {
                
                $value[ 'next' ] = date( 'd.m.Y', strtotime( $value[ 'next' ] ) );
                
            }
            
            // Sub Column C tag attributes
            if ( isset( $value['object'] ) ) {
                
                $attrarray = self::get_coltagattrs( 'occupational_health', 'subcol_C', $row );
                
                $subcolC_tagattrs = $attrarray[ 'attrs' ];
                
                $subcolC_data = $attrarray[ 'data' ];
                
                // Change curson if data is present
                $class_colC .= ' ondata-cursor ';
                
            }
            
        } else {
            
            $value = self::multicol_init_empty();
            
            $subcolC_tagattrs = '';
            
            $subcolC_data = '';
            
        }
        
        echo
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-A r-col-subcol-A-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'plan' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-B r-col-subcol-B-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'fact' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.$class_colC.' r-col-'.$column->key.' r-col-subcol-C r-col-subcol-C-'.$column->key.'" '.$subcolC_tagattrs.'>' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'next' ] .
                '</'.$wrapper.'>' . 
                '<data class="hidden">'.$subcolC_data.'</data>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Technology Works'.
     */
    private function output_col_technology_works( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;
        $class_colC = '';

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;
        
        if ( isset( $row->columns[ $column->key ] ) ) {
            
            // Column value ( Column array )
            $value = $row->columns[ $column->key ];
            
            // Date Format 'd.m.Y' instead 'Y-m-d'
            if ( isset( $value[ 'plan' ] ) ) {
                
                $value[ 'plan' ] = date( 'd.m.Y', strtotime( $value[ 'plan' ] ) );
                
            }
            if ( isset( $value[ 'fact' ] ) ) {
                
                $value[ 'fact' ] = date( 'd.m.Y', strtotime( $value[ 'fact' ] ) );
                
            }
            if ( isset( $value[ 'next' ] ) ) {
                
                $value[ 'next' ] = date( 'd.m.Y', strtotime( $value[ 'next' ] ) );
                
            }
            
            // Sub Column C tag attributes
            if ( isset( $value['object'] ) ) {
                
                $attrarray = self::get_coltagattrs( 'technology_works', 'subcol_C', $row );
                
                $subcolC_tagattrs = $attrarray[ 'attrs' ];
                
                $subcolC_data = $attrarray[ 'data' ];
                
                // Change curson if data is present
                $class_colC .= ' ondata-cursor ';
                
            }
            
        } else {
            
            $value = self::multicol_init_empty();
            
            $subcolC_tagattrs = '';
            
            $subcolC_data = '';
            
        }
        
        echo
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-A r-col-subcol-A-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'plan' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-B r-col-subcol-B-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'fact' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.$class_colC.' r-col-'.$column->key.' r-col-subcol-C r-col-subcol-C-'.$column->key.'" '.$subcolC_tagattrs.'>' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'next' ] .
                '</'.$wrapper.'>' . 
                '<data class="hidden">'.$subcolC_data.'</data>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Fire Safety Rules'.
     */
    private function output_col_fire_safety_rules( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;
        $class_colC = '';

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;
        
        if ( isset( $row->columns[ $column->key ] ) ) {
            
            // Column value ( Column array )
            $value = $row->columns[ $column->key ];
            
            // Date Format 'd.m.Y' instead 'Y-m-d'
            if ( isset( $value[ 'plan' ] ) ) {
                
                $value[ 'plan' ] = date( 'd.m.Y', strtotime( $value[ 'plan' ] ) );
                
            }
            if ( isset( $value[ 'fact' ] ) ) {
                
                $value[ 'fact' ] = date( 'd.m.Y', strtotime( $value[ 'fact' ] ) );
                
            }
            if ( isset( $value[ 'next' ] ) ) {
                
                $value[ 'next' ] = date( 'd.m.Y', strtotime( $value[ 'next' ] ) );
                
            }
            
            // Sub Column C tag attributes
            if ( isset( $value['object'] ) ) {
                
                $attrarray = self::get_coltagattrs( 'fire_safety_rules', 'subcol_C', $row );
                
                $subcolC_tagattrs = $attrarray[ 'attrs' ];
                
                $subcolC_data = $attrarray[ 'data' ];
                
                // Change curson if data is present
                $class_colC .= ' ondata-cursor ';
                
            }
            
        } else {
            
            $value = self::multicol_init_empty();
            
            $subcolC_tagattrs = '';
            
            $subcolC_data = '';
            
        }
        
        echo
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-A r-col-subcol-A-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'plan' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-B r-col-subcol-B-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'fact' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.$class_colC.' r-col-'.$column->key.' r-col-subcol-C r-col-subcol-C-'.$column->key.'" '.$subcolC_tagattrs.'>' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'next' ] .
                '</'.$wrapper.'>' . 
                '<data class="hidden">'.$subcolC_data.'</data>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Safe Operation of Lifts'.
     */
    private function output_col_safe_operation_of_lifts( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;
        $class_colC = '';

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;
        
        if ( isset( $row->columns[ $column->key ] ) ) {
            
            // Column value ( Column array )
            $value = $row->columns[ $column->key ];
            
            // Date Format 'd.m.Y' instead 'Y-m-d'
            if ( isset( $value[ 'plan' ] ) ) {
                
                $value[ 'plan' ] = date( 'd.m.Y', strtotime( $value[ 'plan' ] ) );
                
            }
            if ( isset( $value[ 'fact' ] ) ) {
                
                $value[ 'fact' ] = date( 'd.m.Y', strtotime( $value[ 'fact' ] ) );
                
            }
            if ( isset( $value[ 'next' ] ) ) {
                
                $value[ 'next' ] = date( 'd.m.Y', strtotime( $value[ 'next' ] ) );
                
            }
            
            // Sub Column C tag attributes
            if ( isset( $value['object'] ) ) {
                
                $attrarray = self::get_coltagattrs( 'safe_operation_of_lifts', 'subcol_C', $row );
                
                $subcolC_tagattrs = $attrarray[ 'attrs' ];
                
                $subcolC_data = $attrarray[ 'data' ];
                
                // Change curson if data is present
                $class_colC .= ' ondata-cursor ';
                
            }
            
        } else {
            
            $value = self::multicol_init_empty();
            
            $subcolC_tagattrs = '';
            
            $subcolC_data = '';
            
        }
        
        echo
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-A r-col-subcol-A-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'plan' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-B r-col-subcol-B-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'fact' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.$class_colC.' r-col-'.$column->key.' r-col-subcol-C r-col-subcol-C-'.$column->key.'" '.$subcolC_tagattrs.'>' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'next' ] .
                '</'.$wrapper.'>' . 
                '<data class="hidden">'.$subcolC_data.'</data>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Safe Operation of Cranes'.
     */
    private function output_col_safe_operation_of_cranes( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;
        $class_colC = '';

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;
        
        if ( isset( $row->columns[ $column->key ] ) ) {
            
            // Column value ( Column array )
            $value = $row->columns[ $column->key ];
            
            // Date Format 'd.m.Y' instead 'Y-m-d'
            if ( isset( $value[ 'plan' ] ) ) {
                
                $value[ 'plan' ] = date( 'd.m.Y', strtotime( $value[ 'plan' ] ) );
                
            }
            if ( isset( $value[ 'fact' ] ) ) {
                
                $value[ 'fact' ] = date( 'd.m.Y', strtotime( $value[ 'fact' ] ) );
                
            }
            if ( isset( $value[ 'next' ] ) ) {
                
                $value[ 'next' ] = date( 'd.m.Y', strtotime( $value[ 'next' ] ) );
                
            }
            
            // Sub Column C tag attributes
            if ( isset( $value['object'] ) ) {
                
                $attrarray = self::get_coltagattrs( 'safe_operation_of_cranes', 'subcol_C', $row );
                
                $subcolC_tagattrs = $attrarray[ 'attrs' ];
                
                $subcolC_data = $attrarray[ 'data' ];
                
                // Change curson if data is present
                $class_colC .= ' ondata-cursor ';
                
            }
            
        } else {
            
            $value = self::multicol_init_empty();
            
            $subcolC_tagattrs = '';
            
            $subcolC_data = '';
            
        }
        
        echo
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-A r-col-subcol-A-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'plan' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-B r-col-subcol-B-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'fact' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.$class_colC.' r-col-'.$column->key.' r-col-subcol-C r-col-subcol-C-'.$column->key.'" '.$subcolC_tagattrs.'>' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'next' ] .
                '</'.$wrapper.'>' . 
                '<data class="hidden">'.$subcolC_data.'</data>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Physical Examination'.
     */
    private function output_col_physical_examination( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;
        $class_colC = '';

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;
        
        if ( isset( $row->columns[ $column->key ] ) ) {
            
            // Column value ( Column array )
            $value = $row->columns[ $column->key ];
            
            // Date Format 'd.m.Y' instead 'Y-m-d'
            if ( isset( $value[ 'plan' ] ) ) {
                
                $value[ 'plan' ] = date( 'd.m.Y', strtotime( $value[ 'plan' ] ) );
                
            }
            if ( isset( $value[ 'fact' ] ) ) {
                
                $value[ 'fact' ] = date( 'd.m.Y', strtotime( $value[ 'fact' ] ) );
                
            }
            if ( isset( $value[ 'next' ] ) ) {
                
                $value[ 'next' ] = date( 'd.m.Y', strtotime( $value[ 'next' ] ) );
                
            }
            
            // Sub Column C tag attributes
            if ( isset( $value['object'] ) ) {
                
                $attrarray = self::get_coltagattrs( 'physical_examination', 'subcol_C', $row );
                
                $subcolC_tagattrs = $attrarray[ 'attrs' ];
                
                $subcolC_data = $attrarray[ 'data' ];
                
                // Change curson if data is present
                $class_colC .= ' ondata-cursor ';
                
            }
            
        } else {
            
            $value = self::multicol_init_empty();
            
            $subcolC_tagattrs = '';
            
            $subcolC_data = '';
            
        }
        
        echo
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-A r-col-subcol-A-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'plan' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.' r-col-'.$column->key.' r-col-subcol-B r-col-subcol-B-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'fact' ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>' .
            '<'.$tag.' class="'.$class.$class_colC.' r-col-'.$column->key.' r-col-subcol-C r-col-subcol-C-'.$column->key.'" '.$subcolC_tagattrs.'>' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $value[ 'next' ] .
                '</'.$wrapper.'>' . 
                '<data class="hidden">'.$subcolC_data.'</data>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Commission Type'.
     */
    private function output_col_commission_type( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;

        echo '<'.$tag.' class="'.$class.' r-col-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $row->columns[ $column->key ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>';
        
    }
    
    /**
     * Column 'Notes'.
     */
    private function output_col_notes( &$row, &$column ) {
        
        $tag = $this->col_tag;

        $class = $this->col_class;

        $wrapper = $this->colwrap_tag;

        $wrapperclass = $this->colwrap_class;

        echo '<'.$tag.' class="'.$class.' r-col-'.$column->key.'">' . 
                '<'.$wrapper.' class="'.$wrapperclass.'">'.
                    $row->columns[ $column->key ] .
                '</'.$wrapper.'>' . 
            '</'.$tag.'>';
        
    }
    
}
