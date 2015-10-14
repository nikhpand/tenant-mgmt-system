<?php
  require_once("Includes/db.php");
  
  $result = TenantDB::getInstance()->add_new_apt("'" . $_POST['aptNum'] . "'", "'" . $_POST['aptType'] . "'",
                                                 "'" . $_POST['amount'] . "'", "'" . $_POST['buildingName'] . "'");
  if (!$result) {
    printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
    exit();
  }                                                                         
  header('Location: apartments.php?buildingName=' . $_POST['buildingName']);
?>