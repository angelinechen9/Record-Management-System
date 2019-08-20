<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$conn = oci_connect('achen2', 'Enterprise1701D', '//dbserver.engr.scu.edu/db11g');
		if (!$conn) {
			print "<br> connection failed:";
			exit;
		}
		$max = oci_parse($conn, 'SELECT name FROM Mechanic WHERE employeeid IN (SELECT employeeid FROM Log GROUP BY employeeid HAVING SUM(laborhours) >= ALL (SELECT SUM(laborhours) FROM Log GROUP BY employeeid))');
		oci_execute($max);
		echo "Show a listing of the mechanics who worked the most number of hours.", "<br>\n";
		while (($row = oci_fetch_array($max, OCI_BOTH)) != false) {
			echo "name: ", $row['NAME'], "<br>\n";
			echo "<br>\n";
		}
		oci_free_statement($max);
		$min = oci_parse($conn, 'SELECT name FROM Mechanic WHERE employeeid IN (SELECT employeeid FROM Log GROUP BY employeeid HAVING SUM(laborhours) <= ALL (SELECT SUM(laborhours) FROM Log GROUP BY employeeid))');
		oci_execute($min);
		echo "Show a listing of the mechanics who worked the least number of hours.", "<br>\n";
		while (($row = oci_fetch_array($min, OCI_BOTH)) != false) {
			echo "name: ", $row['NAME'], "<br>\n";
			echo "<br>\n";
		}
		oci_free_statement($min);
		$avg = oci_parse($conn, 'SELECT name, totallaborhours FROM Mechanic NATURAL JOIN (SELECT employeeid, SUM(laborhours) / COUNT(*) AS totallaborhours FROM Log GROUP BY employeeid)');
		oci_execute($avg);
		echo "Show the average number of hours each mechanic worked.", "<br>\n";
		while (($row = oci_fetch_array($avg, OCI_BOTH)) != false) {
			echo "name: ", $row['NAME'], "<br>\n";
			echo "total labor hours: ", $row['TOTALLABORHOURS'], "<br>\n";
			echo "<br>\n";
		}
		oci_free_statement($avg);
		oci_close($conn);
	}
?>