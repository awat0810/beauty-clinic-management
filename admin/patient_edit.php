<?php
require '../connection/conn.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM patient WHERE patient_id=$id");
$patient = mysqli_fetch_array($result);

if (isset($_POST['submit'])) {
    $name = $_POST['patient_name'];
    $age = $_POST['patient_age'];
    $mobile = $_POST['patient_mobile'];
    $address = $_POST['patient_address'];
	$gender = $_POST['patient_gender'];

    $update = "UPDATE patient SET 
                    patient_name='$name', 
                    patient_age='$age', 
                    patient_mobile='$mobile', 
                    patient_address='$address',
					patient_gender='$gender'	
                  WHERE patient_id=$id";
	if($conn->query($update)){

	 echo "<script>window.location.href='patient_list.php';</script>";
    exit;
	} else {
		echo "Error: ". $conn -> error;
	}
}

require "../includes/header.php";
?>
<div class="container mt-4" >
<h2 class="mb-4">Edit Patient</h2>
<form method="POST">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="patient_name" class="form-control" value="<?php echo $patient['patient_name']; ?>" required>
  </div>
  
	<div class="mb-3">
	  <label class="form-label">Age</label>
	  <input type="number" name="patient_age" class="form-control" value="<?php echo $patient['patient_age']; ?>" required>
	</div>

  <div class="mb-3">
    <label class="form-label">Mobile</label>
    <input type="number" name="patient_mobile" class="form-control" value="<?php echo $patient['patient_mobile']; ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Address</label>
    <input type="text" name="patient_address" class="form-control" value="<?php echo $patient['patient_address']; ?>" >
  </div>
	<p>Gender</p>
   <div class="mb-2 form-check">
    <input type="radio" class="form-check-input" name="patient_gender" value="Male" id="male"   <?php if($patient['patient_gender'] == "Male") echo 'checked'; ?>>
    <label class="form-check-label" for="male">Male</label>
    </div>
	<div class="mb-2 form-check">
		<input type="radio" class="form-check-input" name="patient_gender" value="Female" id="female" <?php if($patient['patient_gender'] == "Female") echo 'checked'; ?>>
		<label class="form-check-label" for="female">Female</label>
    </div>
	
	
  <button type="submit" name="submit" class="btn btn-success">Update</button>
  <a href="patient_list.php" class="btn btn-secondary">Cancel</a>
</form>

</div>

<?php require "../includes/footer.php"; ?>
