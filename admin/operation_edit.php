<?php
require '../connection/conn.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM operation WHERE operation_id=$id");
$operation = mysqli_fetch_array($result);

if (isset($_POST['submit'])) {
    $name = $_POST['operation_name'];
    $update = "UPDATE operation SET operation_name='$name' WHERE operation_id=$id";
	
	if($conn -> query($update)){
    echo "<script>window.location.href='operation_list.php';</script>";
    exit;
	} else { echo "Error: ". $conn -> error; }
}

require "../includes/header.php";

?>
<div class="container mt-4" >
<h2 class="mb-4">Edit Operation</h2>
<form method="POST">
  <div class="mb-3">
    <label class="form-label">Operation Name</label>
    <input type="text" name="operation_name" class="form-control" value="<?php echo $operation['operation_name']; ?>" required>
  </div>
  <button type="submit" name="submit" class="btn btn-success">Update</button>
  <a href="operation_list.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
<?php require "../includes/footer.php"; ?>
