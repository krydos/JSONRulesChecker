<?php 
require 'src/JSONRulesChecker/JSONChecker.php';

class CheckerTest extends PHPUnit_Framework_TestCase {

    public function testJSONCheckerHaveToReturnTrueIfRulesAndJsonAreCorrect() {
        $json = json_decode(json_encode(array(
            'root' => array(
                'int_attr' => '123124',
                'str_attr' => 'only word shere',
                'another_array' => array(
                    'attr1' => '111',
                    'attr2' => 'www'
                ),
                'attr2' => 'hi',
            )
        )));

        $result = \JSONRulesChecker\JSONChecker::checkJSON($json, array(
            'root' => array(
                'int_attr' => '/^\d+$/',
                'str_attr' => '',
                'another_array' => array(
                    'attr1' => '',
                    'attr2' => '/www/'
                ),
                'attr2' => ''
            ) 
        ));
        $this->assertTrue($result);
    }

    public function testJSONCheckerHaveToReturnFlaseIfJsonNotEqualsToRules() {
        $json = json_decode(json_encode(array(
            'attr_2' => 'value'
        )));
        $result = \JSONRulesChecker\JSONChecker::checkJSON($json, array(
            'attr_1' => ''
        ));

        $this->assertFalse($result);
    }

    public function testReturnFalseIfRulesAndJsonNotCorrect() {
        $json = json_decode(json_encode(array(
            'root' => array(
                'int_attr' => '123124',
                'str_attr' => 'only word shere',
                'another_array' => array(
                    'attr1' => '111',
                    'attr2' => 'www'
                ),
                'attr2' => 'hi',
            )
        )));

        $result = \JSONRulesChecker\JSONChecker::checkJSON($json, array(
            'root' => array(
                'int_attr' => '/^\d+$/',
                'str_attr' => '',
                'another_array' => array(
                    'attr1' => '',
                    'attr2' => '/www/'
                ),
                'attr2' => '<string>'
            ) 
        ));
        $this->assertFalse($result);
    }
}
