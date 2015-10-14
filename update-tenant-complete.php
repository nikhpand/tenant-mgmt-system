<?php
  require_once("Includes/db.php");
  
  $result = TenantDB::getInstance()->update_tenant_details("'" . $_POST['tenantId'] . "'", "'" . $_POST['first_name'] . "'",
                                                 "'" . $_POST['last_name'] . "'", "'" . $_POST['ssn'] . "'",
                                                 "'" . $_POST['current_address'] . "'",  "'" . $_POST['email'] . "'",
                                                 "'" . $_POST['phone'] . "'");
  if (!$result) {
    printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
    exit();
  }                                                                         
  header('Location: tenants.php?aptNum=' . $_POST['aptNum'] . '&buildingName=' . $_POST['buildingName']);
?>