CREATE TABLE RegularCustomer (
	name VARCHAR(20),
	phone CHAR(15),
	email VARCHAR(20),
	address VARCHAR(20) PRIMARY KEY
);
CREATE TABLE Mechanic (
	employeeid VARCHAR(5) PRIMARY KEY,
	name VARCHAR(20),
	phone CHAR(15),
	hourlyrate NUMERIC(5, 2)
);
CREATE TABLE Problem (
	problemid VARCHAR(5) PRIMARY KEY,
	problemtype VARCHAR(20)
);
CREATE TABLE RepairJob (
	repairjobid VARCHAR(5) PRIMARY KEY,
	timein TIMESTAMP,
	timeout TIMESTAMP,
	licensenumber CHAR(8),
	model VARCHAR(20),
	laborhours INTEGER,
	totalamount NUMERIC(10, 2),
	address VARCHAR(20) REFERENCES RegularCustomer (address),
	employeeid VARCHAR(5) REFERENCES Mechanic (employeeid),
	problemid VARCHAR(5) REFERENCES Problem (problemid)
);
CREATE TABLE Part (
	partnumber VARCHAR(5) PRIMARY KEY,
	name VARCHAR(20),
	price NUMERIC(5, 2)
);
CREATE TABLE Part_RepairJob (
	partnumber VARCHAR(5),
	repairjobid VARCHAR(5),
	PRIMARY KEY (partnumber, repairjobid),
	FOREIGN KEY (partnumber) REFERENCES Part (partnumber),
	FOREIGN KEY (repairjobid) REFERENCES RepairJob (repairjobid)
);
CREATE TABLE Log (
	repairjobid VARCHAR(5) PRIMARY KEY,
	timein TIMESTAMP,
	timeout TIMESTAMP,
	licensenumber CHAR(8),
	model VARCHAR(20),
	laborhours INTEGER,
	totalamount NUMERIC(10, 2),
	address VARCHAR(20) REFERENCES RegularCustomer (address),
	employeeid VARCHAR(5) REFERENCES Mechanic (employeeid),
	problemid VARCHAR(5) REFERENCES Problem (problemid)
);
