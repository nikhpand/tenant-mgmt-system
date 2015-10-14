<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add Rent Confirmation</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
            <?php
            require_once("Includes/db.php");            
            $result = TenantDB::getInstance()->add_rent_for_leaseId("'" . $_POST['leaseId'] . "'", "'" . $_POST['dueDate'] . "'",
                                                                         "'" . $_POST['lateFee'] . "'", "'" . $_POST['amount'] . "'");
            if (!$result) {
              printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
              exit();
            }
            ?>
        New Rent Successfully Added !!    
        <form name="addRent" action="rent-payment.php">
            <input type="hidden" name="aptNum" value=<?php echo $_POST['aptNum']; ?> />
            <input type="hidden" name="buildingName" value=<?php echo $_POST['buildingName']; ?> />            
            <input type="hidden" name="leaseId" value=<?php echo $_POST['leaseId']; ?> />
            <input type="submit" style="cursor:pointer" value="Return"/>
        </form>
    </body>
</html>