<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add Rent</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>
            Add new rent for lease Id <?php echo $_GET['leaseId']; ?>
        </h1>
        <form name="AddRent" action="add-rent-complete.php" method="post">
            Amount :
            <input type="text" name="amount" value="" /><br/><br/>
            Late fee :
            <input type="text" name="lateFee" value="" /><br/><br/>            
            Due Date :
            <input type="date" name="dueDate" value="" /><br/><br/>
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />            
            <input type="hidden" name="leaseId" value=<?php echo $_GET['leaseId']; ?> />
            <input type="submit" style="cursor:pointer" value="Add Rent"/>
        </form>
        <br/><br/>
        <form name="addRent" action="rent-payment.php">
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />            
            <input type="hidden" name="leaseId" value=<?php echo $_GET['leaseId']; ?> />
            <input type="submit" style="cursor:pointer" value="Return"/>
        </form>        
    </body>
</html>