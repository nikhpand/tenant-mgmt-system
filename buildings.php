<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Buildings</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>
            Available Buildings
        </h1>
        <table class="std">
            <tr>
                <th>Building</th>
                <th>Address</th>
                <th></th>
            </tr>
            <?php
            require_once("Includes/db.php");
            $result = TenantDB::getInstance()->get_buildings_by_name("'%'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td 
                     style=\"cursor:pointer;color:#069\" onclick=\"location.href='apartments.php?buildingName="
                     . htmlentities($row['BUILDING_NAME']) .
                     "'\">&nbsp;" . htmlentities($row['BUILDING_NAME']) . "</td>";
                     
                echo "<td>&nbsp;" . htmlentities($row['ADDRESS']) . "</td>";
                
                echo "<td>&nbsp;<a style=\"cursor:pointer;color:#069\" onclick=\"location.href='delete-building.php?buildingName="
                     . htmlentities($row['BUILDING_NAME']) ."'\">Delete</a></td></tr>\n";
            }
            mysqli_free_result($result);
            ?>
        </table>
        <form name="AddBuild" action="add-build.php">
            <input type="submit" style="cursor:pointer" value="Add" />
        </form>          
    </body>
</html>

<!--echo "&nbsp;<a href=\"delete-building.php?buildingName=\">Delete</a>\n";-->