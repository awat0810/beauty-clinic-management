<?php
require '../connection/conn.php';

$id = $_GET['id'];
$conn->query("DELETE FROM operation WHERE operation_id=$id");

echo "<script>window.location.href='operation_list.php';</script>";
exit;
?>
