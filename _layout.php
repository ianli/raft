<?php include_once("php/raft.php"); ?>
<html>
<head>
  <title><?php echo raft("title"); ?></title>
</head>
<body>
  <h1><?= raft("title"); ?></h1>
  <?php raft("content"); ?>
</body>
</html>