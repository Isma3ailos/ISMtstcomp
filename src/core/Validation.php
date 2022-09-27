<?php
namespace Odc\Mvc\core;

class Validation{
    private $pattern = [
        'uri'           => '[A-Za-z0-9-\/_?&=]+',
        'url'           => '[A-Za-z0-9-:.\/_?&=#]+',
        'alpha'         => '[\p{L}]+',
        'words'         => '[\p{L}\s]+',
        'alphanum'      => '[\p{L}0-9]+',
        'int'           => '[0-9]+',
        'float'         => '[0-9\.,]+',
        'tel'           => '[0-9+\s()-]+',
        'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+',
        'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
        'folder'        => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+',
        'address'       => '[\p{L}0-9\s.,()°-]+',
        'date_dmy'      => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
        'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
        'email'         => '[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})',
    ];
    private $error = [];
    private $input;
    private $value;

    public function input($input){
        
        if(!isset($_REQUEST[$input])){
            $this->error[] = "Input $input Not Exist";
        }else{
            $this->input = $_REQUEST[$input];
        }
        return $this;
    }
    public function value(){
        $this->value = $this->input;
        return $this;
    }
    public function max($max){
        if(strlen($this->value) > $max ){
            $this->error [] = "input $this->input must be $max";
        }
        return $this;
    }
    public function min($min){
        if(strlen($this->value) < $min ){
            $this->error [] = "input $this->input must be $min";
        }
        return $this;
    }
    public function required(){
        if(empty($this->value) && strlen($this->value) == 0 && $this->value == ""){
            $this->error [] = "input : $this->input must be required";
        }
        return $this;
    }
    public function email(){
        $regex = '/^('.$this->pattern['email'].')$/u';
        if(!preg_match($regex,$this->value)){
            $this->error [] = "input : $this->input must be email";
        }
        return $this;
    }
    public function intger(){
        $regex = '/^('.$this->pattern['int'].')$/u';
        if(!preg_match($regex,$this->value)){
            $this->error [] = "input : $this->input must be intger";
        }
        return $this;
    }
    public function float(){
        $regex = '/^('.$this->pattern['float'].')$/u';
        if(!preg_match($regex,$this->value)){
            $this->error [] = "input : $this->input must be float";
        }
        return $this;
    }
    public function string(){
        $regex = '/^('.$this->pattern['words'].')$/u';
        if(!preg_match($regex,$this->value)){
            $this->error [] = "input : $this->input must be words";
        }
        return $this;
    }
    public function showError(){
        if(!empty($this->error)){
            echo "<ul>";
            foreach($this->error as $err){
                echo "<li style='color:red'>$err</li>";
            }
            echo "</ul>";
        }
    }  
      public function returnerror(){
        if(!empty($this->error)){
            
            foreach($this->error as $err){
            return false;
            }
            
        }
    }
    public function success(){
        return (empty($this->error)) ? true :false;
    }

}
?>