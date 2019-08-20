--When RepairJob is completed on a car and before the information is deleted, it should be saved into a separate log table.
CREATE OR REPLACE TRIGGER CompleteRepair
	AFTER DELETE ON RepairJob
	FOR EACH ROW
	BEGIN
		INSERT INTO LOG VALUES (:OLD.repairjobid, :OLD.timein, :OLD.timeout, :OLD.licensenumber, :OLD.model, :OLD.laborhours, :OLD.totalamount, :OLD.address, :OLD.employeeid, :OLD.problemid);
	END;
/
show errors;
