<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Update Apartment Details</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>
            Update details for Apartment#<?php echo $_GET['aptNum']; ?> for Building <?php echo $_GET['buildingName']; ?>
        </h1>
        <form name="AddApt" action="update-apt-complete.php" method="post">
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            Apartment Type :
            <input type="text" name="aptType" value=<?php echo $_GET['aptType']; ?> /><br/><br/>
            Rent :
            <input type="text" name="amount" value=<?php echo $_GET['amount']; ?> /><br/><br/>            
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />
            <input type="submit" style="cursor:pointer" value="Update"/>
        </form>
    </body>
</html>