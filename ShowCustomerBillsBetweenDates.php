<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$startdate = $_POST['startdate'];
		$enddate = $_POST['enddate'];
		if (!empty($startdate) && !empty($enddate)) {
			$startdate = prepareInput($startdate);
			$enddate = prepareInput($enddate);
			getRepairJobId($startdate, $enddate);
		}
	}

	function getRepairJobId($startdate, $enddate) {
		$conn = oci_connect('achen2', 'Enterprise1701D', '//dbserver.engr.scu.edu/db11g');
		if (!$conn) {
			print "<br> connection failed:";
			exit;
		}
		$totalamount = oci_parse($conn, 'SELECT repairjobid FROM Log WHERE timein > :startdate AND timeout < :enddate');
		oci_bind_by_name($totalamount, ':startdate', $startdate);
		oci_bind_by_name($totalamount, ':enddate', $startdate);
		oci_execute($totalamount);
		if (($row = oci_fetch_array($totalamount, OCI_BOTH)) != false) {
			echo $row['TOTALAMOUNT'], "<br>\n";
		}
		oci_free_statement($totalamount);
		oci_close($conn);
	}

	function prepareInput($inputData){
		$inputData = trim($inputData);
	  	$inputData = htmlspecialchars($inputData);
	  	return $inputData;
	}
?>