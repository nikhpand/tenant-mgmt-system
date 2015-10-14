<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Tenant Details</title>
        <link href="tma.css" type="text/css" rel="stylesheet" media="all" />
    </head>
    <body>
        <h1>
            Tenant Details
        </h1>
        <table class="std">
            <tr>
                <th>Name</th>
                <th>SSN</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <?php
            require_once("Includes/db.php");
            $result = TenantDB::getInstance()->get_tenant_details("'" . $_GET['tenantId'] . "'");
            if (!$result) {
               printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
               exit();
            }
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr><td>&nbsp;" . htmlentities($row['first_name']) . " " . htmlentities($row['last_name']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['ssn']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['current_address']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['email']) . "</td>";
                echo "<td>&nbsp;" . htmlentities($row['phone']) . "</td></tr>\n";
            }
            mysqli_free_result($result);
            ?>
        </table>
    </body>
</html>