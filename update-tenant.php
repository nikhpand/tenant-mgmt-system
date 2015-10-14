<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Update Tenant Details</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
            <?php
            require_once("Includes/db.php");
            $result = TenantDB::getInstance()->get_tenant_details("'" . $_GET['tenantId'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            $row = mysqli_fetch_array($result);
            mysqli_free_result($result);
            ?>         
        <h1>
            Update details for Tenant <?php echo $row['first_name']; ?> <?php echo $row['last_name']; ?>
        </h1>
        
        <form name="updateTenant" action="update-tenant-complete.php" method="post">
            <input type="hidden" name="aptNum" value=<?php echo $_GET['aptNum']; ?> />
            First Name :
            <input type="text" name="first_name" value=<?php echo $row['first_name']; ?> /><br/><br/>
            Last Name :
            <input type="text" name="last_name" value=<?php echo $row['last_name']; ?> /><br/><br/>
            ssn :
            <input type="text" name="ssn" value=<?php echo $row['ssn']; ?> /><br/><br/>
            Current Address :
            <input type="text" name="current_address" value=<?php echo $row['current_address']; ?> /><br/><br/>
            Email :
            <input type="text" name="email" value=<?php echo $row['email']; ?> /><br/><br/>
            Phone :
            <input type="text" name="phone" value=<?php echo $row['phone']; ?> /><br/><br/>            
            <input type="hidden" name="buildingName" value=<?php echo $_GET['buildingName']; ?> />
            <input type="hidden" name="tenantId" value=<?php echo $_GET['tenantId']; ?> />
            <input type="submit" style="cursor:pointer" value="Update"/>
        </form>
    </body>
</html>