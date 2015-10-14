<?php
  require_once("Includes/db.php");
  
  $result = TenantDB::getInstance()->add_new_building("'" . $_POST['buildName'] . "'", "'" . $_POST['buildAddress'] . "'");
  if (!$result) {
    printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
    exit();
  }                                                                         
  header('Location: buildings.php' );
?>