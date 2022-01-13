<?php

namespace quiz_student;

class quiz_attempt {
    
    private $attemptobj = null;
    private $is_computed = false;
    private $question_count = 0;
    private $correctanswer_count = 0;
    private $partiallycorrectanswer_count = 0;
    private $incorrectanswer_count = 0;
    private $result = false;
    private $category_arr = [];
        
    public function __construct(\quiz_attempt $attemptobj) {
        $this->attemptobj = $attemptobj;
        $this->compute();
    }
    
    public function is_computed() : bool {
        return $this->is_computed;
    }
    
    private function compute() {
        // Question count
        $this->question_count = $this->compute_questioncount($this->attemptobj);
        
        // Cycle variables: quiz_student\question_attempt object, category array
        $studentqaobj = new question_attempt; $categoryarr = [];
        
        // Computing cycle
        $this->compute_cycle($this->attemptobj, $studentqaobj, $categoryarr);
    }
    
    public function get_question_count() : int {
        return $this->question_count;
    }
    
    public function get_correctanswer_count() : int {
        return $this->correctanswer_count;
    }
    public function get_partiallycorrectanswer_count() : int {
        return $this->partiallycorrectanswer_count;
    }
    public function get_incorrectanswer_count() : int {
        return $this->incorrectanswer_count;
    }
    
    public function get_topiclist_ids() : array {
        return array_keys($this->category_arr);
    }
    
    public function get_topiclist_names() : array {
        global $DB;
        
        // Get category id's
        $id_arr = $this->get_topiclist_ids();
        
        // 
        $name_arr_raw = $DB->get_records_list('question_categories', 'id', $id_arr, null, 'name');
        $name_arr = array_keys($name_arr_raw);
        
        // 
        return $name_arr;
    }
    
    public function get_category_statistics() : array {
        $this->extend_categoryarr_add_namesandmarks( $this->category_arr );
        return $this->category_arr;
    }
    
    private function compute_questioncount(\quiz_attempt $attemptobj) : int {
        $slots = $attemptobj->get_slots();
        
        // Question count
        $question_count = count($slots);
        
        // Get result
        return $question_count;
    }
    
    private function compute_cycle(\quiz_attempt $attemptobj, \quiz_student\question_attempt $studentqaobj, array &$categoryarr) {
        
        foreach ($attemptobj->get_slots() as $slot) {
            
            $qaobj = $attemptobj->get_question_attempt($slot);
            
            // Category array
            $cid = $this->get_categoryid($qaobj);
            $this->init_category($categoryarr, $cid);
                        
            // Computing
            if ($qaobj->has_marks()) {
                do {
                    // Correct answers
                    if ($studentqaobj->is_answercorrect($qaobj)) {
                        $this->answercorrect_actions($categoryarr, $cid);
                        //break;
                    }

                    // Partially Correct Answers
                    if ($studentqaobj->is_answerpartiallycorrect($qaobj)) {
                        $this->answerpartiallycorrect_actions($categoryarr, $cid);
                        //break;
                    }

                    // Incorrect answers
                    if ($studentqaobj->is_answerincorrect($qaobj)) {
                        $this->answerincorrect_actions($categoryarr, $cid);
                    }
                } while(0);
            }
            
        }
        
        // Category
        $this->category_arr = &$categoryarr;
    }
    
    private function get_categoryid(\question_attempt $qaobj) {
        $cid = $qaobj->get_question()->category;
        return $cid;
    }
    
    private function init_category(array &$categoryarr, int &$cid) {
        if (! isset($categoryarr[$cid])) {
            $cattmp = [];
            $cattmp['correct'] = 0;
            $cattmp['partiallycorrect'] = 0;
            $cattmp['incorrect'] = 0;
            $categoryarr[$cid] = $cattmp;
        }
    }
    
    private function extend_categoryarr_add_namesandmarks(array &$categoryarr) {
        global $DB;
        
        // Array index is equal to id field value. Maybe 'id' in SELECT is unneccessary.
        $category_idname_arr = $DB->get_records_list('question_categories', 'id', array_keys($categoryarr), null, 'id,name');
        
        // Prepare array
        // todo: move 'id' field to index. Now it is done.
        
        //
        foreach ($categoryarr as $catid => &$category) {
            $category['name'] = $category_idname_arr[$catid]->name;
        }
        
        // Marks
//        $attempt = $this->attemptobj->get_attempt();
//        $quiz = $this->attemptobj->get_quiz();
//        $sumgrades = $attempt->sumgrades;
//        $grade = quiz_rescale_grade($sumgrades, $quiz, false);
        foreach ($this->attemptobj->get_slots() as $slot) {
            
            $qaobj = $this->attemptobj->get_question_attempt($slot);
            
            // Category array
            $cid = $this->get_categoryid($qaobj);
            
            // Total Category Mark
            if ($qaobj->has_marks()) {
                $categoryarr[$cid]['mark'] += $qaobj->get_mark();
            }
            
        }
    }
    
    private function answercorrect_actions(array &$categoryarr, int &$cid) {
        $this->correctanswer_count++;
        $categoryarr[$cid]['correct']++;
    }
    
    private function answerpartiallycorrect_actions(array &$categoryarr, int &$cid) {
        $this->partiallycorrectanswer_count++;
        $categoryarr[$cid]['partiallycorrect']++;
    }
    
    private function answerincorrect_actions(array &$categoryarr, int &$cid) {
        $this->incorrectanswer_count++;
        $categoryarr[$cid]['incorrect']++;
    }
}
