<?php
  include_once("php/raft.php");
  
  # Assigning values.
  
  # String key
  raft("string", "Assigned value to a string key.");
  
  # Numeric key
  raft(2, "Assigned value to a numeric key.");
  
  # Nested key
  raft("first.second.third", "Assigned value to a nested key.");
  
  # Assign to a key an anonymous function that outputs values.
  raft("anonymous_function1", function() {
    echo "Used the output of an anonymous function.";
  });
  
  # Assign to a key an anonymous function that returns a value.
  raft("anonymous_function2", function() {
    return "Used the return value of an anonymous function.";
  });
  
  # Multiple assignment
  raft(array(
    "multiple_assignment1" => "1st value of multiple assignment.",
    "multiple_assignment2" => "2nd value of multiple assignment."
  ));
  
  # Global function that outputs values.
  function raft_function1() {
    echo "Used a function's output.";
  }
  
  # Global function that returns a value.
  function raft_function2() {
    return "Used a function that returns a value.";
  }
  
  # Output buffering
  raft("!BEGIN:output_buffering");
  echo "Captured value using output buffering.";
  raft("!END:output_buffering");
  
  # Output buffering with nested key.
  raft("!BEGIN:ob.nested.key");
  echo "Captured value using output buffering with nested key";
  raft("!END:ob.nested.key");
  
  include("_layout.php");
?>