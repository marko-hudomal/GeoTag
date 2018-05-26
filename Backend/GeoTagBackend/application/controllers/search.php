<?php

mysql_connect("localhost", "root", "");
mysql_select_db("geotagdb");

if(isset($_GET['s']) && $_GET['s'] != ''){
	$s = $_GET['s'];
	$sql = "SELECT * FROM `destination` WHERE name LIKE '%$s%'";
	$result = mysql_query($sql);
	echo "Aaaaaaa";
	while($row = mysql_fetch_array($result)){
		$url = '#';
		$title = $row['name'];
		echo "<div style='' id='searchtitle'>" . "<a style='font-family: verdana; text-decoration: none; color: black;' href='$url'>" . $title . "</a>" . "</div>";
	}
	
}

?>