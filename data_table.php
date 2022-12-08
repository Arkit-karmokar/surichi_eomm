<?php
/*$host = "127.0.0.1"; //IP of your database
$userName = "root"; //Username for database login
$userPass = ""; //Password associated with the username
$database = "webinor"; //Your database name

$connectQuery = mysqli_connect($host,$userName,$userPass,$database);*/
include('conn.php');

    $selectQuery = "SELECT *FROM create_order_list INNER JOIN order_item ON create_order_list.Order_ID=order_item.Order_ID INNER JOIN products ON products.ID=order_item.Product_ID";
    $result = mysqli_query($conn,$selectQuery);
    if(mysqli_num_rows($result) > 0){
        $result_array = array();
        while($row = mysqli_fetch_assoc($result)){
            array_push($result_array, $row);
        }

    }

    $results = ["sEcho" => 1,
        	"iTotalRecords" => count($result_array),
        	"iTotalDisplayRecords" => count($result_array),
        	"aaData" => $result_array ];
    echo json_encode($results);

?>