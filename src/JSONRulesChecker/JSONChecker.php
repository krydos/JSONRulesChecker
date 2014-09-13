<?php
namespace JSONRulesChecker;

class JSONChecker {
    public $rules_keys_number;
    public $json_keys_number;

    const DEFAULT_REGEX = '/.*/';
    
    private function check($json, $rules, $result = array()) {

        /**
         * go through all rules
         */
        foreach($rules as $key => $value) {
            $this->rules_keys_number++;

            if(isset($json->$key)) {

                /**
                 * if value of json key it's array 
                 * then call this function again
                 */
                if(is_array($value)) {
                    $result = array_merge($this->check($json->$key, $value, $result), $result);
                }

                /**
                 * check the value using rexex
                 */
                else {

                    /**
                     * if rule an empty
                     * then replace it with default regex
                     */
                    if($value == '') {
                        $value = self::DEFAULT_REGEX;
                    }

                    /**
                     * check if rule don't match with json
                     * then push false to the result array
                     */
                    if(!@preg_match($value, $json->$key)) {
                        $result[] = false;
                    }

                    /**
                     * if preg_match returned true 
                     * then value match to rules 
                     * then push true to the result array
                     */
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

    public function countJsonKeys($json) {
        foreach($json as $key => $value) {
            $this->json_keys_number++;
            if(is_object($value)) {
                $this->countJsonKeys($value);
            }
        }
    }

    /**
     * invoke this method when you want to validate json
     */
    public static function checkJSON($json, $rules, $strict = false) {
        /**
         * create object of this class
         */
        $checker = new self();

        /**
         * main function
         * invoke it for json checking
         */
        $result_array = $checker->check($json, $rules, array());
        $checker->countJsonKeys($json);

        /**
         * if strict option is true then
         * check on strict matching
         */
        if($strict) {
            if($checker->rules_keys_number != $checker->json_keys_number) {
                return false;
            }
        }


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
