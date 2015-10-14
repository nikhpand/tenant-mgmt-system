<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add Lease</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>
            Add new Lease for Building <?php echo $_POST['buildingName']; ?>, Apartment# <?php echo $_POST['aptNum']; ?>
        </h1>
        <form name="addLease" action="add-lease-complete.php" method="post">
            <input type="hidden" name="aptNum" value=<?php echo $_POST['aptNum']; ?> />
            Start Date :
            <input type="date" name="start_date" value="" /><br/><br/>
            End Date :
            <input type="date" name="end_date" value="" /><br/><br/>
            Rental Date :
            <input type="date" name="rental_date" value="" /><br/><br/>
            Deposit :
            <input type="text" name="deposit" value="" /><br/><br/>            
            <input type="hidden" name="buildingName" value=<?php echo $_POST['buildingName']; ?> />
            <input type="submit" style="cursor:pointer" value="Add"/>
        </form>
        <br/><br/>
        <form name="goBack" action="add-tenant.php">
            <input type="hidden" name="buildingName" value=<?php echo $_POST['buildingName']; ?> />
            <input type="hidden" name="aptNum" value=<?php echo $_POST['aptNum']; ?> />
            <input type="submit" style="cursor:pointer" value="Return" />
        </form>        
    </body>
</html>