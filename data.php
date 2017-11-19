<?php
//include("config.php");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "practice_db";

$mysqli = new mysqli($servername, $username, $password, $dbname);

//$sql = "SELECT * FROM product";
$sql = "SELECT * FROM product where 1=1";
$result = $mysqli->query($sql);

while($row = $result->fetch_array(MYSQLI_ASSOC)){
  $data[] = $row;
}


$results = ["sEcho" => 1,
        	"iTotalRecords" => count($data),
        	"iTotalDisplayRecords" => count($data),
        	"aaData" => $data ];

//die("Worked!");

echo json_encode($results);
?>