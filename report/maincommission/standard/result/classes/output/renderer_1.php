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
    <link rel="stylesheet" type="text/css"  href="<?php echo new \moodle_url('/mod/quiz/report/student/style/bootstrap/4.0.0/css/bootstrap.min.css'); ?> " media="screen" >
    <link rel="stylesheet" type="text/css"  href="<?php echo new \moodle_url('/mod/quiz/report/student/style/styles.css'); ?> " media="screen" >
    <?php echo $output->standard_head_html() ?>
</head>
<body id="<?php p($page->bodyid) ?>" class="<?php p($page->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
    <div class="result">
        <div class="container result-container">
            <div class="row">
              <div class="col">
                  <p class="title">Протокол перевірки знань № ____</p>
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
                            <td><?= $rd['grade'] >= 0.85 ? 'знає' : 'не знає' ?></td>
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
                            <th class="col-1">№<br />п/п</th>
                            <th class="col-2">Прізвище,<br />ім'я, по-батькові,<br />посада</th>
                            <th class="col-3">Дата<br />попередньої<br />перевірки,<br />група з<br />електро-<br />безпеки</th>
                            <th class="col-4">Дата<br />перевірки,<br />причина,<br />група з<br />електро-<br />безпеки</th>
                            <th class="col-5">Тема перевірки (охорона праці,<br />правила пожежної безпеки,<br />вимоги Держгірпромнагляду,<br />технологія робіт)</th>
                            <th class="col-6">Рішення<br />комісії<br />(знає, не<br />знає)</th>
                            <th class="col-7">Дата<br />наступної<br />перевірки</th>
                            <th class="col-8">Підпис<br />особи,<br />яка<br />переві-<br />ряється</th>
                        </tr>
                        <tr><!-- first row -->
                            <td rowspan="<?= $topiclist_count ?>">
                                <?= '{n}' ?>
                            </td>
                            <td rowspan="<?= $topiclist_count ?>">
                                <?= $rd['lastname'] . '<br />' . $rd['firstname'] . '<br />' . '{position}' . '<br />' . '{location}' ?>
                            </td>
                            <td rowspan="<?= $topiclist_count ?>" class="text-center">
                                <?= '{date}' ?>
                            </td>
                            <td rowspan="<?= $topiclist_count ?>" class="text-center">
                                <span class="date"><?= date('Y.m.d', $rd['timefinish']) ?></span><br />
                                <span class="time"><?= date('H:i', $rd['timefinish']) ?></span>
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
                    <p class="text">Рішення комісії</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text">Спец.роботи:</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text-center">Голова комісії:</p>
                </div>
            </div>
            <div class="row pt-2">
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
            <div class="row pt-2">
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