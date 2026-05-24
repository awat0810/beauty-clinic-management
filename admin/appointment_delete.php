<?php
require '../connection/conn.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
	$patient_id = isset($_GET['patient_id']) ? (int) $_GET['patient_id'] : 0;

    
    $check = $conn->query("SELECT appointment_id FROM appointment WHERE appointment_id = $id LIMIT 1");

    if ($check && $check->num_rows > 0) {
      
        $delete = $conn->query("DELETE FROM appointment WHERE appointment_id = $id");

        if ($delete) {
            echo "<script>window.location.href='patient_detail.php?id=$patient_id';</script>";

            exit;
        } else {
            echo "<script>alert('Error deleting appointment.'); window.location.href='patient_detail.php?id=$patient_id';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Appointment not found.'); window.location.href='patient_detail.php?id=$patient_id';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request.');window.location.href='patient_detail.php?id=$patient_id';</script>";
    exit;
}
?>
