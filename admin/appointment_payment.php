<?php
require '../connection/conn.php';


$appointment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($appointment_id > 0) {
  
    $update = "
        UPDATE appointment 
        SET appointment_payment = appointment_price, 
            appointment_status = 1
        WHERE appointment_id = $appointment_id
    ";

    if ($conn->query($update)) {
        echo "<script>
                
                window.location.href = 'appointment_today.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error: " . $conn->error . "');
                window.location.href = 'appointment_today.php';
              </script>";
    }
} else {
    echo "<script>
            alert('❌ Invalid appointment ID.');
            window.location.href = 'appointment_today.php';
          </script>";
}
?>
