<?php

class TenantDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private static $username;
    private $password = "";
    private $dbName = "db_proj1";
    private static $dbHost;
    private $dbPort = 3306;
    private $con = null;


    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        
        self::$dbHost = getenv('IP');
        self::$username = getenv('C9_USER');
        
        parent::__construct(self::$dbHost, self::$username, $this->password, $this->dbName, $this->dbport);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }
    
    public function get_buildings_by_name($buildingName) {
        return $this->query("SELECT BUILDING_NAME, ADDRESS FROM building WHERE BUILDING_NAME LIKE" . $buildingName);
    }
    
    public function get_apartments_by_building($buildingName) {
        return $this->query("SELECT APT_NUMBER, BUILDING_NAME, APT_TYPE, RENTAL_FEES FROM appartment WHERE BUILDING_NAME =" . $buildingName);
    }    
    
    public function get_tenants_by_apartment($buildingName, $aptNum) {
        return $this->query("SELECT tenant.first_name, tenant.last_name, tenant.email, tenant.TENANT_ID, lease_tenant.LEASE_ID
                             FROM apartment_lease, lease_tenant, tenant
                             WHERE apartment_lease.BUILDING_NAME =" . $buildingName . "and
                                   apartment_lease.APARTMENT_NUMBER =" . $aptNum . "and
                                   apartment_lease.LEASE_ID = lease_tenant.LEASE_ID and
                                   tenant.TENANT_ID = lease_tenant.TENANT_ID");
    }  
    
    public function get_tenant_details($tenantId) {
        return $this->query("SELECT first_name, last_name, ssn, current_address, email, phone
                             FROM tenant
                             WHERE tenant.TENANT_ID =" . $tenantId);
    }  
    
    public function get_lease_details($leaseId) {
        return $this->query("SELECT START_DATE, END_DATE, RENTAL_DATE, DEPOSIT
                             FROM lease
                             WHERE lease.LEASE_ID =" . $leaseId);
    } 
    
    public function get_all_lease($buildingName, $aptNum) {
        return $this->query("SELECT LEASE_ID
                             FROM apartment_lease
                             WHERE apartment_lease.APARTMENT_NUMBER =" . $aptNum .
                             " and apartment_lease.BUILDING_NAME =" . $buildingName);
    }    
    
    public function get_lease_location($leaseId) {
        return $this->query("SELECT APARTMENT_NUMBER, BUILDING_NAME FROM apartment_lease WHERE LEASE_ID =" . $leaseId);
    }
    
    public function get_tenants_by_lease($leaseId) {
        return $this->query("SELECT tenant.first_name, tenant.last_name, tenant.email
                             FROM lease_tenant, tenant
                             WHERE lease_tenant.LEASE_ID =" . $leaseId . "and
                                   tenant.TENANT_ID = lease_tenant.TENANT_ID");
    }     
    
    public function get_pending_rents_for_lease($leaseId) {
        return $this->query("SELECT rent.rent_id, rent.rent_fee, rent.late_fee, rent.due_date
                             FROM lease_rent, rent
                             WHERE lease_rent.LEASE_ID =" . $leaseId . "and
                                   rent.RENT_ID = lease_rent.RENT_ID and
                                   rent.RENT_ID not in 
                                   (SELECT DISTINCT RENT_ID from rent_payment)");
    } 
    
    // Nikhil Fix add lease_rent
    public function get_paid_rents_for_lease($leaseId) {
        return $this->query("SELECT rent.rent_id, rent.rent_fee, rent.late_fee, rent.due_date
                             FROM rent, lease_rent
                             WHERE lease_rent.LEASE_ID =" . $leaseId . "and
                             rent.rent_id = lease_rent.rent_id  and
                             rent.RENT_ID in
                             (SELECT DISTINCT RENT_ID from rent_payment)");
    } 
    
    public function get_payments_for_lease($leaseId) {
        return $this->query("SELECT payment.payment_id, payment.pay_date, payment.pay_amount, payment.pay_method
                             FROM lease_rent, rent_payment, payment
                             WHERE lease_rent.LEASE_ID =" . $leaseId . "and
                                   rent_payment.RENT_ID = lease_rent.RENT_ID and
                                   payment.PAYMENT_ID = rent_payment.PAYMENT_ID");
    }   
    
    public function update_payment_for_rentId($rentId, $payDate, $payType, $amount) {
        
        $result1 = $this->query("INSERT INTO payment (payment_id,pay_date,pay_amount,pay_method) VALUES 
                                (NULL," . $payDate . ", " . $amount . ", " . $payType . ")");
 
            if (!$result1) {
              printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
              exit();
            } 
 
                                
        $result2 = $this->query("SELECT MAX(payment_id) FROM payment");
        $row = mysqli_fetch_array($result2);
        $paymentId = $row[0];
        
        $result3 = $this->query("INSERT INTO rent_payment (RENT_ID,PAYMENT_ID) VALUES 
                                (" . $rentId . ", " . $paymentId . ")");
                                
        return ($result1 && $result2 && $result3);
    } 
    
    public function add_rent_for_leaseId($leaseId, $dueDate, $lateFee, $amount) {
        
        $result1 = $this->query("INSERT INTO rent (rent_id,rent_fee,late_fee,due_date) VALUES 
                                (NULL," . $amount . ", " . $lateFee . ", " . $dueDate . ")");
 
            if (!$result1) {
              printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
              exit();
            } 
 
                                
        $result2 = $this->query("SELECT MAX(rent_id) FROM rent");
        $row = mysqli_fetch_array($result2);
        $rentId = $row[0];
        
        $result3 = $this->query("INSERT INTO lease_rent (RENT_ID,LEASE_ID) VALUES 
                                (" . $rentId . ", " . $leaseId . ")");
                                
        return ($result1 && $result2 && $result3);
    }   
    
    public function add_new_building($buildName, $buildAddress) {
        
        return $this->query("INSERT INTO building (BUILDING_NAME,ADDRESS) VALUES 
                                (" . $buildName . ", " . $buildAddress . ")");
    }     
    
    public function delete_building($buildName) {
        return $result1 = $this->query("delete from building where building_name=" . $buildName);;
    }      

    public function add_new_apt($aptNum, $aptType, $amount, $buildName) {
        
        return $this->query("INSERT INTO appartment (APT_NUMBER,BUILDING_NAME,APT_TYPE,RENTAL_FEES) VALUES 
                                (" . $aptNum . ", " . $buildName . ", " . $aptType . ", " . $amount . ")");
    } 
    
    public function delete_apartment($buildName, $aptNum) {
        return $result1 = $this->query("delete from appartment where building_name=" . $buildName . " and APT_NUMBER=" . $aptNum);
    }  
    
    public function update_apt_details($aptNum, $aptType, $amount, $buildName) {
        
        return $this->query("UPDATE appartment 
                             SET APT_TYPE=" . $aptType . ", RENTAL_FEES=" . $amount .
                             " WHERE APT_NUMBER=" . $aptNum . " and BUILDING_NAME=" . $buildName);
    } 
    
    public function update_tenant_details($tenantId, $fname, $lname, $ssn, $address, $email, $phone) {
        
        return $this->query("UPDATE tenant 
                             SET first_name=" . $fname . ", last_name=" . $lname . ", ssn=" . $ssn . ", current_address=" . $address .
                             ", email=" . $email . ", phone=" . $phone .
                             " WHERE tenant_id=" . $tenantId);
    }    

    public function delete_tenant($tenantId) {
        return $result1 = $this->query("delete from tenant where tenant_id=" . $tenantId);
    } 
    
    public function add_new_lease($aptNum, $buildingName, $startDate, $endDate, $rentalDate, $deposit) {
        
        $result1 = $this->query("INSERT INTO lease (LEASE_ID,START_DATE,END_DATE,RENTAL_DATE,DEPOSIT) VALUES 
                                (NULL," . $startDate . ", " . $endDate . ", " . $rentalDate . ", " . $deposit . ")");
 
            if (!$result1) {
              printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
              exit();
            } 
 
                                
        $result2 = $this->query("SELECT MAX(lease_id) FROM lease");
        $row = mysqli_fetch_array($result2);        
        $leaseId = $row[0];
        
        $result3 = $this->query("INSERT INTO apartment_lease (APARTMENT_NUMBER,LEASE_ID,BUILDING_NAME) VALUES 
                                (" . $aptNum . ", " . $leaseId . ", " . $buildingName . ")");
                                
        return ($result1 && $result2 && $result3);
    }

//Nikhil    
    public function add_new_tenant($leaseId, $fname, $lname, $ssn, $address, $email, $phone) {
        
        $result1 = $this->query("INSERT INTO tenant (tenant_id, first_name,last_name,ssn,current_address,email,phone) VALUES 
                                (NULL," . $fname . ", " . $lname . ", " . $ssn . ", " . $address . ", " . $email . ", " . $phone . ")");
 
            if (!$result1) {
              printf("Error: %s\n", mysqli_error(TenantDB::getInstance()));
              exit();
            } 
 
                                
        $result2 = $this->query("SELECT MAX(tenant_id) FROM tenant");
        $row = mysqli_fetch_array($result2);
        $tenantId = $row[0];
        
        $result3 = $this->query("INSERT INTO lease_tenant (TENANT_ID,LEASE_ID) VALUES 
                                (" . $tenantId . ", " . $leaseId . ")");
                                
        return ($result1 && $result2 && $result3);
    }    

}

?>