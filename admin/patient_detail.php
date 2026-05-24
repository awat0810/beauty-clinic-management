<?php

require '../connection/conn.php';

$patient_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$patient_query = "SELECT * FROM patient WHERE patient_id = $patient_id";
$patient_result = $conn->query($patient_query);
$patient = mysqli_fetch_array($patient_result);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $operation = $_POST['appointment_operation'];
    $date = $_POST['appointment_date'];
    $price = $_POST['appointment_price'];
	$pay   = $_POST['appointment_payment'];	
    $note = $_POST['appointment_note'];

    $update = "UPDATE appointment 
               SET appointment_operation='$operation',
                   appointment_date='$date',
                   appointment_price='$price',
				   appointment_payment='$pay',
                   appointment_note='$note'
               WHERE appointment_id=$appointment_id AND appointment_status=0";
    $conn->query($update);

    echo "<div class='alert alert-success text-center'>✅ Appointment updated successfully!</div>";
}

$app_query = "SELECT * FROM appointment WHERE appointment_patient = $patient_id ORDER BY appointment_date DESC";
$app_result = $conn->query($app_query);

require '../includes/header.php';
?>

<div class="container mt-4">
    <a href="appointment_today.php" class="btn btn-secondary mb-3">&larr; Back</a>
	

    
    <div class="card shadow mb-4">
        <div class="card-body">
            <h3 class="card-title text-primary"><?php echo $patient['patient_name']; ?></h3>
            <p><strong>Age:</strong> <?php echo $patient['patient_age']; ?> Years</p>
            <p><strong>Mobile:</strong> <?php echo $patient['patient_mobile']; ?></p>
            <p><strong>Address:</strong> <?php echo $patient['patient_address']; ?></p>
            <p><strong>Gender:</strong> <?php echo $patient['patient_gender']; ?></p>
        </div>
    </div>

   
    <h4 class="mb-3">📅 Appointment History</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Operation</th>
                    <th>Price (IQD)</th>
					<th>Paid Money (IQD)</th>
					<th>Remain Money (IQD)</th>
                    <th>Note</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $i=0; 
            while($row = mysqli_fetch_array($app_result)) { 
                $i++; ?>
                <tr>
                    <form method="POST" action="">
                        <td><?php echo $i; ?></td>
                        <td>
                            <?php if($row['appointment_status'] == 0) { ?>
                                <input type="date" name="appointment_date" class="form-control" value="<?php echo $row['appointment_date']; ?>">
                            <?php } else { echo $row['appointment_date']; } ?>
                        </td>
                        <td style="max-width:250px; word-wrap:break-word; white-space:normal;">
                            <?php if($row['appointment_status'] == 0) { ?>
                                <input type="text" name="appointment_operation" class="form-control" value="<?php echo $row['appointment_operation']; ?>">
                            <?php } else { echo $row['appointment_operation']; } ?>
                        </td>
                        <td style="width:120px;">
                            <?php if($row['appointment_status'] == 0) { ?>
                                <input type="number" name="appointment_price" class="form-control" value="<?php echo $row['appointment_price']; ?>">
                            <?php } else { echo number_format($row['appointment_price']); } ?>
                        </td>
						 <td style="width:120px;">
                            <?php if($row['appointment_status'] == 0) { ?>
                                <input type="number" name="appointment_payment" class="form-control" value="<?php echo $row['appointment_payment']; ?>">
                            <?php } else { echo number_format($row['appointment_payment']); } ?>
                        </td>
						<td style="width:120px;">
							<?php echo number_format($row['appointment_price'] - $row['appointment_payment']); ?>
                        </td>
						
                        <td style="max-width:250px; word-wrap:break-word; white-space:normal;">
                            <?php if($row['appointment_status'] == 0) { ?>
                                <textarea name="appointment_note" class="form-control" rows="3"><?php echo $row['appointment_note']; ?></textarea>
                            <?php } else { echo nl2br($row['appointment_note']); } ?>
                        </td>
                        <td>
                            <?php echo $row['appointment_status'] == 0 
                                ? "<span class='badge bg-warning'>Pending</span>" 
                                : "<span class='badge bg-success'>Done</span>"; ?>
                        </td>
                        <td>
                            <?php if($row['appointment_status'] == 0) { ?>
                                <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                               
                            <?php } else { ?>
                                <a href="appointment_delete.php?id=<?php echo $row['appointment_id']; ?>&patient_id=<?php echo $patient_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            <?php } ?>
                        </td>
                    </form>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php require '../includes/footer.php'; ?>
