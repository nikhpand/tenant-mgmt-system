<?php
  require_once("Includes/db.php");
  
  $result = TenantDB::getInstance()->add_new_lease("'" . $_POST['aptNum'] . "'", "'" . $_POST['buildingName'] . "'",
                                                 "'" . $_POST['start_date'] . "'", "'" . $_POST['end_date'] . "'",
                                                 "'" . $_POST['rental_date'] . "'", "'" . $_POST['deposit'] . "'");
  if (!$result) {
    printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
    exit();
  }                                                                         
  header('Location: add-tenant.php?aptNum=' . $_POST['aptNum'] . '&buildingName=' . $_POST['buildingName']);
?>