<?php

namespace quiz_student;

/**
 * 
 */
class question_attempt {

    /**
     * Determines whether or not an answer is correct.
     * 
     * @param question_attempt $qa The question_attempt object.
     * 
     * @return bool True if the answer is correct, False if otherwise.
     */
    public function is_answercorrect(\question_attempt $qa) : bool {
        // Initial result
        $result = false;
        
        // Check answer
        if ($this->get_answerstate($qa) === 'correct') {
            $result = true;
        }
        
        return $result;
    }
    
    /**
     * Determines whether or not an answer is partially correct.
     * 
     * @param question_attempt $qa The question_attempt object.
     * 
     * @return bool True if the answer is partially correct, False if otherwise.
     */
    public function is_answerpartiallycorrect(\question_attempt $qa) : bool {
        // Initial result
        $result = false;
        
        // Check answer for partially correction
        if ($this->get_answerstate($qa) === 'partiallycorrect') {
            $result = true;
        }
        
        return $result;
    }
    
    /**
     * Determines whether or not an answer is incorrect.
     * 
     * @param question_attempt $qa The question_attempt object.
     * 
     * @return bool True if the answer is incorrect, False if otherwise.
     */
    public function is_answerincorrect(\question_attempt $qa) : bool {
        // Initial result
        $result = false;
        
        // Check answer
        if ($this->get_answerstate($qa) === 'incorrect') {
            $result = true;
        }
        
        return $result;
    }
    
    private function get_answerstate($qa) : string {
        $state = \question_state::graded_state_for_fraction($qa->get_fraction())->get_feedback_class();
        return $state;
        
//        if ($qa->get_mark() >= $qa->fraction_to_mark($qa->get_max_fraction())) {
//            $result = true;
//        }
//        $mark = $qa->get_mark();
//        if ($mark >= $qa->fraction_to_mark($qa->get_min_fraction()) &&
//                $mark < $qa->fraction_to_mark($qa->get_max_fraction())) {
//            $result = true;
//        }
//        if ($qa->get_mark() < $qa->fraction_to_mark($qa->get_min_fraction())) {
//            $result = true;
//        }
    }
}
