<?php
  require_once("Includes/db.php");
  
  $result = TenantDB::getInstance()->delete_apartment("'" . $_GET['buildingName'] . "'", "'" . $_GET['aptNum'] . "'");
  if (!$result) {
    printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
    exit();
  }                                                                         
  header('Location: apartments.php?buildingName=' . $_GET['buildingName']);   
?>