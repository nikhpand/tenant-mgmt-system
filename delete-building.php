<?php
  require_once("Includes/db.php");
  
  $result = TenantDB::getInstance()->delete_building("'" . $_GET['buildingName'] . "'");
  if (!$result) {
    printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
    exit();
  }                                                                         
  header('Location: buildings.php' );   
?>