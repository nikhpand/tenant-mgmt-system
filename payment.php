<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Payment</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>
            Make payment for lease Id <?php echo $_GET['leaseId']; ?> , rent Id <?php echo $_GET['rentId']; ?> : $<?php echo $_GET['amount']; ?>
        </h1>
        <form name="Payment" action="payment-complete.php" method="post">
            Payment Date :
            <input type="date" name="payDate" value="" /><br/><br/>
            Payment Type :
            <input type="text" name="payType" value="" /><br/><br/>
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />            
            <input type="hidden" name="amount" value=<?php echo $_GET['amount']; ?> />
            <input type="hidden" name="rentId" value=<?php echo $_GET['rentId']; ?> />
            <input type="hidden" name="leaseId" value=<?php echo $_GET['leaseId']; ?> />
            <input type="submit" style="cursor:pointer" value="Make Payment"/>
        </form>
        <br/><br/>
        <form name="Payment" action="rent-payment.php">
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />            
            <input type="hidden" name="leaseId" value=<?php echo $_GET['leaseId']; ?> />
            <input type="submit" style="cursor:pointer" value="Return"/>
        </form>        
    </body>
</html>