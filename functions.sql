CREATE OR REPLACE FUNCTION ComputeCustomerBill(p_repairjobid IN VARCHAR, p_timein IN DATE, p_address IN VARCHAR, p_totalamount NUMBER) RETURN NUMBER IS
	l_totalamount NUMBER := p_totalamount;
	l_difference INTEGER;
	l_count INTEGER := 0;
	CURSOR repairjob_cur IS SELECT * FROM Log WHERE address = p_address;
	repairjob_data repairjob_cur%ROWTYPE;
	BEGIN
		FOR repairjob_data IN repairjob_cur LOOP
			l_difference := ABS(EXTRACT(DAY FROM (p_timein - repairjob_data.timein)));
			IF l_difference <= 365 THEN
				l_count := l_count + 1;
			END IF;
		END LOOP;
		IF l_count > 0 THEN
			l_totalamount := l_totalamount * .9;
		END IF;
		return l_totalamount;
	END ComputeCustomerBill;
/
show errors;
