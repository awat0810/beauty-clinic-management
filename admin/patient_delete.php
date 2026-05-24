<?php
require '../connection/conn.php';

$id = (int)$_GET['id'];

$check = $conn->query("SELECT 1 FROM appointment WHERE appointment_patient = $id LIMIT 1");

if ($check->num_rows > 0) {

    echo "<script>alert('Cannot delete this patient. They have related data in appointment.'); window.location.href='patient_list.php';</script>";
    exit;
} else {
  
    $conn->query("DELETE FROM patient WHERE patient_id = $id");
    echo "<script>window.location.href='patient_list.php';</script>";
    exit;
}
?>
