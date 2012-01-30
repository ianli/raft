<?php
/*
 * RAFT Ain't For Templating
 * Version 1.0.0
 * http://github.com/ianli/raft/
 *
 * Copyright 2010-2012 Ian Li, http://ianli.com/
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
 *
 * RAFT is a simple implementation for templates.
 * It takes advantage of the fact that PHP, in itself, is already a good templating system.
 * Building a big templating system on top of PHP is too much overhead.
 */
 
// Function to use the features of RAFT more conveniently.
function raft() {
  static $raftObject;
  
  if (!isset($raftObject)) {
    $raftObject = new RAFT();
  }
  
  if (func_num_args() == 0) {
    
    // There is no argument, so return the $raft object.
    return $raftObject->getValues();
    
  } else if (func_num_args() == 1) {
    
    // There is only one argument, check the type of $arg.
    
    $arg = func_get_arg(0);
    
    if (is_array($arg)) {
      
      // $arg is an array, so merge its values.
      
      $raftObject->setValues($arg);
      
    } else if (is_string($arg)) {
      
      // $arg is a string.
      
      if ($arg == "!CLEAR") {
        
        $raftObject->clear();
        
      } else if (preg_match("/^!BEGIN\:(\w+(\.\w+)*)$/", $arg, $matches)) {
        
        $raftObject->beginCapture($matches[1]);
        
      } else if (preg_match("/^!END\:(\w+(\.\w+)*)$/", $arg, $matches)) {
        
        $raftObject->endCapture($matches[1]);
        
      } else if (preg_match("/^(\w+(\.\w+)*)$/", $arg, $matches)) {
        
        return $raftObject->getValue($arg);
        
      }
    
    } else if (is_integer($arg)) {
      
      return $raftObject->getValue($arg);
      
    } else {
      
      throw new Exception("\$arg must be an array, string, or number.");
    
    }
		
	} else {
		
		// There is more than one value, so we must be assigning value.
		$key = func_get_arg(0);
		$value = func_get_arg(1);
		
		$raftObject->setValue($key, $value);
	
	}

}


// A RAFT object implements the functionality of RAFT.
class RAFT {
  
  /////////////////////////////////////
  // CLASS METHODS ////////////////////
  /////////////////////////////////////
  
  // Validate the key. If key is invalid, throw an error. 
  static function validateKey($key) {
    if (preg_match("/^\w+(\.\w+)*$/", $key, $matches)) {
      // Do nothing.
    } else {
      throw new Exception("Argument \$key is invalid");
    }
  }
  
  
  /////////////////////////////////////
  // INSTANCE VARIABLES ///////////////
  /////////////////////////////////////
  
  private $data = array();
  
  private $captureKey = null;
  
  
  /////////////////////////////////////
  // INSTANCE METHODS /////////////////
  /////////////////////////////////////
  
  // Clears the values.
  function clear() {
    $this->data = array();
  }
  
  // Begins capture of output buffer for value of $key.
  function beginCapture($key) {
    RAFT::validateKey($key);
    
    if ($this->captureKey != null) {
      throw new Exception("Cannot begin capture of $key. Capture of {$this->captureKey} is pending.");
    }
    
    $this->captureKey = $key;
    
    ob_start();
  }
  
  // Ends capture of output buffer for value of $key.
  function endCapture($key) {
    RAFT::validateKey($key);
    
    if ($this->captureKey != $key) {
      throw new Exception("Expected to capture {$this->captureKey}, but received ${key}");
    }
    
    $value = ob_get_contents();
    ob_end_clean();
    
    $this->setValue($key, $value);
    $this->captureKey = null;
  }
  
  // Returns the values.
  function getValues() {
    return $this->data;
  }
  
  // Merge the values of the array.
  function setValues($array) {
    foreach ($array as $key => $value) {
      $this->setValue($key, $value);
    }
  }
  
  // Sets the value of the specified key.
  function setValue($key, $value) {
    RAFT::validateKey($key);
    
    $this->setValueHelper($this->data, $key, $value);
  }
  
  // Gets the value of the specified key.
  function getValue($key) {
    RAFT::validateKey($key);

    if ($this->keyExists($this->data, $key)) {
      
      return $this->getValueHelper($this->data, $key);
      
    } else {
      
      // $key is not in $raft, so it might be a function prefixed "raft_".
      $fn = "raft_$key";

      if (function_exists($fn)) {

        // If there is more than one argument to raft,
        // grab the arguments except the first one (which is $id).
        // These arguments are passed to the function identified by "raft_$id"
        $args = array();
        if (($num_args = func_num_args()) > 1) {
          $args = func_get_args();
          $args = array_slice($args, 1);
        }

        // Call the function and pass the arguments also.
        return call_user_func_array($fn, $args);
      }
      
    }
  }
  
  
  /////////////////////////////////////
  // PRIVATE METHODS //////////////////
  /////////////////////////////////////
  
  private function setValueHelper(&$array, $key, $value) {
    $tokens = preg_split("/\./", $key);
    if (count($tokens) > 1) {
      $firstKey = array_shift($tokens);
      $remainingKeys = implode(".", $tokens);
      
      if (!is_array($array[$firstKey])) {
        $array[$firstKey] = array();
      }
      
      $this->setValueHelper($array[$firstKey], $remainingKeys, $value);
    } else {
      $array[$key] = $value;
    }
  }
  
  private function getValueHelper(&$array, $key) {
    $tokens = preg_split("/\./", $key);
    if (count($tokens) > 1) {
      $firstKey = array_shift($tokens);
      $remainingKeys = implode(".", $tokens);
      
      if (array_key_exists($firstKey, $array) && is_array($array[$firstKey])) {
        return $this->getValueHelper($array[$firstKey], $remainingKeys);
      }
    } else {
      // if (array_key_exists($key, $array)) {
      //   return $array[$key];
      // }
      
      if (array_key_exists($key, $array)) {
        $value = $array[$key];
        
        if (is_callable($value)) {
          ob_start();
          $return = $value();
          $output = ob_get_contents();
          ob_end_clean();
          
          return ($return) ? $return : $output;
        } else {
          return $value;
        }
      }
    }
  }
  
  private function keyExists(&$array, $key) {
    $tokens = preg_split("/\./", $key);
    if (count($tokens) > 1) {
      $firstKey = array_shift($tokens);
      $remainingKeys = implode(".", $tokens);
      
      if (array_key_exists($firstKey, $array) && is_array($array[$firstKey])) {
        return $this->keyExists($array[$firstKey], $remainingKeys);
      } else {
        return false;
      }
    } else {
      return array_key_exists($key, $array);
    }
  }
}

?>