<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $customername = $_POST['customername'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $licensenumber = $_POST['licensenumber'];
        $model = $_POST['model'];
        $repairjobid = $_POST['repairjobid'];
        $employeeid = $_POST['employeeid'];
        if (!empty($customername) && !empty($phone) && !empty($email) && !empty($address) && !empty($licensenumber) && !empty($model) && !empty($employeeid)) {
            $customername = prepareInput($customername);
            $phone = prepareInput($phone);
            $email = prepareInput($email);
            $address = prepareInput($address);
            $licensenumber = prepareInput($licensenumber);
            $model = prepareInput($model);
            $repairjobid = prepareInput($repairjobid);
            $employeeid = prepareInput($employeeid);
            $conn = oci_connect('achen2', 'Enterprise1701D', '//dbserver.engr.scu.edu/db11g');
            if (!$conn) {
				print "<br> connection failed:";
				exit;
            }
            postRegularCustomer($conn, $customername, $phone, $email, $address);
            postRepairJob($conn, $repairjobid, $licensenumber, $model, $address, $employeeid);
        }
    }

    function postRegularCustomer($conn, $customername, $phone, $email, $address) {
        $sql = 'INSERT INTO RegularCustomer VALUES (:customername, :phone, :email, :address)';
        $query = oci_parse($conn, $sql);
        oci_bind_by_name($query, ':customername', $customername);
        oci_bind_by_name($query, ':phone', $phone);
        oci_bind_by_name($query, ':email', $email);
        oci_bind_by_name($query, ':address', $address);
        oci_execute($query);
        oci_free_statement($query);
    }

    function postRepairJob($conn, $repairjobid, $licensenumber, $model, $address, $employeeid) {
        $sql = 'INSERT INTO RepairJob (repairjobid, timein, licensenumber, model, address, employeeid) VALUES (:repairjobid, SYSTIMESTAMP, :licensenumber, :model, :address, :employeeid)';
        $query = oci_parse($conn, $sql);
        oci_bind_by_name($query, ':repairjobid', $repairjobid);
        oci_bind_by_name($query, ':licensenumber', $licensenumber);
        oci_bind_by_name($query, ':model', $model);
        oci_bind_by_name($query, ':address', $address);
        oci_bind_by_name($query, ':employeeid', $employeeid);
        oci_execute($query);
        oci_free_statement($query);
    }

    function prepareInput($inputData){
        $inputData = trim($inputData);
        $inputData = htmlspecialchars($inputData);
        return $inputData;
    }
?>