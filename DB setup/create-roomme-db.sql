CREATE DATABASE roomme;
USE roomme;

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `Housing` (
  `Housing_ID` int(11) NOT NULL,
  `Campus` varchar(45) NOT NULL,
  `Street_Address` varchar(45) NOT NULL,
  `City` varchar(45) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zip_code` int(5) NOT NULL,
  `Distance_to_school` decimal(3,1) NOT NULL,
  `Price` int(11) NOT NULL,
  `Min_term` int(11) NOT NULL,
  `Start_date` date NOT NULL,
  `No_of_Bedrooms` int(11) NOT NULL,
  `No_of_Bathrooms` decimal(2,1) NOT NULL,
  `Max_capacity` int(11) NOT NULL,
  `Parking` varchar(1) NOT NULL DEFAULT 'n',
  `Laundry` varchar(1) NOT NULL DEFAULT 'n',
  `Smoking` varchar(1) NOT NULL DEFAULT 'n',
  `Pets` varchar(1) NOT NULL DEFAULT 'n',
  `Description` text,
  `Owned_by` int(11) NOT NULL,
  PRIMARY KEY (`Housing_ID`),
  KEY `House_Ld_idx` (`Owned_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Housing` (`Housing_ID`, `Campus`, `Street_Address`, `City`, `State`, `Zip_code`, `Distance_to_school`, `Price`, `Min_term`, `Start_date`, `No_of_Bedrooms`, `No_of_Bathrooms`, `Max_capacity`, `Parking`, `Laundry`, `Smoking`, `Pets`, `Description`, `Owned_by`) VALUES
(5001, 'SJSU', '380 S 9th St', 'San Jose', 'CA', 95112, '0.0', 2100, 12, '2014-06-01', 2, '2.0', 5, 'y', 'y', 'n', 'n', NULL, 1001),
(5002, 'SJSU', '210 S 4th St #100', 'San Jose', 'CA', 95112, '0.0', 2500, 9, '2014-03-29', 2, '2.0', 5, 'n', 'y', 'n', 'n', NULL, 1002),
(5003, 'SJSU', '101 E San Fernando St #100', 'San Jose', 'CA', 95112, '0.0', 1800, 6, '2014-03-01', 1, '1.5', 3, 'n', 'y', 'n', 'y', NULL, 1003),
(5004, 'SJSU', '4500 Carlyle Ct', 'San Jose', 'CA', 95054, '6.1', 3100, 12, '2014-04-05', 3, '3.0', 7, 'y', 'y', 'n', 'n', NULL, 1004),
(5005, 'SJSU', '535 South Market St', 'San Jose', 'CA', 95113, '0.5', 1950, 9, '2014-03-01', 2, '2.5', 5, 'n', 'n', 'y', 'y', NULL, 1003),
(5006, 'SJSU', '190 Ryland St', 'San Jose', 'CA', 95110, '1.1', 2100, 9, '2014-06-02', 1, '1.5', 3, 'y', 'y', 'n', 'n', NULL, 1005),
(5007, 'SJSU', '1058 S 5th St', 'San Jose', 'CA', 95112, '0.9', 1750, 12, '2014-09-01', 0, '1.0', 2, 'n', 'n', 'n', 'n', NULL, 1006),
(5008, 'SJSU', '760 N 7th St', 'San Jose', 'CA', 95112, '1.6', 2000, 6, '2014-05-05', 2, '2.0', 5, 'y', 'y', 'n', 'y', NULL, 1007),
(5009, 'SJSU', '345 Stockton Ave', 'San Jose', 'CA', 95126, '1.4', 2150, 9, '2014-03-20', 2, '2.5', 6, 'y', 'y', 'n', 'n', NULL, 1008),
(5010, 'SJSU', '2055 Summerside Dr', 'San Jose', 'CA', 95122, '2.4', 2800, 9, '2014-07-01', 4, '3.0', 8, 'y', 'y', 'n', 'n', NULL, 1009),
(5011, 'SJSU', '680 2nd Street', 'San Jose', 'CA', 95112, '1.2', 2500, 12, '2014-09-30', 3, '2.0', 7, 'y', 'y', 'n', 'y', 'includes a gym', 1009),
(5012, 'SJSU', '900 San Fernando St.', 'San Jose', 'CA', 95112, '2.5', 1000, 6, '2014-03-25', 1, '1.5', 3, 'n', 'y', 'y', 'n', '', 1010),
(5013, 'SJSU', '250 San Carlos St. Unit A', 'San Jose', 'CA', 95112, '0.8', 1250, 12, '2014-06-22', 2, '2.0', 4, 'y', 'y', 'n', 'n', '', 1011),
(5014, 'SJSU', '673 10th St. Unit #2', 'San Jose', 'CA', 95112, '0.9', 1750, 6, '2015-01-01', 2, '2.0', 5, 'n', 'y', 'y', 'y', 'street parking is heavily limited', 1012),
(5015, 'SJSU', '500 Santa Clara Ave.', 'San Jose', 'CA', 95112, '0.2', 2550, 12, '2014-05-16', 2, '1.0', 4, 'y', 'y', 'n', 'y', '', 1013),
(5016, 'SJSU', '500 8th St. #2', 'San Jose', 'CA', 95112, '0.1', 3000, 8, '2014-10-02', 2, '1.5', 5, 'n', 'n', 'y', 'n', '', 1014),
(5017, 'SJSU', '500 8th St. #4', 'San Jose', 'CA', 95112, '0.1', 2980, 6, '2014-11-27', 1, '1.0', 3, 'n', 'n', 'y', 'n', '', 1016),
(5018, 'SJSU', '100 San Carlos St. Unit B', 'San Jose', 'CA', 95112, '0.5', 1900, 12, '2014-04-25', 2, '1.5', 5, 'n', 'y', 'y', 'n', '', 1015),
(5019, 'SJSU', '300 Telegraph Ave', 'San Jose', 'CA', 95112, '1.1', 1360, 12, '2014-06-20', 1, '1.0', 3, 'n', 'y', 'n', 'n', '', 1017),
(5020, 'SJSU', '256 Nighter Ave', 'San Jose', 'CA', 95112, '0.7', 1875, 12, '2014-07-10', 2, '1.5', 6, 'y', 'y', 'n', 'n', '', 1018),
(5021, 'SJSU', '780 Santa Clara Ave. #221', 'San Jose', 'CA', 95112, '0.4', 2300, 9, '2014-08-01', 2, '2.5', 6, 'y', 'y', 'n', 'y', '', 1019),
(5022, 'SJSU', '9811 McHenry Ave.', 'San Jose', 'CA', 95112, '1.2', 1500, 12, '2014-08-20', 0, '1.0', 2, 'n', 'y', 'y', 'n', 'Has full-size kitchen', 1020),
(5023, 'SJSU', '1100 Calvin St.', 'San Jose', 'CA', 95112, '1.9', 1450, 6, '2014-08-11', 1, '1.5', 3, 'y', 'n', 'n', 'n', '', 1012),
(5024, 'SJSU', '1000 Coleman Ave', 'San Jose', 'CA', 95112, '1.7', 2200, 12, '2014-09-01', 2, '2.0', 4, 'n', 'y', 'y', 'y', 'near airport', 1015),
(5025, 'SJSU', '250 San Salvador St.', 'San Jose', 'CA', 95112, '1.3', 3000, 12, '2014-07-31', 3, '2.5', 8, 'y', 'n', 'n', 'n', '', 1019);

CREATE TABLE IF NOT EXISTS `Landlord` (
  `Landlord_ID` int(11) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `Fname` varchar(45) NOT NULL,
  `Lname` varchar(45) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Phone_number` varchar(15) NOT NULL,
  PRIMARY KEY (`Landlord_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Landlord` (`Landlord_ID`, `Username`, `Password`, `Fname`, `Lname`, `Email`, `Phone_number`) VALUES
(1000, 'admin', 'admin', 'admin', 'admin', 'noemail', '0000000000'),
(1001, 'jsmith', 'test123', 'John', 'Smith', 'john.smith@gmail.com', '4087776222'),
(1002, 'kat.jameson', 'mypassword', 'Katherine', 'Jameson', 'james.katy@yahoo.com', '4089912222'),
(1003, 'jkimmel', '1234', 'Joey', 'Kimmel', 'kim.kim.joey@hotmail.com', '9902235656'),
(1004, 'thebestlandlord', 'helloworld', 'Laura', 'Kim', 'laura.kim@live.com', '4083332222'),
(1005, 'mikaelthrone', 'applerules', 'Mikael', 'Throne', 'mikey@icloud.com', '4153210022'),
(1006, 'nelson-the-lee', '5645', 'Nelson', 'Lee', 'lee.nelson5645@gmail.com', '8002998877'),
(1007, 'abby.lin', '0606', 'Abby', 'Lin', 'abby0606@yahoo.com', '2147483647'),
(1008, 'bob.holmes1111', 'notrelatedtosherlock', 'Bobby', 'Holmes', 'bob.holmes1111@gmail.com', '9902231111'),
(1009, 'wenjiazhang', 'awesome', 'Wenjia', 'Zhang', 'wenjiazhang519@gmail.com', '7072448787'),
(1010, 'jiang.xiaoli', 'theboss', 'Xiaoli', 'Jiang', 'jxl@gmail.com', '5100009999'),
(1011, 'khsu', '9090$4', 'Kevin', 'Hsu', 'k.hsu@gmail.com', '4080012210'),
(1012, 'adam.s', '1234abc', 'Adam', 'Sander', 'sander.adam1234@hotmail.com', '4103320912'),
(1013, 'maryann', '100test#', 'Mary Ann', 'Tyrone', 'tyrone.mary.ann@yahoo.com', '9291103322'),
(1014, 'landlord_no_1', 'signinplease', 'Barry', 'Custom', 'barrycustom0001@gmail.com', '4087765530'),
(1015, 'cowboystyle', 'thisisapassword', 'Cameron', 'Smith', 'cameronsmith0925@icloud.com', '9291106890'),
(1016, 'rachel111', 'readingbooks!', 'Rachel', 'McAdams', 'rachel.mcadams@gmail.com', '8802212014'),
(1017, 'caroler', 'lalala', 'Carol', 'Platin', 'carolplatin@google.com', '4152213321'),
(1018, 'theniceguy', 'alwayshere', 'Phil', 'Wong', 'wong.phil.nice@google.com', '6269901156'),
(1019, 'alcoholic', 'vodka<3', 'Lowe', 'Summerton', 'lowe.summerton@yahoo.com', '5108812020'),
(1020, 'waterguzzler', 'h2o', 'Quentin', 'Taratino', 'taratara.q@gmail.com', '9902132200');


CREATE TABLE IF NOT EXISTS `Primary_Tenant` (
  `Tenant_ID` int(11) NOT NULL,
  `Rents_Housing` int(11) NOT NULL COMMENT 'One housing can only be rented by one primary tenant, so this column must be unique.',
  PRIMARY KEY (`Tenant_ID`),
  UNIQUE KEY `Rents_Housing_UNIQUE` (`Rents_Housing`),
  KEY `Renting_Housing_idx` (`Rents_Housing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Primary_Tenant` (`Tenant_ID`, `Rents_Housing`) VALUES
(2001, 5001),
(2002, 5002),
(2003, 5003),
(2004, 5004),
(2005, 5005),
(2006, 5006);

CREATE TABLE IF NOT EXISTS `Rooms` (
  `Rooms_ID` int(11) NOT NULL,
  `Price` int(6) NOT NULL,
  `Min_term` int(11) NOT NULL,
  `Start_date` date NOT NULL,
  `Room_Type` varchar(45) NOT NULL DEFAULT 'Single Bedroom',
  `Bathroom_Type` varchar(45) NOT NULL DEFAULT 'Individual',
  `Capacity` int(3) NOT NULL DEFAULT '1',
  `Parking` varchar(1) NOT NULL DEFAULT 'n',
  `Laundry` varchar(1) NOT NULL DEFAULT 'n',
  `Smoking` varchar(1) NOT NULL DEFAULT 'n',
  `Pets` varchar(1) NOT NULL DEFAULT 'n',
  `Description` text,
  `Habits` text,
  `In_Housing` int(11) NOT NULL,
  PRIMARY KEY (`Rooms_ID`),
  KEY `Part_of_Housing_idx` (`In_Housing`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Rooms` (`Rooms_ID`, `Price`, `Min_term`, `Start_date`, `Room_Type`, `Bathroom_Type`, `Capacity`, `Parking`, `Laundry`, `Smoking`, `Pets`, `Description`, `Habits`, `In_Housing`) VALUES
(50011, 500, 9, '2014-04-15', 'Single Bedroom', 'Individual', 2, 'y', 'y', 'n', 'n', 'All female housing.', NULL, 5001),
(50012, 450, 12, '2014-09-08', 'Single Bedroom', 'Shared', 2, 'n', 'n', 'n', 'n', 'great place', 'no smokers please', 5001),
(50021, 600, 12, '2014-05-01', 'Single Bedroom', 'Individual', 1, 'n', 'n', 'n', 'n', 'test', 'something', 5002),
(50051, 500, 6, '2014-06-11', 'Shared Bedroom', 'Shared', 2, 'n', 'n', 'n', 'n', NULL, 'Drugs and alcohol not tolerated.', 5005),
(50052, 390, 12, '2014-06-01', 'Living Room', 'Shared', 1, 'n', 'n', 'n', 'n', NULL, NULL, 5005);

CREATE TABLE IF NOT EXISTS `Secondary_Tenant` (
  `Tenant_ID` int(11) NOT NULL,
  `Renting_Room` int(11) NOT NULL,
  PRIMARY KEY (`Tenant_ID`),
  KEY `Renting_Room_idx` (`Renting_Room`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Secondary_Tenant` (`Tenant_ID`, `Renting_Room`) VALUES
(2007, 50011),
(2008, 50051),
(2009, 50052),
(2010, 50012);

CREATE TABLE IF NOT EXISTS `Tenant` (
  `Tenant_ID` int(11) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `Fname` varchar(45) NOT NULL,
  `Lname` varchar(45) NOT NULL,
  `School` varchar(45) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Phone_number` varchar(15) NOT NULL,
  `Age` int(3) NOT NULL,
  `Major` varchar(45) NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `Home_country` varchar(45) NOT NULL,
  `Smoking` varchar(1) NOT NULL DEFAULT 'n',
  `Pets` varchar(1) NOT NULL DEFAULT 'n',
  `Habits` varchar(45) DEFAULT 'none',
  PRIMARY KEY (`Tenant_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Tenant` (`Tenant_ID`, `Username`, `Password`, `Fname`, `Lname`, `School`, `Email`, `Phone_number`, `Age`, `Major`, `Gender`, `Home_country`, `Smoking`, `Pets`) VALUES
(2001, 'iamjanedoe', 'abc123', 'Jane', 'Doe', 'SJSU', 'jane.doe@sjsu.edu', '2023105550', 20, 'Humanities', 'F', 'USA', 'n', 'y'),
(2002, 'kyle_lin', 'sjsu', 'Kyle', 'Lin', 'SJSU', 'lin.kyle@sjsu.edu', '4089002000', 18, 'Computer Engineering', 'M', 'China', 'y', 'y'),
(2003, 'cutler', 'mynameisjoey', 'Joey', 'Cutler', 'SJSU', 'cutler.joey@sjsu.edu', '4086626262', 21, 'Mathematics', 'M', 'England', 'n', 'n'),
(2004, 'wendy.watanabe', 'cmpe', 'Wendy', 'Watanabe', 'SJSU', 'wendy@sjsu.edu', '8582221000', 18, 'Computer Engineering', 'F', 'Japan', 'n', 'n'),
(2005, 'chris.leeee', 'chemrocks', 'Chris', 'Lee', 'SJSU', 'chris.lee@yahoo.com', '6263312426', 19, 'Chemistry', 'M', 'USA', 'y', 'y'),
(2006, 'the.chenster', 'testabc1', 'Tommy', 'Chen', 'SJSU', 'tommy.chen@hotmail.com', '9892210023', 23, 'Physics', 'M', 'China', 'y', 'n'),
(2007, 'appleboss', 'iphonesss', 'Tim', 'Cook', 'SJSU', 'timmy.cook@sjsu.edu', '2102229111', 22, 'Dance', 'M', 'USA', 'n', 'n'),
(2008, 'alphabravo', '#1900a', 'Xiaoli', 'Jiang', 'SJSU', 'jiangxiaoli1104@gmail.com', '5662103434', 100, 'CMPE', 'F', 'China', 'n', 'n'),
(2009, 'jwu001', 'letsrun', 'Jennifer', 'Wu', 'SJSU', 'testemail@gmail.com', '7074152211', 23, 'Software Engineering', 'F', 'USA', 'n', 'y'),
(2010, 'stewart', 'child44', 'Stewart', 'Little', 'SJSU', 'steward.little@gmail.com', '5608752231', 17, 'Journalism', 'M', 'USA', 'n', 'n'),
(2011, 'tim.jim', 'gotim', 'Timothy', 'Kelvin', 'SJSU', 'tim.jim@comcast.com', '5106602257', 21, 'Business', 'M', 'England', 'y', 'n'),
(2012, 'Caitlin', 'choiiii', 'Caitlin', 'Choi', 'SJSU', 'choi.cat@yahoo.com', '4102250808', 22, 'Music', 'F', 'Korea', 'y', 'y'),
(2013, 'mona.lee', 'jkidding1', 'Mona', 'Lee', 'SJSU', 'mona.lee@gmail.com', '5102223355', 25, 'Computer Science', 'F', 'China', 'y', 'n'),
(2014, 'welcome', 'this is a test', 'Nina', 'Caravan', 'SJSU', 'caravan.nina@icloud.com', '5102221100', 21, 'Anthropology', 'F', 'USA', 'n', 'y'),
(2015, 'tiffanychen', 'educationlover', 'Tiffany', 'Chen', 'SJSU', 'tiffany.chen@sjsu.edu', '5102339901', 24, 'Education', 'F', 'Hong Kong', 'n', 'y'),
(2016, 'naturelover', 'comeagain', 'Michelle', 'Pham', 'SJSU', 'michelle.pham@sjsu.edu', '4086524421', 18, 'Nursing', 'F', 'Vietnam', 'n', 'y'),
(2017, 'tiffwang', 'camcam', 'Tiffany', 'Wang', 'SJSU', 'tiffany.wang@gmail.com', '5102449912', 20, 'Education', 'F', 'USA', 'y', 'n'),
(2018, 'hiker', 'hello', 'Zephyr', 'Blake', 'SJSU', 'zephyr.blake@icloud.com', '5106251234', 19, 'Nursing', 'M', 'USA', 'n', 'y'),
(2019, 'jareddd', 'leto?', 'Jared', 'Leto', 'SJSU', 'jared.leto@sjsu.edu', '6268802210', 23, 'Biology', 'M', 'USA', 'n', 'n'),
(2020, 'sleepyhead', 'tired.', 'John', 'Snowdon', 'SJSU', 'snowdon@gmail.com', '5105679090', 24, 'Nursing', 'M', 'USA', 'n', 'n'),
(2021, 'zooom', 'doglover', 'Caleb', 'Kawasaki', 'SJSU', 'caleb.kawasaki@hotmail.com', '5109902222', 21, 'Nursing', 'M', 'Japan', 'y', 'y'),
(2022, 'Richer', 'andricher', 'Richard', 'Neeson', 'SJSU', 'neeson@yahoo.com', '4089002266', 19, 'Computer Engineering', 'M', 'USA', 'n', 'y'),
(2023, 'iamadmin', 'root', 'Harold', 'Finch', 'SJSU', 'finch.harold@gmail.com', '6799012216', 22, 'Software Engineering', 'M', 'USA', 'n', 'n'),
(2024, 'tvlover', 'lovetvs', 'Angela', 'Shaw', 'SJSU', 'angela.shaw@gmail.com', '9902213344', 26, 'Electrical Engineering', 'F', 'USA', 'n', 'n'),
(2025, 'summer', 'iscoming', 'Nancy', 'Drew', 'SJSU', 'nancy.drew@gmail.com', '1235559000', 22, 'History', 'F', 'USA', 'n', 'y'),
(2026, 'eddiec', 'iamavampire', 'Edward', 'Cullen', 'SJSU', 'cullenclan@gmail.com', '5106691023', 17, 'History', 'M', 'USA', 'n', 'n'),
(2027, 'izzy', 'iloveed', 'Isabella', 'Swan', 'SJSU', 'isabella.s@sjsu.edu', '7829102290', 18, 'Art', 'F', 'USA', 'n', 'n'),
(2028, 'raymond', 'theblacklist', 'Raymond', 'Reddington', 'SJSU', 'forhire@gmail.com', '6902221023', 22, 'Architecture', 'M', 'USA', 'y', 'y'),
(2029, 'tommyboy', 'ineedahome', 'Tom', 'Keen', 'SJSU', 'tommy.keen@icloud.com', '6092215231', 24, 'Computer Science', 'M', 'USA', 'y', 'n'),
(2030, 'melly2', 'love!', 'Melanie', 'Garcia', 'SJSU', 'garcia.mel@sjsu.edu', '4089214567', 21, 'Dance', 'F', 'USA', 'n', 'y');


ALTER TABLE `Housing`
  ADD CONSTRAINT `House_Ld` FOREIGN KEY (`Owned_by`) REFERENCES `Landlord` (`Landlord_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Primary_Tenant`
  ADD CONSTRAINT `Renting_Housing` FOREIGN KEY (`Rents_Housing`) REFERENCES `Housing` (`Housing_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Tenant_type2` FOREIGN KEY (`Tenant_ID`) REFERENCES `Tenant` (`Tenant_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Secondary_Tenant`
  ADD CONSTRAINT `Renting_Room` FOREIGN KEY (`Renting_Room`) REFERENCES `Rooms` (`Rooms_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Tenant_Type` FOREIGN KEY (`Tenant_ID`) REFERENCES `Tenant` (`Tenant_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

SET FOREIGN_KEY_CHECKS=1;
