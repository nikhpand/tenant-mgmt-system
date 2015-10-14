<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Tenants</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>
            Tenants for building <?php echo $_GET['buildingName']; ?> apartment #<?php echo $_GET['aptNum']; ?>
        </h1>
        <table class="std">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Lease Id</th>
                <th>Details</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            require_once("Includes/db.php");
            $result = TenantDB::getInstance()->get_tenants_by_apartment("'" . $_GET['buildingName'] . "'", "'" . $_GET['aptNum'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td 
                     style=\"cursor:pointer;color:#069\" onclick=\"location.href='tenant-details.php?tenantId="
                     . htmlentities($row['TENANT_ID']) .
                     "'\">&nbsp;" . htmlentities($row['first_name']) . " " . htmlentities($row['last_name']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['email']) . "</td>";
                echo "<td 
                     style=\"cursor:pointer;color:#069\" onclick=\"location.href='lease-details.php?aptNum="
                     . $_GET['aptNum'] . "&buildingName=" . $_GET['buildingName']. "&fname="
                     . htmlentities($row['first_name']) . "&lname=" . htmlentities($row['last_name']) . "&leaseId="
                     . htmlentities($row['LEASE_ID']) . 
                     "'\">&nbsp;" . htmlentities($row['LEASE_ID']) . "</td>";
                echo "<td 
                     style=\"cursor:pointer;color:#069\" onclick=\"location.href='rent-payment.php?leaseId="
                     . htmlentities($row['LEASE_ID']) . "&aptNum=" . $_GET['aptNum'] .  "&buildingName=" . $_GET['buildingName'] .  
                     "'\">&nbsp; Rent </td>";
                echo "<td>&nbsp;<a style=\"cursor:pointer;color:#069\" onclick=\"location.href='delete-tenant.php?buildingName="
                     . $_GET['buildingName'] . "&aptNum=" . $_GET['aptNum'] . "&tenantId="
                     . htmlentities($row['TENANT_ID']) . "'\">Delete</a></td>";
                echo "<td>&nbsp;<a style=\"cursor:pointer;color:#069\" onclick=\"location.href='update-tenant.php?buildingName="
                     . $_GET['buildingName'] . "&aptNum=" . $_GET['aptNum'] . "&tenantId="
                     . htmlentities($row['TENANT_ID']) . "'\">Update</a></td></tr>\n";                     
            }
            mysqli_free_result($result);
            ?>
        </table>
        <form name="AddTenant" action="add-tenant.php">
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            <input type="submit" style="cursor:pointer" value="Add" />
        </form> 
        <br/><br/>
        <form name="goBack" action="apartments.php">
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />
            <input type="submit" style="cursor:pointer" value="Return" />
        </form>         
    </body>
</html>