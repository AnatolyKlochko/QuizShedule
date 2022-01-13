<?php

namespace quiz_student_result;

class renderer {
       
    public function display(array &$rd) {
        $page = $rd['page'];
        $output = $page->get_renderer('core');
        $page->set_title( 
            get_string('student', 'quiz_student') . '. ' . 
            get_string('reporttype_result', 'quiz_student') . '. ' . 
            $rd['firstname'] . ' ' . $rd['lastname'] . '. ' . 
            $rd['course_fullname']);
        //$page->bodyid = '';
        
        $bodyclasses = array();
        $bodyclasses[] = 'report';
        //$bodyclasses[] = '';
        
        $topiclist = &$rd['topiclist'];
        $topiclist_count = count($topiclist);
        
        echo $output->doctype() ?>
<html <?php echo $output->htmlattributes() ?>>
<head>
    <title><?php echo $page->title ?></title>
    <link rel="shortcut icon" href="<?php echo $output->pix_url('favicon', 'theme')?>" />
    <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
    <link rel="stylesheet" type="text/css"  href="<?php //echo new \moodle_url('/mod/quiz/report/student/style/bootstrap/4.0.0/css/bootstrap.min.css'); ?>" media="all">
    <link rel="stylesheet" type="text/css" href="<?php echo new \moodle_url('/mod/quiz/report/student/style/reset.css'); ?>" media="all">
    <link rel="stylesheet" type="text/css"  href="<?php echo new \moodle_url('/mod/quiz/report/student/style/styles.css'); ?> " media="all" >
    <?php echo $output->standard_head_html() ?>
</head>
<body id="<?php p($page->bodyid) ?>" class="<?php p($page->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
    <div class="result">
        <div class="container result-container">
            <div class="row">
              <div class="col">
                  <p class="title">Протокол перевірки знань № ________</p>
              </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text">1. Результат перевірки знань в програмному комплексі "Moodle":</p>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <table class="table table1">
                        <thead class="header">
                            <tr>
                                <th scope="col" class="col-1">Назва контрольного набору</th>
                                <th scope="col" class="col-2">Кількість запитань</th>
                                <th scope="col" class="col-3">Кількість помилок</th>
                                <th scope="col" class="col-4">Оцінка</th>
                            </tr>
                        </thead>
                        <tbody class="content">
                          <tr>
                            <td><?= $rd['course_fullname'] ?></td>
                            <td><?= $rd['question_count'] ?></td>
                            <td><?= $rd['incorrectanswer_count'] ?></td>
                            <td><?= $rd['grade'] >= $rd['gradepass'] ? 'знає' : 'не знає' ?></td>
                          </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text">2. Результати опитування:</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table2">
                        <tr>
                            <!--th class="col-1">№<br />п/п</th-->
                            <th class="col-2">Прізвище,<br />ім'я, по-батькові,<br />посада</th>
                            <th class="col-3">Дата попередньої перевірки, група з електробезпеки</th>
                            <th class="col-4">Дата перевірки, причина, група з електро безпеки</th>
                            <th class="col-5">Тема перевірки (охорона праці, правила пожежної безпеки, вимоги Держпраці, технологія робіт)</th>
                            <th class="col-6">Рішення комісії<br />(знає, не<br />знає)</th>
                            <th class="col-7">Дата наступної перевірки</th>
                            <th class="col-8">Підпис особи, яка перевіряється</th>
                        </tr>
                        <tr><!-- first row -->
                            <!--td rowspan="<?= $topiclist_count ?>">
                                
                            </td-->
                            <td rowspan="<?= $topiclist_count ?>">
                            <?= 
                                $rd['lastname'] . '<br />' . 
                                $rd['firstname'] . '<br />' .
                                '<br />' .
                                '<span class="position">' . $rd['position'] . '</span><br />' .
                                '<br />' .
                                '<span class="company">' . $rd['company'] . '</span>, <span class="department">' . $rd['department'] . '</span><br />'
                            ?>
                            </td>
                            <td rowspan="<?= $topiclist_count ?>" class="text-center">
                                <span class="date"><?= ''//{date}' ?></span><br />
                            </td>
                            <td rowspan="<?= $topiclist_count ?>" class="text-center">
                                <span class="date"><?= date('j.m.Y', $rd['timefinish']) ?></span><br />
                                <span class="time"><?= '' ?></span>
                            </td>
                            <td class="col-5"><?= $topiclist[0] ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr><?php
                        array_shift($topiclist);
                        foreach ($topiclist as $topicname) { ?>
                            <tr><!-- second and so on rows -->
                                <!--td class="col-1"></td here is rowspan -->
                                <!--td class="col-2"></td here is rowspan -->
                                <!--td class="col-3"></td here is rowspan -->
                                <!--td class="col-4"></td here is rowspan -->
                                <td class="col-5"><?= $topicname ?></td>
                                <td class="col-6"></td>
                                <td class="col-7"></td>
                                <td class="col-8"></td>
                            </tr><?php
                        } ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text">Рішення комісії:</p>
                    <br />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text">Спец.роботи:</p>
                    <br /><br />
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text-center">Голова комісії:</p>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-5 px-3"><div class="border-bottom border-dark"></div></div>
                <div class="col-3 px-3"><div class="border-bottom border-dark"></div></div>
                <div class="col-4 px-3"><div class="border-bottom border-dark"></div></div>
            </div>
            <div class="row">
                <div class="col-5"></div>
                <div class="col-3 sign">(підпис)</div>
                <div class="col-4"></div>
            </div>
            <div class="row pt-4">
                <div class="col">
                    <p class="text-center">Члени комісії:</p>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-5 px-3"><div class="border-bottom border-dark"></div></div>
                <div class="col-3 px-3"><div class="border-bottom border-dark"></div></div>
                <div class="col-4 px-3"><div class="border-bottom border-dark"></div></div>
            </div>
            <div class="row">
                <div class="col-5"></div>
                <div class="col-3 sign">(підпис)</div>
                <div class="col-4"></div>
            </div>
            <div class="row pt-4">
                <div class="col-5 px-3"><div class="border-bottom border-dark"></div></div>
                <div class="col-3 px-3"><div class="border-bottom border-dark"></div></div>
                <div class="col-4 px-3"><div class="border-bottom border-dark"></div></div>
            </div>
            <div class="row">
                <div class="col-5"></div>
                <div class="col-3 sign">(підпис)</div>
                <div class="col-4"></div>
            </div>
            <div class="row pt-4">
                <div class="col-5 px-3"><div class="border-bottom border-dark"></div></div>
                <div class="col-3 px-3"><div class="border-bottom border-dark"></div></div>
                <div class="col-4 px-3"><div class="border-bottom border-dark"></div></div>
            </div>
            <div class="row">
                <div class="col-5"></div>
                <div class="col-3 sign">(підпис)</div>
                <div class="col-4"></div>
            </div>
            <div class="row pt-4">
                <div class="col-5 px-3"><div class="border-bottom border-dark"></div></div>
                <div class="col-3 px-3"><div class="border-bottom border-dark"></div></div>
                <div class="col-4 px-3"><div class="border-bottom border-dark"></div></div>
            </div>
            <div class="row">
                <div class="col-5"></div>
                <div class="col-3 sign">(підпис)</div>
                <div class="col-4"></div>
            </div>
          </div>
        <div class="clearfix"></div>
    </div>
</body>
</html>
<?php 
    }
}
?>