<?php
require '../connection/conn.php';

if (isset($_POST['submit'])) {
    $name = $_POST['operation_name'];
    $insert = "INSERT INTO operation (operation_name) VALUES ('$name')";
	
	if($conn->query($insert)){
		echo "<script>window.location.href='operation_list.php';</script>";
    exit;
	
	}else{
			echo "Error: ". $conn -> error;
    }
}

require "../includes/header.php";

?>
<div class="container mt-4" >
<h2 class="mb-4">Add Operation</h2>
<form method="POST">
  <div class="mb-3">
    <label class="form-label">Operation Name</label>
    <input type="text" name="operation_name" class="form-control" required>
  </div>
  <button type="submit" name="submit" class="btn btn-success">Save</button>
  <a href="operation_list.php" class="btn btn-secondary">Cancel</a>
</form>
</div>

<?php require "../includes/footer.php"; ?>
