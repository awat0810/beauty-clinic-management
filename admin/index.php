<?php
require '../connection/conn.php';



$filter_date = date('Y-m-d');


if(isset($_GET['appointment_date']) && $_GET['appointment_date'] != ''){
    $filter_date = $_GET['appointment_date'];
}


$query = "SELECT a.*, p.patient_name, p.patient_mobile, p.patient_id 
          FROM appointment a
          JOIN patient p ON a.appointment_patient = p.patient_id
          WHERE a.appointment_date = '$filter_date'
          ORDER BY a.appointment_date ASC";

$result = $conn->query($query);

require "../includes/header.php";
require "../includes/menu.php";

?>

<h2>Appointments on <?php echo date('d-m-Y', strtotime($filter_date)); ?></h2>


<form method="GET" class="mb-4 d-flex align-items-center">
    <div class="me-2">
        <label for="appointment_date" class="form-label fw-bold">Select Date:</label>
        <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="<?php echo $filter_date; ?>">
    </div>
    <div class="mt-4">
        <button class="btn btn-primary mt-2" type="submit">Filter</button>
        <a href="?appointment_date=<?php echo date('Y-m-d'); ?>" class="btn btn-secondary mt-2 ms-2">Today</a>
		<a href="appointment_pdf.php?appointment_date=<?php echo $filter_date; ?>" class="btn btn-danger mt-2 ms-2" target="_blank">Generate PDF</a>
   
    </div>
</form>

<a href="appointment_add.php" class="btn btn-success mb-3">Add Appointment</a>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>#</th>
      <th>Patient</th>
      <th>Mobile</th>
      <th>Operations</th>
      <th>Date</th>
      <th>Price (IQD)</th>
      <th>Status</th>
	 
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; while($row = mysqli_fetch_array($result)) { ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><a href="patient_detail.php?id=<?php echo $row['patient_id']; ?>"style="text-decoration: none; color: #000000;"  ><?php echo $row['patient_name']; ?></a></td>
        
        <td><?php echo $row['patient_mobile']; ?></td>
        <td><?php echo $row['appointment_operation']; ?></td>
        <td><?php echo $row['appointment_date']; ?></td>
        <td><?php echo number_format($row['appointment_price']); ?></td>
		
		
		<td><?php if($row['appointment_payment'] == 0){?> <a href="appointment_payment.php?id=<?php echo $row['appointment_id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Mark as payed?')">Payment</a>
          <?php } else if($row['appointment_status'] == 0){?>
            <a href="appointment_finish.php?id=<?php echo $row['appointment_id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Mark as finished?')">Finish</a>
          <?php } else { ?>
            <span class="badge bg-secondary">DONE</span>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>


<?php require "../includes/footer.php"; ?>
