<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Add Tenant</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
            <?php
            require_once("Includes/db.php");
            $result = TenantDB::getInstance()->get_all_lease("'" . $_GET['buildingName'] . "'", "'" . $_GET['aptNum'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            ?>         
        
        
        <h1>
            Add new Tenant for Building <?php echo $_GET['buildingName']; ?>, Apartment# <?php echo $_GET['aptNum']; ?>
        </h1>
        Select Lease :
        <select name="lease" form="addTen">
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "<option value=\"" . htmlentities($row['LEASE_ID']) . "\">" . htmlentities($row['LEASE_ID']) . "</option>";
            }
            mysqli_free_result($result);
            ?>
        </select> <br/><br/>       
        <form name="addTenant" id="addTen" action="add-tenant-complete.php" method="post">
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            First Name :
            <input type="text" name="first_name" value="" /><br/><br/>
            Last Name :
            <input type="text" name="last_name" value="" /><br/><br/>
            ssn :
            <input type="text" name="ssn" value="" /><br/><br/>
            Current Address :
            <input type="text" name="current_address" value="" /><br/><br/>
            Email :
            <input type="text" name="email" value="" /><br/><br/>
            Phone :
            <input type="text" name="phone" value="" /><br/><br/>            
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />
            <input type="submit" style="cursor:pointer" value="Add Tenant"/>
        </form>
        <br/><br/>
        <h2>
            Add New Lease
        </h2>
        <form name="lease" action="add-lease.php" method="post">
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />
            <input type="submit" style="cursor:pointer" value="Add Lease" />
        </form>
        <br/><br/>
        <form name="goBack" action="tenants.php">
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            <input type="submit" style="cursor:pointer" value="Return" />
        </form>        
    </body>
</html>