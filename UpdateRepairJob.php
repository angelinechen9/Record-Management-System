<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $repairjobid = $_POST['repairjobid'];
        $laborhours = $_POST['laborhours'];
        $problemid = $_POST['problemid'];
        if (!empty($repairjobid) && !empty($laborhours) && !empty($problemid)) {
            $repairjobid = prepareInput($repairjobid);
            $laborhours = prepareInput($laborhours);
            $problemid = prepareInput($problemid);
            $conn = oci_connect('achen2', 'Enterprise1701D', '//dbserver.engr.scu.edu/db11g');
            if (!$conn) {
				print "<br> connection failed:";
				exit;
            }
            postRepairJob($conn, $repairjobid, $laborhours, $problemid);
        }
    }

    function postRepairJob($conn, $repairjobid, $laborhours, $problemid) {
        $sql1 = 'UPDATE RepairJob SET laborhours = :laborhours WHERE repairjobid = :repairjobid';
        $query1 = oci_parse($conn, $sql1);
        oci_bind_by_name($query1, ':laborhours', $laborhours);
        oci_bind_by_name($query1, ':repairjobid', $repairjobid);
        oci_execute($query1);
        oci_free_statement($query1);
        $sql2 = 'UPDATE RepairJob SET problemid = :problemid WHERE repairjobid = :repairjobid';
        $query2 = oci_parse($conn, $sql2);
        oci_bind_by_name($query2, ':problemid', $problemid);
        oci_bind_by_name($query2, ':repairjobid', $repairjobid);
        oci_execute($query2);
        oci_free_statement($query2);
    }

    function prepareInput($inputData){
        $inputData = trim($inputData);
        $inputData = htmlspecialchars($inputData);
        return $inputData;
    }
?>