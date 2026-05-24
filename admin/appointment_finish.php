<?php
require '../connection/conn.php';

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    // Get price and payment
    $check = $conn->query("SELECT appointment_price, appointment_payment, appointment_patient 
                           FROM appointment WHERE appointment_id = $id");

    if($check && $check->num_rows > 0){
        $row = $check->fetch_assoc();
        $price = (int)$row['appointment_price'];
        $payment = (int)$row['appointment_payment'];

        if($price == $payment){
            // Update status to 1 (Done)
            $update = "UPDATE appointment SET appointment_status = 1 WHERE appointment_id = $id";
            if($conn->query($update)){
                echo "<script>alert('Appointment marked as paid.'); window.location.href='appointment_list.php';</script>";
                exit;
            } else {
                echo "Error updating: " . $conn->error;
            }
        } else {
            $remain = $price - $payment;
            echo "<script>alert('Patient still needs to pay $remain IQD.'); window.location.href='appointment_list.php';</script>";
            exit;
        }
    } else {
        echo "Appointment not found.";
    }
} else {
    echo "No appointment ID provided.";
}
?>

