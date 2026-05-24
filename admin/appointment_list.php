<?php
require '../connection/conn.php';



$query = "SELECT a.*, p.patient_name , p.patient_mobile, p.patient_id 
          FROM appointment a 
          JOIN patient p ON a.appointment_patient = p.patient_id
		   WHERE a.appointment_status = 0";



$query .= " ORDER BY a.appointment_date DESC";
$result = $conn->query($query);

require "../includes/header.php";
require "../includes/menu.php";
?>

<h2 class="mb-4">Appointments List</h2>



<a href="appointment_add.php" class="btn btn-primary mb-3">Add Appointment</a>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Patient</th>
	  <th>Mobile</th>
      <th>Operations</th>
      <th>Date</th>
      <th>Price</th>
      <th>Actions</th>
	
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
        <td><?php echo $row['appointment_price']; ?></td>
        <td>
		<a href="appointment_finish.php?id=<?php echo $row['appointment_id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Mark as finished?')">Finish</a>
		</td>
		
      </tr>
    <?php } ?>
  </tbody>
</table>


<?php require "../includes/footer.php"; ?>
