<?php
namespace JSONRulesChecker;

class JSONChecker {
    
    private function check($json, $rules, $result = array()) {

        /**
         * go through all rules
         */
        foreach($rules as $key => $value) {

            if(isset($json->$key)) {

                if($this->isArray($value)) {
                    $result = array_merge($this->check($json->$key, $value, $result), $result);
                }
                else {
                    if($value == '') {
                        $value = '/.*/';
                    }
                    if(!@preg_match($value, $json->$key)) {
                        $result[] = false;
                    }
                    else {
                        $result[] = true;
                    }
                }
            }
            else {
                $result[] = false;
            }
        }

        return $result;
    }

    /**
     * check is this value is array?
     */
    private function isArray($value) {
        if(gettype($value) == 'array') {
            return true;
        }
        else {
            return false;
        }
    }

    public static function checkJSON($json, $rules, $result = array()) {
        $checker = new self();
        $result_array = $checker->check($json, $rules, $result);

        if(array_search(false, $result_array)) {
            return false;
        }
        else {
            return true;
        }
    }

}
