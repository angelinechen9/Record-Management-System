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
		$repairjobid = oci_parse($conn, 'SELECT repairjobid FROM Log WHERE timein > :startdate AND timeout < :enddate');
		oci_bind_by_name($repairjobid, ':startdate', $startdate);
		oci_bind_by_name($repairjobid, ':enddate', $enddate);
		oci_execute($repairjobid);
		if (($row = oci_fetch_array($repairjobid, OCI_BOTH)) != false) {
			echo $row['REPAIRJOBID'], "<br>\n";
		}
		oci_free_statement($repairjobid);
		oci_close($conn);
	}

	function prepareInput($inputData){
		$inputData = trim($inputData);
	  	$inputData = htmlspecialchars($inputData);
	  	return $inputData;
	}
?>