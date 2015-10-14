<?php
  require_once("Includes/db.php");
  
  $result = TenantDB::getInstance()->delete_tenant("'" . $_GET['tenantId'] . "'");
  if (!$result) {
    printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
    exit();
  }                                                                         
  header('Location: tenants.php?aptNum=' . $_GET['aptNum'] . '&buildingName=' . $_GET['buildingName']);
?>