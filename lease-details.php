<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Lease Details</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>
            Lease Details for building <?php echo $_GET['buildingName']; ?> apartment #<?php echo $_GET['aptNum']; ?>, tenant <?php echo $_GET['fname']; ?> <?php echo $_GET['lname']; ?>
        </h1>
        <table class="std">
            <tr>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Rental Date</th>
                <th>Deposit</th>
            </tr>
            <?php
            require_once("Includes/db.php");
            $result = TenantDB::getInstance()->get_lease_details("'" . $_GET['leaseId'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>&nbsp;" . htmlentities($row['START_DATE']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['END_DATE']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['RENTAL_DATE']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['DEPOSIT']) . "</td></tr>\n";
            }
            mysqli_free_result($result);
            ?>
        </table>
    </body>
</html>