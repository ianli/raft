<?php
  include_once("php/raft.php");

  $raft["title"] = "My Web Page.";
  
  function raft_content() {
    echo "Hello World!";
  }
  
  rafting("footer");
  
  echo "This is the footer";
  
  end_rafting("footer");
  
  include("_layout.php");
?>