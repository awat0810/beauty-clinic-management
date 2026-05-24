<?php


if (isset($_POST['submit'])) {
	require '../connection/conn.php';
	
    $name = $_POST['patient_name'];
    $age = $_POST['patient_age'];
    $mobile = $_POST['patient_mobile'];
    $address = $_POST['patient_address'];
	$gender = $_POST['patient_gender'];

    $insert = "INSERT INTO patient (patient_name, patient_age, patient_mobile, patient_address,patient_gender) 
                  VALUES ('$name', '$age', '$mobile', '$address','$gender')";
				  
	if($conn -> query($insert)){
				
	 echo "<script>window.location.href='appointment_add.php';</script>";
    exit;
	
	}else{
		
	echo "Error: ". $conn -> error;
	
	}	

}


require "../includes/header.php";

?>
<div class="container mt-4" >
<h2 class="mb-4">Add Patient</h2>
<form method="POST">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="patient_name" class="form-control" required>
  </div>
  
	<div class="mb-3">
	  <label class="form-label">Age</label>
	  <input type="number" name="patient_age" class="form-control" required>
	</div>

  <div class="mb-3">
    <label class="form-label">Mobile</label>
    <input type="text" name="patient_mobile" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Address</label>
    <input type="text" name="patient_address" class="form-control" required>
  </div>
  
  <p>Gender</p>
   <div class="mb-2 form-check">
		<input type="radio" class="form-check-input" name="patient_gender" value="Male" id="male"  >
		<label class="form-check-label" for="male">Male</label>
    </div>
	<div class="mb-2 form-check">
		<input type="radio" class="form-check-input" name="patient_gender" value="Female" id="female" >
		<label class="form-check-label" for="female">Female</label>
    </div>
	
  <button type="submit" name="submit" class="btn btn-success">Save</button>
  <a href="patient_list.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
<?php require "../includes/footer.php"; ?>