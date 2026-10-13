<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

// Delete Student
if(isset($_GET['delete']))
{
    $id = (int)$_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM students WHERE id='$id'");

    header("Location: students.php");
    exit();
}

$students = mysqli_query($conn,
"SELECT * FROM students ORDER BY id DESC");

$countQuery = mysqli_query($conn,
"SELECT COUNT(*) AS total FROM students");

$count = mysqli_fetch_assoc($countQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Manage Students</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    background:#f4f6f9;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.table th{
    background:#198754;
    color:white;
}

.search-box{
    max-width:400px;
}

</style>

</head>
<body>

<div class="container py-5">

<div class="card">

<div class="card-header bg-success text-white">

<div class="d-flex justify-content-between align-items-center">

<h3 class="mb-0">
<i class="fas fa-users"></i>
Manage Students
</h3>

<span class="badge bg-light text-dark fs-6">

Total Students:
<?php echo $count['total']; ?>

</span>

</div>

</div>

<div class="card-body">

<div class="mb-3">

<input type="text"
       id="searchStudent"
       class="form-control search-box"
       placeholder="Search Student...">

</div>

<div class="table-responsive">

<table class="table table-bordered table-hover"
       id="studentTable">

<thead>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($students)) { ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>
<?php echo htmlspecialchars($row['name']); ?>
</td>

<td>
<?php echo htmlspecialchars($row['email']); ?>
</td>

<td>
<?php echo htmlspecialchars($row['phone']); ?>
</td>

<td>

<a href="?delete=<?php echo $row['id']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirmDelete();">

<i class="fas fa-trash"></i>
Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<div class="mt-3">

<a href="dashboard.php"
   class="btn btn-secondary">

Back to Dashboard

</a>

</div>

</div>

</div>

</div>

<script>

function confirmDelete()
{
    return confirm(
    "Are you sure you want to delete this student?");
}

document.getElementById("searchStudent")
.addEventListener("keyup", function(){

let value = this.value.toLowerCase();

let rows =
document.querySelectorAll("#studentTable tbody tr");

rows.forEach(function(row){

row.style.display =
row.innerText.toLowerCase().includes(value)
? ""
: "none";

});

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>