<?php

defined('MOODLE_INTERNAL') || die();

$dci = 0; // data-column index

?>
<style></style>
<div id="report" class="r-container container">
    <div id="attention" class="text-justify mt-3 mb-5">
        Увага! Якщо загальний фільтр перестає корректно фільтрувати після введення певного 
        символу, тоді спробуйте перемкнутися на Англійську розкладку і ввести 
        схожий символ латиницею, а потім знову продовжуйте введення кирилицею. 
        Оскільки, на даний момент, фактично, головна БД підприємства містить інформацію в 
        неоднорідному кодуванні (серед кирилічних символів можуть зустрічатись 
        ідентичні за виглядом латинські).<br/>
        Схожі за виглядом кириличні і латинські символи - "а", "о", "і", "c", "T", "B" і т.п.
    </div>
    <div id="wrapper" class="r-wrapper">
        <div id="search-cntr" class="mt-3">
            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#searchModal">Пошук</button>

            <!-- Modal -->
            <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLongTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="searchModalLongTitle">Параметри пошуку</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <div class="modal-body">

                            <!-- COL 1 -->
                            <div class="form-group row">
                                <label for="col_1_filia" class="col-sm-2 col-form-label font-weight-bold">Філія</label>
                                <div class="col-sm-10">
                                    <input type="text" class="filter_text_field form-control" id="col_1_filia" placeholder="Філія" data-col="1">
                                </div>
                            </div>

                            <!-- COL 2 -->
                            <div class="form-group row">
                                <label for="col_2_pidrozdil" class="col-sm-2 col-form-label font-weight-bold">Підрозділ</label>
                                <div class="col-sm-10">
                                    <input type="text" class="filter_text_field form-control" id="col_2_pidrozdil" placeholder="Підрозділ" data-col="2">
                                </div>
                            </div>

                            <!-- COL 3 -->
                            <div class="form-group row">
                                <label for="col_3_tab_nomer" class="col-sm-2 col-form-label font-weight-bold">Таб.номер</label>
                                <div class="col-sm-10">
                                    <input type="text" class="filter_text_field form-control" id="col_3_tab_nomer" placeholder="Таб.номер" data-col="3">
                                </div>
                            </div>

                            <!-- COL 4 -->
                            <div class="form-group row">
                                <label for="col_4_pib" class="col-sm-2 col-form-label font-weight-bold">ПІБ</label>
                                <div class="col-sm-10">
                                    <input type="text" class="filter_text_field form-control" id="col_4_pib" placeholder="ПІБ" data-col="4">
                                </div>
                            </div>

                            <!-- COL 5 -->
                            <div class="form-group row">
                                <label for="col_5_posada" class="col-sm-2 col-form-label font-weight-bold">Посада</label>
                                <div class="col-sm-10">
                                    <input type="text" class="filter_text_field form-control" id="col_5_posada" placeholder="Посада" data-col="5">
                                </div>
                            </div>

                            <!-- COL 6 -->
                            <div class="form-group row">
                                <label for="col_6_grupa_eb" class="col-sm-2 col-form-label font-weight-bold">Група з ЕБ</label>
                                <div class="col-sm-10">
                                    <input type="text" class="filter_text_field form-control" id="col_6_grupa_eb" placeholder="Група з ЕБ" data-col="6">
                                </div>
                            </div>

                            <!-- COL 28 -->
                            <div class="form-group row">
                                <label for="col_28_komisia" class="col-sm-2 col-form-label font-weight-bold">Комісія</label>
                                <div class="col-sm-10">
                                    <input type="text" class="filter_text_field form-control" id="col_28_komisia" placeholder="Комісія" data-col="28">
                                </div>
                            </div>

                            <!-- COL 29 -->
                            <div class="form-group row">
                                <label for="col_29_prymitki" class="col-sm-2 col-form-label font-weight-bold">Примітки</label>
                                <div class="col-sm-10">
                                    <input type="text" class="filter_text_field form-control" id="col_29_prymitki" placeholder="Примітки" data-col="29">
                                </div>
                            </div>

                            <hr>
                            <!-- ============= OP Date pickers ============= -->
                            <b>ОП</b>
                            <!-- COL 7 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    План
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="op_plan" data-col="7">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="op_plan date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 8 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Факт
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="op_fact" data-col="8">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="op_fact date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 9 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Наступний
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8"data-type="op_next" data-col="9">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="op_next date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>
                                
                            <hr>
                            <!-- -------- TR Date pickers ---------- -->
                            <b>ТР</b>
                            <!-- COL 10 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    План
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="tr_plan" data-col="10">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="tr_plan date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 11 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Факт
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="tr_fact" data-col="11">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="tr_fact date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 12 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Наступний
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="tr_next" data-col="12">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="tr_next date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>


                            <hr>
                            <!-- -------- PPB Date pickers ---------- -->
                            <b>ППБ</b>
                            <!-- COL 13 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    План
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="ppb_plan" data-col="13">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="ppb_plan date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 14 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Факт
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="ppb_fact" data-col="14">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="ppb_fact date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 15 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Наступний
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="ppb_next" data-col="15">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="ppb_next date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>



                            <hr>
                            <!-- -------- BPRP Date pickers ---------- -->
                            <b>БПРП</b>
                            <!-- COL 16 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    План
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="bprp_plan" data-col="16">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="bprp_plan date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 17 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Факт
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="bprp_fact" data-col="17">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="bprp_fact date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 18 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Наступний
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="bprp_next" data-col="18">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="bprp_next date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>



                            <hr>
                            <!-- -------- BPRK Date pickers ---------- -->
                            <b>БПРК</b>
                            <!-- COL 19 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    План
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="bprk_plan" data-col="19">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="bprk_plan date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 20 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Факт
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="bprk_fact" data-col="20">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="bprk_fact date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 21 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Наступний
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="bprk_next" data-col="21">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="bprk_next date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>



                            <hr>
                            <!-- -------- PPT Date pickers ---------- -->
                            <b>ППТ</b>
                            <!-- COL 22 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    План
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="ppt_plan" data-col="22">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="ppt_plan date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 23 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Факт
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="ppt_fact" data-col="23">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="ppt_fact date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 24 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Наступний
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="ppt_next" data-col="24">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="ppt_next date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>



                            <hr>
                            <!-- -------- MO Date pickers ---------- -->
                            <b>МО</b>
                            <!-- COL 25 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    План
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="mo_plan" data-col="25">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="mo_plan date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 26 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Факт
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="mo_fact" data-col="26">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="mo_fact date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- COL 27 -->
                            <div class="form-row align-items-center mb-3">
                                <div class="col-md-2">
                                    Наступний
                                </div>

                                <div class="col-md-4">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">Від</span>
                                        <input type="date" class="filter_field date_from form-control col-md-8" data-type="mo_next" data-col="27">
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-1">
                                    <div class="row align-items-center">
                                        <span class="col-md-4 text-md-right">До</span>
                                        <input type="date" class="mo_next date_to form-control col-md-8">
                                    </div>
                                </div>
                            </div>

                            <!-- END OF MODAL CONTENT -->
                        </div>

                        <div class="modal-footer">
                            <button id="searchModal-Dismiss" type="button" class="btn btn-secondary" data-dismiss="modal">Відмінити</button>

                            <button id="reset_btn" type="button" class="btn btn-warning">Скинути фільтр &orarr;</button>

                            <button id="search_btn" type="button" class="btn btn-primary" data-dismiss="modal">ПОШУК</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div id="table-column-visibility">
            <a href="#" data-column="<?php echo $dci; ?>" data-name="numbering">№</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci; ?>" data-name="affiliate">Філія</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci; ?>" data-name="department">Підрозділ</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci; ?>" data-name="employee_number">Таб.номер</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci; ?>" data-name="fullname">ПІБ</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci; ?>" data-name="position">Посада</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci; ?>" data-name="group_of_electrical_safety">Група з ЕБ</a><span class="splitter"></span>
            
            <a href="#" data-column="<?php echo ++$dci . ',' . ++$dci . ',' . ++$dci; ?>" data-name="occupational_health" class="quiz-column">ОП</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci . ',' . ++$dci . ',' . ++$dci; ?>" data-name="technology_works" class="quiz-column">ТР</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci . ',' . ++$dci . ',' . ++$dci; ?>" data-name="fire_safety_rules" class="quiz-column">ППБ</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci . ',' . ++$dci . ',' . ++$dci; ?>" data-name="safe_operation_of_lifts" class="quiz-column">БПРП</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci . ',' . ++$dci . ',' . ++$dci; ?>" data-name="safe_operation_of_cranes" class="quiz-column">БПРК</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci . ',' . ++$dci . ',' . ++$dci; ?>" data-name="pressure_vessels" class="quiz-column">ППТ</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci . ',' . ++$dci . ',' . ++$dci; ?>" data-name="physical_examination" class="quiz-column">МО</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci; ?>" data-name="commission_type">Комісія</a><span class="splitter"></span>
            <a href="#" data-column="<?php echo ++$dci; ?>" data-name="notes">Примітки</a>
        </div>

        <table id="table" class="r-table table table-responsive table-hover">
            <thead class="header text-center">
                <?php $this->output_header() ?>
            </thead>
            <tbody class="content text-center">
                <?php $this->output_content() ?>
            </tbody>
        </table>
            
        <?php 
        //echo $GLOBALS['pagination']; 
        ?>
        
    </div>
</div>
