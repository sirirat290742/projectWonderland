<?php
session_start();
require("local/connect.php");
header("Content-Type:application/json");

$M_id = $_POST['m_id'];
$price = $_POST['price'];
$chk = true;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $p_id => $qty) {
        $sql = "select tk_price from concert where tk_id = '$p_id'";
        $load = $con->query($sql);
        $data = $load->fetch_assoc();

        // INSERT DATA TO SELL TABLE
        $insert = "insert into booking (m_id,tk_id,tk_qty,tk_price,datesave) values ('$M_id','$p_id','$tk_qty','$price',CURRENT_TIMESTAMP)";
        if ($con->query($insert)) {
            $chk = true;
        } else {
            $chk = false;
        }
    }

}
if($chk){
    echo json_encode(array("status" => 1, "text" => "ทำการจองสำเร็จ"));
} else {
    echo json_encode(array("status" => 2, "text" => "ทำการจองไม่สำเร็จ"));
}