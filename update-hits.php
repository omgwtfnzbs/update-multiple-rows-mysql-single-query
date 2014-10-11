<?php

empty($_SERVER['SHELL']) && die('access denied');

	$conn = mysql_connect("localhost", "******", "******") or die(mysql_error());
	mysql_select_db('omgwtfnzbs', $conn) or die(mysql_error());

	$fifteen = time()-900;

	$sqli = "SELECT COUNT( nzbid ) AS  `hits` ,  `nzbid` FROM  `downloads` WHERE ctime > $fifteen GROUP BY  `nzbid`";
	$query = mysql_query($sqli) or die(mysql_error());

	$ids_array = array();

              while($row = mysql_fetch_assoc($query)){
                  $results[] = $row; $ids_array[] = "'" . $row['nzbid'] . "'";
               }

	mysql_free_result($query);

	$sql = "UPDATE nzb_details" . "\n";
	$sql .= "\t" . "SET hits = CASE reqid" . "\n";
	
	foreach ($results as $r) {
	$nzbid = $r['nzbid']; $hitcount = $r['hits'];

	$sql .= "\t\t" . "WHEN '$nzbid' THEN hits + $hitcount" . "\n";

	}

	$sql .= "\t" . "ELSE hits" . "\n";
	$sql .= "END" . "\n";

	$sql .= "WHERE reqid IN(" . implode(", ", $ids_array) . ");";

	$update = mysql_query($sql) or die(mysql_error());

	file_put_contents("/path/to/hits_updater.sql", $sql);

	mysql_close($conn);

	foreach ($results as $r) { $hc[] = $r['hits']; }
	$tot_up = array_sum($hc);
	$num_files = count($results);

	$html = print("<font color=red>cron job:</font> served $tot_up nzb files. $num_files counters updated<br/>");


?>
