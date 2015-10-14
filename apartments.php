<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Apartments</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>
            Apartments for building <?php echo $_GET['buildingName']; ?>
        </h1>
        <table class="std">
            <tr>
                <th>Apartment #</th>
                <th>Building</th>
                <th>Type</th>
                <th>Rent</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            require_once("Includes/db.php");
            $result = TenantDB::getInstance()->get_apartments_by_building("'" . $_GET['buildingName'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td 
                     style=\"cursor:pointer;color:#069\" onclick=\"location.href='tenants.php?aptNum="
                     . htmlentities($row['APT_NUMBER']) . "&buildingName=" . $_GET['buildingName'] .
                     "'\">&nbsp;" . htmlentities($row['APT_NUMBER']) . "</td>";
                     
                echo "<td>&nbsp;" . htmlentities($row['BUILDING_NAME']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['APT_TYPE']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['RENTAL_FEES']) . "</td>";
                echo "<td>&nbsp;<a style=\"cursor:pointer;color:#069\" onclick=\"location.href='delete-apt.php?buildingName="
                     . htmlentities($row['BUILDING_NAME']) . "&aptNum=" . htmlentities($row['APT_NUMBER']) . "'\">Delete</a></td>";
                echo "<td>&nbsp;<a style=\"cursor:pointer;color:#069\" onclick=\"location.href='update-apt.php?buildingName="
                     . htmlentities($row['BUILDING_NAME']) . "&aptNum=" . htmlentities($row['APT_NUMBER']). "&aptType="
                     . htmlentities($row['APT_TYPE']) . "&amount=" . htmlentities($row['RENTAL_FEES'])
                     . "'\">Update</a></td></tr>\n";                     
            }
            mysqli_free_result($result);
            ?>
        </table>
        <form name="AddApt" action="add-apt.php" method="post">
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />
            <input type="submit" style="cursor:pointer" value="Add" />
        </form> 
        <br/><br/>
        <form name="goBack" action="buildings.php">
            <input type="submit" style="cursor:pointer" value="Return" />
        </form>        
    </body>
</html>