<?php
require '../connection/conn.php';


$result = $conn->query("SELECT * FROM operation");

require "../includes/header.php";
require "../includes/menu.php";
?>


<h2 class="mb-4">Operation List</h2>
<a href="operation_add.php" class="btn btn-primary mb-3">Add Operation</a>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Operation Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php $i=0;
    while($row = mysqli_fetch_array($result)) { $i++;
    ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row['operation_name']; ?></td>
        <td>
          <a href="operation_edit.php?id=<?php echo $row['operation_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="operation_delete.php?id=<?php echo $row['operation_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
      </tr>
    <?php 
    } 
    ?>
  </tbody>
</table>


<?php require "../includes/footer.php"; ?>
