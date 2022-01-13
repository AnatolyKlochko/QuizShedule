<?php 
defined('MOODLE_INTERNAL') || die();
echo $output->doctype()
?>
<html <?php echo $output->htmlattributes() ?>>
    
    <head>
        <title><?php echo get_string( 'pageindextitle', 'quizschedulemaincommission_group' ) . ', ' . $header->date ?></title>
        <link rel="shortcut icon" href="<?php echo $output->pix_url('favicon', 'theme')?>" />
        <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
        <link rel="stylesheet" type="text/css"  href="<?php //echo new \moodle_url('/mod/quiz/report/student/style/bootstrap/4.0.0/css/bootstrap.min.css'); ?>" media="all">
        <link rel="stylesheet" type="text/css" href="<?php echo new \moodle_url('/mod/quizschedule/report/styles/reset.css'); ?>" media="all">
        <link rel="stylesheet" type="text/css"  href="<?php echo new \moodle_url('/mod/quizschedule/report/maincommission/group/styles/format/printing.css'); ?> " media="all" >
        <?php echo $output->standard_head_html() ?>

        <style>
           @media screen {
               
               #report {
                        width: <?php echo $page->width ?>;
                }
                                
                #report #header {
                    margin: <?php echo $header->margin ?>;
                    font: <?php echo $header->font ?>;
                }
                
                #report #body #datatable thead tr th {
                    font: <?php echo $datatable->headerfont ?>;
                }
                
                #report #body #datatable thead tr th[class=col-numbering] {
                    height: <?php echo $datatable->headerheight; // ?>;
                    width: <?php echo $numbering->width ?>;
                }
                
                #report #body #datatable thead tr th[class=col-employeeinfo] {
                    width: <?php echo $employeeinfo->width ?>;
                }
                
                #report #body #datatable thead tr th[class=col-sharetype] {
                    width: <?php echo $sharetype->width ?>;
                }
                
                #report #body #datatable thead tr th[class*=subcol-] {
                    width: <?php echo $admin_helper->getint( $sharetype->width ) / count( $sharetype->column ); echo $admin_helper->getunit( $sharetype->width ) ?>;
                }
                
                #report #body #datatable tbody tr td {
                    font: <?php echo $datatable->font ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-numbering] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $numbering->font;
                    }
                    ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-employeeinfo] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $employeeinfo->font;
                    }
                    ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-sharetype] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $sharetype->font;
                    }
                    ?>;
                }
                
                #report #footer {
                    margin: <?php echo $footer->margin ?>;
                    font: <?php echo $footer->font ?>;
                }
                
                #report #footer div[id$=line]{
                    padding: <?php echo $footer->linepadding ?>;
                }
                
                #report #footer .title {
                    width: <?php echo $footer->coltitlewidth ?>;
                }
                
                #report #footer .underline1, #report #footer .underline2 {
                    width: <?php echo $footer->colunderlinewidth ?>;
                    border-bottom: 1px solid black;
                    margin: 0 0 0 20px;
                }
                
            }
            
            @media print {
               
                @page {
                    margin: <?php echo $page->margin ?>;
                }
                
                #report {
                    
                }
                                
                #report #header {
                    margin: <?php echo $header->margin ?>;
                    font: <?php echo $header->font ?>;
                }
                
                #report #body #datatable thead tr th {
                    font: <?php echo $datatable->headerfont ?>;
                }
                
                #report #body #datatable thead tr th[class=col-numbering] {
                    height: <?php echo $datatable->headerheight; // ?>;
                    width: <?php echo $numbering->width ?>;
                }
                
                #report #body #datatable thead tr th[class=col-employeeinfo] {
                    width: <?php echo $employeeinfo->width ?>;
                }
                
                #report #body #datatable thead tr th[class=col-sharetype] {
                    width: <?php echo $sharetype->width ?>;
                }
                
                #report #body #datatable thead tr th[class*=subcol-] {
                    width: <?php echo $admin_helper->getint( $sharetype->width ) / count( $sharetype->column ); echo $admin_helper->getunit( $sharetype->width ) ?>;
                }
                
                #report #body #datatable tbody tr td {
                    font: <?php echo $datatable->font ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-numbering] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $numbering->font;
                    }
                    ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-employeeinfo] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $employeeinfo->font;
                    }
                    ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-sharetype] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $sharetype->font;
                    }
                    ?>;
                }
                
                #report #footer {
                    margin: <?php echo $footer->margin ?>;
                    font: <?php echo $footer->font ?>;
                }
                
                #report #footer div[id$=line]{
                    padding: <?php echo $footer->linepadding ?>;
                }
                
                #report #footer .title {
                    width: <?php echo $footer->coltitlewidth ?>;
                }
                
                #report #footer .underline1, #report #footer .underline2 {
                    width: <?php echo $footer->colunderlinewidth ?>;
                    border-bottom: 1px solid black;
                    margin: 0 0 0 20px;
                }
                
            }
        </style>
    </head>

    <body id="<?php p($htmlpage->bodyid) ?>" class="<?php p($htmlpage->bodyclasses.' '.join(' ', $bodyclasses)) ?>">

        <div id="report" class="">

            <div id="header" class="">
                <div id="date"><?php echo $header->date ?></div>
            </div>

            <div id="body" class="">
                
                    <table id="datatable" class="">

                        <thead>
                            <tr>
                                <th rowspan="2" class="col-numbering">
                                    <?php echo $numbering->title ?>
                                </th>
                                <th rowspan="2" class="col-employeeinfo">
                                    <?php echo $employeeinfo->title ?>
                                </th>
                                <th colspan="<?php echo count( $sharetype->column ) ?>" class="col-sharetype">
                                    <?php echo $sharetype->title ?>
                                </th>
                            </tr>
                            <tr>
                                <?php
                                foreach ( $sharetype->column as $key => $col ) {
                                    echo "<th class=\"subcol-$key\">$col</th>";
                                }
                                ?>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                            $nbo = 1;
                            foreach ( $datatable->employees as $employee ) { ?>
                                <tr>
                                    <td class="col-numbering"><?php echo $nbo++ ?></td>
                                    <td class="col-employeeinfo"><?php echo $employee->get_info() ?></td>
                                    <?php  echo str_repeat( '<td></td>', count( $sharetype->column ) ); ?>
                                </tr><?php
                            }
                        ?>
                        </tbody>

                    </table>
                
            </div>

            <div id="footer">
                <div id="firstline" class="">
                    <span class="title">СОП</span><span class="underline1"></span><span class="underline2"></span>
                </div>
                <div id="secondline" class="">
                    <span class="title">СНтаПР</span><span class="underline1"></span><span class="underline2"></span>
                </div>
                <div id="thirdline" class="">
                    <span class="title">Сл. ЦЗ, МР та ПБ</span><span class="underline1"></span><span class="underline2"></span>
                </div>
            </div>

        </div>
        
    </body>
    
</html>