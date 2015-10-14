<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Rent Payments</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
            <?php
            require_once("Includes/db.php");
            $result = TenantDB::getInstance()->get_lease_location("'" . $_GET['leaseId'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            $row = mysqli_fetch_array($result);
            mysqli_free_result($result);
            ?>            
        <h1>
            Rent and Payment details for building <?php echo $row[BUILDING_NAME]; ?> apartment #<?php echo $row[APARTMENT_NUMBER]; ?> with tenants
        </h1>
        <table class="std">
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php
            $result = TenantDB::getInstance()->get_tenants_by_lease("'" . $_GET['leaseId'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>&nbsp;" . htmlentities($row['first_name']) . " " . htmlentities($row['last_name']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['email']) . "</td></tr>\n";
            }
            mysqli_free_result($result);
            ?>
        </table>
        <h2>
            Pending Rents
        </h2>
        <table class="std">
            <tr>
                <th>Rent Id</th>
                <th>Amount</th>
                <th>Late Fee</th>
                <th>Due Date</th>
                <th>Action</th>
            </tr>
            <?php
            $result = TenantDB::getInstance()->get_pending_rents_for_lease("'" . $_GET['leaseId'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>&nbsp;" . htmlentities($row['rent_id']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['rent_fee']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['late_fee']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['due_date']) . "</td>";
                $amount = $row['rent_fee'] + $row['late_fee'];
                echo "<td 
                     style=\"cursor:pointer;color:#069\" onclick=\"location.href='payment.php?leaseId="
                     . $_GET['leaseId'] . "&rentId=" . htmlentities($row['rent_id']) . "&amount=" . $amount .
                     "&aptNum=" . $_GET['aptNum'] . "&buildingName=" . $_GET['buildingName'] .
                     "'\">&nbsp; Make payment </td></tr>\n";                
            }
            mysqli_free_result($result);
            ?>
        </table>  
        <form name="AddRent" action="add-rent.php">
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />            
            <input type="hidden" name="leaseId" value=<?php echo $_GET['leaseId']; ?> />
            <input type="submit" style="cursor:pointer" value="Add" />
        </form>        
        <h2>
            Rents History
        </h2>
        <table class="std">
            <tr>
                <th>Rent Id</th>
                <th>Amount</th>
                <th>Late Fee</th>
                <th>Due Date</th>                
            </tr>
            <?php
            $result = TenantDB::getInstance()->get_paid_rents_for_lease("'" . $_GET['leaseId'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>&nbsp;" . htmlentities($row['rent_id']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['rent_fee']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['late_fee']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['due_date']) . "</td></tr>\n";
            }
            mysqli_free_result($result);
            ?>
        </table>  
        <h2>
            Payments History
        </h2>
        <table class="std">
            <tr>
                <th>Payment Id</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Method</th>                
            </tr>
            <?php
            $result = TenantDB::getInstance()->get_payments_for_lease("'" . $_GET['leaseId'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>&nbsp;" . htmlentities($row['payment_id']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['pay_date']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['pay_amount']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['pay_method']) . "</td></tr>\n";
            }
            mysqli_free_result($result);
            ?>
        </table> 
        <br/><br/>
        <form name="Payment" action="tenants.php">
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />
            <input type="submit" style="cursor:pointer" value="Return"/>
        </form>        
    </body>
</html>