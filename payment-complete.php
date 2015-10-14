<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Payment Confirmation</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
            <?php
            require_once("Includes/db.php");            
            $result = TenantDB::getInstance()->update_payment_for_rentId("'" . $_POST['rentId'] . "'", "'" . $_POST['payDate'] . "'",
                                                                         "'" . $_POST['payType'] . "'", "'" . $_POST['amount'] . "'");
            if (!$result) {
              printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
              exit();
            }
            ?>
        Payment Successfully Updated !!    
        <form name="Payment" action="rent-payment.php">
            <input type="hidden" name="aptNum" value=<?php echo $_POST['aptNum']; ?> />
            <input type="hidden" name="buildingName" value=<?php echo $_POST['buildingName']; ?> />            
            <input type="hidden" name="leaseId" value=<?php echo $_POST['leaseId']; ?> />
            <input type="submit" style="cursor:pointer" value="Return"/>
        </form>
    </body>
</html>