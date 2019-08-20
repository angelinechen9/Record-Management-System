--Create a customer’s bill based on the RepairJob.
exec GenerateCustomerBill('1');
exec GenerateCustomerBill('2');
exec GenerateCustomerBill('3');
DELETE FROM Part_RepairJob WHERE repairjobid = '4';
DELETE FROM RepairJob WHERE repairjobid = '4';
exec GenerateCustomerBill('5');
--When RepairJob is completed on a car and before the information is deleted, it should be saved into a separate log table.
DELETE FROM Part_RepairJob WHERE repairjobid = '1';
DELETE FROM Part_RepairJob WHERE repairjobid = '2';
DELETE FROM Part_RepairJob WHERE repairjobid = '3';
DELETE FROM Part_RepairJob WHERE repairjobid = '5';
DELETE FROM RepairJob WHERE repairjobid = '1';
DELETE FROM RepairJob WHERE repairjobid = '2';
DELETE FROM RepairJob WHERE repairjobid = '3';
DELETE FROM RepairJob WHERE repairjobid = '5';
SELECT * FROM Log;
--Show a listing of the mechanics (employeeId and the name) who worked the most number of hours, the mechanic who worked the least number of hours and the average number of hours each mechanic worked.
SELECT name FROM Mechanic WHERE employeeid IN (SELECT employeeid FROM Log GROUP BY employeeid HAVING SUM(laborhours) >= ALL (SELECT SUM(laborhours) FROM Log GROUP BY employeeid));
SELECT name FROM Mechanic WHERE employeeid IN (SELECT employeeid FROM Log GROUP BY employeeid HAVING SUM(laborhours) <= ALL (SELECT SUM(laborhours) FROM Log GROUP BY employeeid));
SELECT name, totallaborhours FROM Mechanic NATURAL JOIN (SELECT employeeid, SUM(laborhours) / COUNT(*) AS totallaborhours FROM Log GROUP BY employeeid);
--Show a listing of all the repair jobs done between two given dates.
SELECT repairjobid FROM Log WHERE timein > TO_DATE('2019/03/08', 'yyyy/mm/dd') AND timein < TO_DATE('2019/03/15', 'yyyy/mm/dd');
--A listing showing the amount of money generated from the customer billing (between two specific dates).
SELECT SUM(totalamount) FROM Log WHERE timein > TO_DATE('2019/03/08', 'yyyy/mm/dd') AND timein < TO_DATE('2019/03/15', 'yyyy/mm/dd');
