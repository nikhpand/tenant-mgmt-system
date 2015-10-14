<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add Apartment</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>
            Add new Apartment for Building <?php echo $_POST['buildingName']; ?>
        </h1>
        <form name="AddApt" action="add-apt-complete.php" method="post">
            Apartment Number :
            <input type="text" name="aptNum" value="" /><br/><br/>
            Apartment Type :
            <input type="text" name="aptType" value="" /><br/><br/>
            Rent :
            <input type="text" name="amount" value="" /><br/><br/>            
            <input type="hidden" name="buildingName" value=<?php echo $_POST['buildingName']; ?> />
            <input type="submit" style="cursor:pointer" value="Add Apartment"/>
        </form>
    </body>
</html>