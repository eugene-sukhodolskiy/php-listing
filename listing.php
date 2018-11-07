<?php
class Listing{
  private $data;
  public $length;

  public function __construct($d){
    $this -> data = $d;
    $this -> length = count($d);
    $this -> each(function($self, $i, $val){
      if(is_array($val)){
        $this -> set($i, new Listing($val));
      }
    });
  }

  public function __get($name){
    if(isset($this -> data[$name])){
      return $this -> data[$name];
    }

    if($name[0] == 'i'){
      list(,$index) = explode('i', $name);
      $index = intval($index);
      if(isset($this -> data[$index])){
        return $this -> get($index);
      }
    }

    return null;

  }

  public function __set($name, $value){
    if(isset($this -> data[$name])){
      $this -> data[$name] = $value;
      return $value;
    }

    if($name[0] == 'i'){
      list(,$index) = explode('i', $name);
      $index = intval($index);
      if(isset($this -> data[$index])){
        $this -> set($index, $value);
        return $value;
      }
    }

    return null;
  }

  public function keys(){
    return array_keys($this -> data);
  }

  public function get($index){
    if(is_int($index) and $index < 0){
      $index = $this -> length + $index;
    }
    return $this -> data[$index];
  }

  public function all(){
    return $this -> data;
  }

  public function set($index, $val){
    if(is_int($index) and $index < 0){
      $index = $this -> length + $index;
    }
    $this -> data[$index] = $val;
    return $val;
  }

  public function last(){
    return $this -> get($this -> length - 1);
  }

  public function first(){
    return $this -> get(0);
  }

  public function append($val){
    if(is_array($val)){
      return $this -> merge($val);
    }
    $this -> data[] = $val;
    $this -> length ++;
    return $val;
  }

  public function push($val){
    return $this -> append($val);
  }

  public function pop(){
    $res = array_pop($this -> data);
    if($res){
      $this -> length --;
      return $res;
    }
  }

  public function merge($arr){
    if(!is_array($arr)){
      return false;
    }
    $this -> data = array_merge($this -> data, $arr);
    return true;
  }

  public function splice($offset, $len = null, $preserv_keys = false){
    return new Listing(array_splice($this -> data, $offset, $len, $preserv_keys));
  }

  public function remove($index){
    if(is_int($index) and $index < 0){
      $index = $this -> length + $index;
    }

    if(is_int($index) and $index > $this -> length - 1){
      return false;
    }

    unset($this -> data[$index]);
    $this -> length --;
    return true;
  }

  public function each($callback){
    foreach($this -> data as $i => $val){
      $callback($this, $i, $val);
    }
  }

  public function dump($tag_pre = false){
    if($tag_pre)
      echo '<pre>';
    return var_dump($this -> data);
  }

  public function search($search){
    return array_search($search, $this -> data);
  }

}

 ?>
