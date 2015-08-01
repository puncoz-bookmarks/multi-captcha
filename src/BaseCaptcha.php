<?php
/**
 * Created by PhpStorm.
 * User: Sameer Shelavale
 * Date: 5/14/14
 * Time: 5:41 PM
 * Provides basic functions of captcha class
 */
namespace MultiCaptcha;

class BaseCaptcha {
    var $language = 'en';
    var $tooltip = array();

    var $secretKey = '';
    var $life = 1;         //life/validity time of captcha in hours
    var $customFieldName = null;
    var $cipherIsFieldName = true;
    var $theme = 'Default';
    var $themeOptions = array();
    var $errorMsg = "Your answer for the captcha challenge was wrong.";

    public function __construct( $secKey, $captchaLife, $customFieldName = null ){
        $this->secretKey = $secKey;
        $this->life = $captchaLife;
        $this->customFieldName = $customFieldName;
    }

    /*
     * function generate()
     * @return  generate captcha details as array
     *          the array includes fields like cipher, question, customFieldName, tooltip etc.
     *          This data in turn is used for rendering the captcha
     */
    public function generate(){

        $data = $this->generateQuestion();

        $data['customFieldName'] = $this->customFieldName;
        if( is_array( $this->tooltip ) ){
            $data['tooltip'] = isset( $this->tooltip[ $this->language ] )? $this->tooltip[ $this->language ]: '';
        }elseif( is_string( $this->tooltip ) ){
            $data['tooltip'] = $this->tooltip;
        }

        $data['theme'] = $this->theme;
        $data['themeOptions'] = $this->themeOptions;

        return $data;
    }


    public function setParams( $options = array() ){
        //get all properties of the class and
        //make an array with property name as key and lowercase name as value
        $properties = [];
        foreach( get_class_vars( get_class( $this) ) as $key => $value ){
            $properties[ $key ] = strtolower( $key );
        }
        //check if lowercase of key exists in lowercase properties
        foreach( $options as $key => $value ){
            if( $prop = array_search( strtolower( $key), $properties ) ){
                $this->$prop = $value;
            }
        }
    }



    /***********************************************************************
     * function generateQuestion()
     * @return array() returns captcha question data as array.
     * following elements are required to be passed
     *      question    - will contain html of any image, video or even main text of the question
     *      description - will be text description of the question telling what is expected
     *      answer      - the correct answer
     *      tooltip     - will contain help text for solving the captcha
     *      refreshUrl  - url to refresh the captcha
     *
     ***********************************************************************/
    public function generateQuestion(){
        return array(
            'question'  => null,
            'description'=>null,
            'answer'    => null,
            'tooltip'   => null,
            'refreshUrl'=> null
        );
    }


} 