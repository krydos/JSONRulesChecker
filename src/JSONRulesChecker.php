<?php
namespace JSONRulesChecker;

class JSONChecker {
    
    public static function checkJSON($json, $rules) {
        $result = false;

        /**
         * go through all rules
         */
        foreach($rules as $key => $value) {

            if(isset($json->$key)) {

                if(gettype($value) == 'array') {
                    return self::checkJSON($json->$key, $value);
                }
                else {
                    $result = true;
                }
            }
            else {
                $result = false;
            }
        }

        return $result;
    }
}
