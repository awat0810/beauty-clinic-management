<?php
require '../connection/conn.php';



$search = '';
if(isset($_GET['search']) && $_GET['search'] != ''){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $result = $conn->query("SELECT * FROM patient 
                            WHERE patient_name LIKE '%$search%' 
                               OR patient_mobile LIKE '%$search%'");
} else {
    $result = $conn->query("SELECT * FROM patient ");
}

require "../includes/header.php";
require "../includes/menu.php";
?>



<h2 class="mb-4">Patient List</h2>
<a href="patient_add.php" class="btn btn-primary mb-3">Add Patient</a>

<form method="GET" class="mb-3">
  <input type="text" name="search" value="<?php echo $search; ?>" 
         placeholder="Search by name or mobile" style="width:250px; padding:5px;">
  <button type="submit" class="btn btn-secondary btn-sm">Search</button>
  <a href="patient_list.php" class="btn btn-light btn-sm">Reset</a>
</form>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Age</th>
      <th>Mobile</th>
      <th>Address</th>
      <th>Gender</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php $i=0; while($row = mysqli_fetch_array($result)){ $i++; ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><a href="patient_detail.php?id=<?php echo $row['patient_id']; ?>"style="text-decoration: none; color: #000000;"  ><?php echo $row['patient_name']; ?></a></td>
        <td>
          <?php 
             
            echo $row['patient_age']." Years";
          ?>
        </td>
        <td><?php echo $row['patient_mobile']; ?></td>
        <td><?php echo $row['patient_address']; ?></td>
        <td><?php echo $row['patient_gender']; ?></td>
        <td>
          <a href="patient_edit.php?id=<?php echo $row['patient_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="patient_delete.php?id=<?php echo $row['patient_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>


<?php require "../includes/footer.php"; ?>
