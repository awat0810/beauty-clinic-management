<!DOCTYPE html>
<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

/* Sidebar */
.sidebar {
    height: 100vh;
    width: 220px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #333;
    padding-top: 20px;

    display: flex;
    flex-direction: column;
    justify-content: space-between; /* pushes last item to bottom */
}

.sidebar a {
    display: block;
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    font-size: 16px;
}

.sidebar a:hover {
    background-color: #575757;
}

/* Footer inside sidebar */
.sidebar-footer {
    color: #bbb;
    text-align: left;
    padding: 15px;
    font-size: 14px;
    border-top: 1px solid #444;
}

/* Main content */
.main-content {
    margin-left: 220px; /* same as sidebar width */
    padding: 20px;
}

h1 {
    margin-top: 0;
}
</style>

<div class="sidebar">
    <div>
        <a href="appointment_today.php">Home</a>
        <a href="appointment_list.php">Appointments</a>
        <a href="patient_list.php">Patients</a>
        <a href="operation_list.php">Operations</a>
    </div>
    <div class="sidebar-footer">
        By : H Group
    </div>
</div>
