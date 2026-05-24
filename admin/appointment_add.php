<?php
require '../connection/conn.php';
require "../includes/header.php";

// Fetch patients
$patients_res = $conn->query("SELECT * FROM patients ORDER BY name ASC");
$patients = [];
while($p = mysqli_fetch_array($patients_res)){
    $patients[] = $p;
}

// Fetch doctors related to this secretary
$secretary_id = $_SESSION['id'];
$doctors_res = $conn->query("
    SELECT d.* FROM doctors d
    INNER JOIN doctor_secretaries ds ON d.id = ds.doctor_id
    WHERE ds.secretary_id = $secretary_id
");
$doctors = [];
while($d = mysqli_fetch_array($doctors_res)){
    $doctors[] = $d;
}

// Handle form submission
if(isset($_POST['add'])) {    
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];

    if($patient_id == '' || $doctor_id == '' || $appointment_date == ''){
        $error = "Please fill in all required fields.";
    } else {
        $insert = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, status) 
                   VALUES ('$patient_id', '$doctor_id', '$appointment_date', 'scheduled')";
        if($conn->query($insert)){
            echo "<script>window.location.href='appointments_today.php';</script>";
            exit;
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Add Appointment</h2>

    <?php if(isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">
        <!-- Patient -->
        <div class="mb-3 position-relative">
            <label class="form-label">Patient Name</label>
            <input type="text" autocomplete="off" id="patient_search" class="form-control" placeholder="Type patient name..." required>
            <input type="hidden" name="patient_id" id="patient_id">
            <div id="suggestions" class="border bg-white position-absolute w-100" style="max-height:150px; overflow-y:auto; z-index:1000; display:none;"></div>
        </div>

        <!-- Doctor -->
        <div class="mb-3">
            <label class="form-label">Doctor</label>
            <select name="doctor_id" class="form-select" required>
                <option value="">Select Doctor</option>
                <?php foreach($doctors as $d){ ?>
                    <option value="<?php echo $d['id']; ?>"><?php echo $d['name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <!-- Date -->
        <div class="mb-3">
            <label class="form-label">Appointment Date</label>
            <input type="date" name="appointment_date" class="form-control" required>
        </div>

        <button type="submit" name="add" class="btn btn-primary">Add Appointment</button>
        <a href="appointments_today.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
// Live search for patients
const patients = <?php echo json_encode($patients); ?>;
const input = document.getElementById('patient_search');
const hiddenId = document.getElementById('patient_id');
const suggestions = document.getElementById('suggestions');

input.addEventListener('input', function(){
    const val = input.value.toLowerCase();
    suggestions.innerHTML = '';
    if(val.length === 0){
        suggestions.style.display = 'none';
        hiddenId.value = '';
        return;
    }
    const matches = patients.filter(p => p.name.toLowerCase().includes(val));
    if(matches.length > 0){
        matches.forEach(p => {
            const div = document.createElement('div');
            div.textContent = p.name + " (" + p.phone + ")";
            div.classList.add('p-2');
            div.style.cursor = 'pointer';
            div.addEventListener('click', () => {
                input.value = p.name;
                hiddenId.value = p.id;
                suggestions.style.display = 'none';
            });
            suggestions.appendChild(div);
        });
        suggestions.style.display = 'block';
    } else {
        suggestions.style.display = 'none';
        hiddenId.value = '';
    }
});

document.addEventListener('click', function(e){
    if(!suggestions.contains(e.target) && e.target !== input){
        suggestions.style.display = 'none';
    }
});

document.querySelector('form').addEventListener('submit', function(e){
    if(hiddenId.value === ''){
        alert('Please select a valid patient from the list.');
        e.preventDefault();
    }
});
</script>

<?php require "../includes/footer.php"; ?>
