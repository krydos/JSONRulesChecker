<?php
namespace JSONRulesChecker;

class JSONChecker {
    
    public static function checkJSON($json, $rules) {
        $result = false;
        $checker = new self();

        /**
         * go through all rules
         */
        foreach($rules as $key => $value) {

            if(isset($json->$key)) {

                if($checker->isArray($value)) {
                    return self::checkJSON($json->$key, $value);
                }
                else {
                    if(!@preg_match($value, $json->$key)) {
                        return false;
                    }
                    else {
                        $result = true;
                    }
                }
            }
            else {
                $result = false;
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
}
