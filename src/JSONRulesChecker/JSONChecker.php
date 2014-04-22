<?php
namespace JSONRulesChecker;

class JSONChecker {
    
    private function check($json, $rules, $result = array()) {

        /**
         * go through all rules
         */
        foreach($rules as $key => $value) {

            if(isset($json->$key)) {

                if(is_array($value)) {
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
     * invoke this method when you want to validate json
     */
    public static function checkJSON($json, $rules, $result = array()) {
        /**
         * create object of this class
         */
        $checker = new self();

        /**
         * main function
         * invoke it for json checking
         */
        $result_array = $checker->check($json, $rules, $result);

        /**
         * if we don't found the false in the result_array
         * then return true
         */
        if(array_search(false, $result_array) === false) {
            return true;
        }
        /**
         * else return false
         */
        else {
            return false;
        }
    }

}
