<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$repairjobid = $_POST['repairjobid'];
		if (!empty($repairjobid)) {
			$repairjobid = prepareInput($repairjobid);
			$conn = oci_connect('achen2', 'Enterprise1701D', '//dbserver.engr.scu.edu/db11g');
			if (!$conn) {
				print "<br> connection failed:";
				exit;
			}
			$query = oci_parse($conn, 'BEGIN GenerateCustomerBill(:repairjobid); END;');
			oci_bind_by_name($query, ':repairjobid', $repairjobid);
			oci_free_statement($query);
			getName($conn, $repairjobid);
			getPhone($conn, $repairjobid);
			getEmail($conn, $repairjobid);
			getAddress($conn, $repairjobid);
			getTimeIn($conn, $repairjobid);
			getTimeOut($conn, $repairjobid);
			getModel($conn, $repairjobid);
			getParts($conn, $repairjobid);
			getTotalAmount($conn, $repairjobid);
			oci_close($conn);
		}
	}
	
	function getName($conn, $repairjobid) {
		$name = oci_parse($conn, 'SELECT name FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = :repairjobid');
		oci_bind_by_name($name, ':repairjobid', $repairjobid);
		oci_execute($name);
		if (($row = oci_fetch_array($name, OCI_BOTH)) != false) {
			echo "name: ", $row['NAME'], "<br>\n";
		}
		oci_free_statement($name);
	}

	function getPhone($conn, $repairjobid) {
		$phone = oci_parse($conn, 'SELECT phone FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = :repairjobid');
		oci_bind_by_name($phone, ':repairjobid', $repairjobid);
		oci_execute($phone);
		if (($row = oci_fetch_array($phone, OCI_BOTH)) != false) {
			echo "phone: ", $row['PHONE'], "<br>\n";
		}
		oci_free_statement($phone);
	}

	function getEmail($conn, $repairjobid) {
		$email = oci_parse($conn, 'SELECT email FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = :repairjobid');
		oci_bind_by_name($email, ':repairjobid', $repairjobid);
		oci_execute($email);
		if (($row = oci_fetch_array($email, OCI_BOTH)) != false) {
			echo "email: ", $row['EMAIL'], "<br>\n";
		}
		oci_free_statement($email);
	}

	function getAddress($conn, $repairjobid) {
		$address = oci_parse($conn, 'SELECT address FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = :repairjobid');
		oci_bind_by_name($address, ':repairjobid', $repairjobid);
		oci_execute($address);
		if (($row = oci_fetch_array($address, OCI_BOTH)) != false) {
			echo "address: ", $row['ADDRESS'], "<br>\n";
		}
		oci_free_statement($address);
	}

	function getTimeIn($conn, $repairjobid) {
		$timein = oci_parse($conn, 'SELECT timein FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = :repairjobid');
		oci_bind_by_name($timein, ':repairjobid', $repairjobid);
		oci_execute($timein);
		if (($row = oci_fetch_array($timein, OCI_BOTH)) != false) {
			echo "time in: ", $row['TIMEIN'], "<br>\n";
		}
		oci_free_statement($timein);
	}

	function getTimeOut($conn, $repairjobid) {
		$timeout = oci_parse($conn, 'SELECT timeout FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = :repairjobid');
		oci_bind_by_name($timeout, ':repairjobid', $repairjobid);
		oci_execute($timeout);
		if (($row = oci_fetch_array($timeout, OCI_BOTH)) != false) {
			echo "time out: ", $row['TIMEOUT'], "<br>\n";
		}
		oci_free_statement($timeout);
	}

	function getModel($conn, $repairjobid) {
		$model = oci_parse($conn, 'SELECT model FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = :repairjobid');
		oci_bind_by_name($model, ':repairjobid', $repairjobid);
		oci_execute($model);
		if (($row = oci_fetch_array($model, OCI_BOTH)) != false) {
			echo "model: ", $row['MODEL'], "<br>\n";
		}
		oci_free_statement($model);
	}

	function getParts($conn, $repairjobid) {
		$parts = oci_parse($conn, 'SELECT name, price FROM Part WHERE partnumber IN (SELECT partnumber FROM Part_RepairJob WHERE repairjobid = :repairjobid)');
		oci_bind_by_name($parts, ':repairjobid', $repairjobid);
		oci_execute($parts);
		while (($row = oci_fetch_array($parts, OCI_BOTH)) != false) {
			echo "name: ", $row['NAME'], "<br>\n";
			echo "price: ", $row['PRICE'], "<br>\n";
			echo "<br>\n";
		}
		oci_free_statement($parts);
	}

	function getTotalAmount($conn, $repairjobid) {
		$totalamount = oci_parse($conn, 'SELECT totalamount FROM RepairJob NATURAL JOIN RegularCustomer WHERE repairjobid = :repairjobid');
		oci_bind_by_name($totalamount, ':repairjobid', $repairjobid);
		oci_execute($totalamount);
		if (($row = oci_fetch_array($totalamount, OCI_BOTH)) != false) {
			echo "total amount: ", $row['TOTALAMOUNT'], "<br>\n";
		}
		oci_free_statement($totalamount);
	}

	function prepareInput($inputData){
		$inputData = trim($inputData);
	  	$inputData = htmlspecialchars($inputData);
	  	return $inputData;
	}
?>