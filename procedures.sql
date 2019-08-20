--Create a customer’s bill based on the RepairJob.
CREATE OR REPLACE PROCEDURE GenerateCustomerBill(p_repairjobid IN VARCHAR) AS
	l_name RegularCustomer.name%TYPE;
	l_phone RegularCustomer.phone%TYPE;
	l_email RegularCustomer.email%TYPE;
	l_address RegularCustomer.address%TYPE;
	l_timein RepairJob.timein%TYPE;
	l_timeout RepairJob.timeout%TYPE;
	l_licensenumber RepairJob.licensenumber%TYPE;
	l_model RepairJob.model%TYPE;
	l_problemtype Problem.problemtype%TYPE;
	l_laborhours RepairJob.laborhours%TYPE;
	l_hourlyrate Mechanic.hourlyrate%TYPE;
	l_partname Part.name%TYPE;
	l_partprice Part.price%TYPE;
	l_totalamount NUMBER := 30;
	CURSOR part_cur IS SELECT * FROM Part_RepairJob WHERE repairjobid = p_repairjobid;
	part_data part_cur%ROWTYPE;
	BEGIN
		SELECT name INTO l_name FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = p_repairjobid;
		SELECT phone INTO l_phone FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = p_repairjobid;
		SELECT email INTO l_email FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = p_repairjobid;
		SELECT address INTO l_address FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = p_repairjobid;
		SELECT timein INTO l_timein FROM RepairJob WHERE repairjobid = p_repairjobid;
		SELECT SYSTIMESTAMP INTO l_timeout FROM DUAL;
		UPDATE RepairJob SET timeout = l_timeout WHERE repairjobid = p_repairjobid;
		SELECT licensenumber INTO l_licensenumber FROM RepairJob WHERE repairjobid = p_repairjobid;
		SELECT model INTO l_model FROM RepairJob WHERE repairjobid = p_repairjobid;
		SELECT problemtype INTO l_problemtype FROM RepairJob NATURAL JOIN Problem WHERE repairjobid = p_repairjobid;
		SELECT laborhours INTO l_laborhours FROM RepairJob WHERE repairjobid = p_repairjobid;
		SELECT hourlyrate INTO l_hourlyrate FROM RepairJob NATURAL JOIN Mechanic WHERE repairjobid = p_repairjobid;
		l_totalamount := l_totalamount + (l_laborhours * l_hourlyrate);
		DBMS_OUTPUT.PUT_LINE('Name: ' || l_name);
		DBMS_OUTPUT.PUT_LINE('Phone: ' || l_phone);
		DBMS_OUTPUT.PUT_LINE('Email: ' || l_email);
		DBMS_OUTPUT.PUT_LINE('Address: ' || l_address);
		DBMS_OUTPUT.PUT_LINE('Time In: ' || l_timein);
		DBMS_OUTPUT.PUT_LINE('Time Out: ' || l_timeout);
		DBMS_OUTPUT.PUT_LINE('License Number: ' || l_licensenumber);
		DBMS_OUTPUT.PUT_LINE('Model: ' || l_model);
		DBMS_OUTPUT.PUT_LINE('Problem Type: ' || l_problemtype);
		DBMS_OUTPUT.PUT_LINE('Labor Hours: ' || l_laborhours);
		DBMS_OUTPUT.PUT_LINE('Hourly Rate: ' || l_hourlyrate);
		FOR part_data IN part_cur LOOP
			SELECT name INTO l_partname FROM Part WHERE partnumber = part_data.partnumber;
			SELECT price INTO l_partprice FROM Part WHERE partnumber = part_data.partnumber;
			DBMS_OUTPUT.PUT_LINE('Part: ' || l_partname);
			l_totalamount := l_totalamount + l_partprice;
		END LOOP;
		l_totalamount := ComputeCustomerBill(p_repairjobid, l_timein, l_address, l_totalamount);
		UPDATE RepairJob SET totalamount = l_totalamount WHERE repairjobid = p_repairjobid;
		DBMS_OUTPUT.PUT_LINE('Total Amount: ' || l_totalamount);
	END GenerateCustomerBill;
/
show errors;
