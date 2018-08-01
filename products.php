<?php
$servername = "localhost:3306";
$username = "root";
$password = $Row="";
$products= array();
$conn = mysqli_connect($servername, $username, $password,'products');
if(!$conn){
	die("connection failed: ". mysqli_connect_error());
}
$sql_shop = "select * from Sells";
$result_shop = mysqli_query($conn, $sql_shop);
if(mysqli_num_rows($result_shop) > 0){
	while($Row = mysqli_fetch_assoc($result_shop)){
$products[] = $Row;
	}
}
?>

