CREATE TABLE IF NOT EXISTS `apartment_lease` (
  `APARTMENT_NUMBER` int(11) NOT NULL,
  `BUILDING_NAME` varchar(100) NOT NULL,
  `LEASE_ID` int(11) NOT NULL,
  KEY `LEASE_ID` (`LEASE_ID`),
  KEY `INDEX` (`APARTMENT_NUMBER`,`BUILDING_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `appartment` (
  `APT_NUMBER` int(11) NOT NULL,
  `BUILDING_NAME` varchar(100) NOT NULL,
  `APT_TYPE` varchar(100) NOT NULL,
  `RENTAL_FEES` float NOT NULL,
  PRIMARY KEY (`APT_NUMBER`,`BUILDING_NAME`),
  KEY `BUILDING_NAME` (`BUILDING_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `building` (
  `BUILDING_NAME` varchar(100) NOT NULL,
  `ADDRESS` varchar(200) NOT NULL,
  PRIMARY KEY (`BUILDING_NAME`),
  KEY `BUILDING_NAME` (`BUILDING_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `lease` (
  `LEASE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `START_DATE` date DEFAULT NULL,
  `END_DATE` date NOT NULL,
  `RENTAL_DATE` date DEFAULT NULL,
  `DEPOSIT` float NOT NULL,
  PRIMARY KEY (`LEASE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `lease_rent` (
  `LEASE_ID` int(11) NOT NULL,
  `RENT_ID` int(11) NOT NULL,
  KEY `LEASE_ID` (`LEASE_ID`),
  KEY `RENT_ID` (`RENT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `lease_tenant` (
  `LEASE_ID` int(11) NOT NULL,
  `TENANT_ID` int(11) NOT NULL,
  KEY `LEASE_ID` (`LEASE_ID`),
  KEY `TENANT_ID` (`TENANT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `payment` (
  `PAYMENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PAY_DATE` date NOT NULL,
  `PAY_AMOUNT` float NOT NULL,
  `PAY_METHOD` varchar(100) NOT NULL,
  PRIMARY KEY (`PAYMENT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `rent` (
  `RENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `RENT_FEE` float NOT NULL,
  `LATE_FEE` float NOT NULL,
  `DUE_DATE` date NOT NULL,
  PRIMARY KEY (`RENT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `rent_payment` (
  `RENT_ID` int(11) NOT NULL,
  `PAYMENT_ID` int(11) NOT NULL,
  KEY `RENT_ID` (`RENT_ID`),
  KEY `PAYMENT_ID` (`PAYMENT_ID`),
  KEY `PAYMENT_ID_2` (`PAYMENT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `tenant` (
  `TENANT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FIRST_NAME` varchar(100) NOT NULL,
  `LAST_NAME` varchar(100) NOT NULL,
  `SSN` int(11) NOT NULL,
  `CURRENT_ADDRESS` varchar(200) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PHONE` varchar(50) NOT NULL,
  PRIMARY KEY (`TENANT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `apartment_lease`
  ADD CONSTRAINT `APARTMENT_LEASE` FOREIGN KEY (`LEASE_ID`) REFERENCES `lease` (`LEASE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `appartment`
  ADD CONSTRAINT `appartment_ibfk_1` FOREIGN KEY (`BUILDING_NAME`) REFERENCES `building` (`BUILDING_NAME`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `lease_rent`
  ADD CONSTRAINT `RENT_LEASE` FOREIGN KEY (`RENT_ID`) REFERENCES `rent` (`RENT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LEASE_RENT` FOREIGN KEY (`LEASE_ID`) REFERENCES `lease` (`LEASE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `lease_tenant`
  ADD CONSTRAINT `TENANT_LEASE` FOREIGN KEY (`TENANT_ID`) REFERENCES `tenant` (`TENANT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LEASE_TENANT` FOREIGN KEY (`LEASE_ID`) REFERENCES `lease` (`LEASE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `rent_payment`
  ADD CONSTRAINT `PAYMENT_RENT` FOREIGN KEY (`PAYMENT_ID`) REFERENCES `payment` (`PAYMENT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `RENT_PAYMENT` FOREIGN KEY (`RENT_ID`) REFERENCES `rent` (`RENT_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

