<?php echo $output->doctype() ?>
<html <?php echo $output->htmlattributes() ?>>
    
    <head>
        <title>Головна Комісія, Протокол "Груповий" за <?php echo $header->date ?></title>
        <link rel="shortcut icon" href="<?php echo $output->pix_url('favicon', 'theme')?>" />
        <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
        <link rel="stylesheet" type="text/css"  href="<?php //echo new \moodle_url('/mod/quiz/report/student/style/bootstrap/4.0.0/css/bootstrap.min.css'); ?>" media="all">
        <link rel="stylesheet" type="text/css" href="<?php echo new \moodle_url('/mod/quizschedule/report/styles/reset.css'); ?>" media="all">
        <link rel="stylesheet" type="text/css"  href="<?php echo new \moodle_url('/mod/quizschedule/report/maincommission/group/styles/format/print.css'); ?> " media="all" >
        <?php echo $output->standard_head_html() ?>

        <style>
           @media screen {
               
               #report {
                    width: <?php echo $rpage->width ?>;
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
                    width: <?php echo $col_numbering->width ?>;
                }
                
                #report #body #datatable thead tr th[class=col-employeeinfo] {
                    width: <?php echo $col_employeeinfo->width ?>;
                }
                
                #report #body #datatable thead tr th[class=col-sharetype] {
                    width: <?php echo $col_sharetype->width ?>;
                }
                
                #report #body #datatable thead tr th[class*=subcol-] {
                    width: <?php echo $helper->admin_getint( $col_sharetype->width ) / count( $datatable->subcolumn ); echo $helper->admin_getunit( $col_sharetype->width ) ?>;
                }
                
                #report #body #datatable tbody tr td {
                    font: <?php echo $datatable->font ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-numbering] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $col_numbering->font;
                    }
                    ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-employeeinfo] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $col_employeeinfo->font;
                    }
                    ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-sharetype] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $col_sharetype->font;
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
                    margin: <?php echo $rpage->margin ?>;
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
                    width: <?php echo $col_numbering->width ?>;
                }
                
                #report #body #datatable thead tr th[class=col-employeeinfo] {
                    width: <?php echo $col_employeeinfo->width ?>;
                }
                
                #report #body #datatable thead tr th[class=col-sharetype] {
                    width: <?php echo $col_sharetype->width ?>;
                }
                
                #report #body #datatable thead tr th[class*=subcol-] {
                    width: <?php echo $helper->admin_getint( $col_sharetype->width ) / count( $datatable->subcolumn ); echo $helper->admin_getunit( $col_sharetype->width ) ?>;
                }
                
                #report #body #datatable tbody tr td {
                    font: <?php echo $datatable->font ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-numbering] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $col_numbering->font;
                    }
                    ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-employeeinfo] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $col_employeeinfo->font;
                    }
                    ?>;
                }
                
                #report #body #datatable tbody tr td[class=col-sharetype] {
                    <?php 
                    if ( 1 ) { // todo: add checkbox
                        echo 'font: ' . $col_sharetype->font;
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

    <body id="<?php p($page->bodyid) ?>" class="<?php p($page->bodyclasses.' '.join(' ', $bodyclasses)) ?>">

        <div id="report" class="">

            <div id="header" class="">
                <div id="date"><?php echo $header->date ?></div>
            </div>

            <div id="body" class="">
                
                    <table id="datatable" class="">

                        <thead>
                            <tr>
                                <th rowspan="2" class="col-numbering">
                                    <?php echo $col_numbering->title ?>
                                </th>
                                <th rowspan="2" class="col-employeeinfo">
                                    <?php echo $schedule->filter_backreplacebreakline( $col_employeeinfo->title ) ?>
                                </th>
                                <th colspan="<?php echo count( $datatable->subcolumn ) ?>" class="col-sharetype">
                                    <?php echo $col_sharetype->title ?>
                                </th>
                            </tr>
                            <tr>
                                <?php
                                foreach ( $datatable->subcolumn as $subcolkey => $subcol ) {
                                    echo "<th class=\"subcol-$subcolkey\">$subcol</th>";
                                }
                                ?>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                            $nbo = 1;
                            foreach ( $datatable->employee as $employee ) { ?>
                                <tr>
                                    <td class="col-numbering"><?php echo $nbo++ ?></td>
                                    <td class="col-employeeinfo"><?php echo $employee->get_info() ?></td>
                                    <?php  echo str_repeat( '<td></td>', count( $datatable->subcolumn ) ); ?>
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