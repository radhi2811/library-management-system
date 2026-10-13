<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student')
{
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$message = "";

// Get Student Details
$result = mysqli_query($conn,
"SELECT * FROM students WHERE id='$student_id'");

$student = mysqli_fetch_assoc($result);

// Update Profile
if(isset($_POST['update_profile']))
{
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    $update = mysqli_query($conn,
    "UPDATE students SET
     name='$name',
     email='$email',
     phone='$phone',
     password='$password'
     WHERE id='$student_id'");

    if($update)
    {
        $_SESSION['name'] = $name;

        $message = "<div class='alert alert-success'>
                    Profile updated successfully!
                    </div>";

        $result = mysqli_query($conn,
        "SELECT * FROM students WHERE id='$student_id'");

        $student = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6f9;
}
.profile-card{
    max-width:700px;
    margin:auto;
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

<div class="container py-5">

<div class="card profile-card">

<div class="card-header bg-primary text-white">
<h3>My Profile</h3>
</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label>Name</label>
<input type="text"
       name="name"
       class="form-control"
       value="<?php echo htmlspecialchars($student['name']); ?>"
       required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email"
       name="email"
       class="form-control"
       value="<?php echo htmlspecialchars($student['email']); ?>"
       required>
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text"
       name="phone"
       class="form-control"
       value="<?php echo htmlspecialchars($student['phone']); ?>"
       required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="text"
       name="password"
       class="form-control"
       value="<?php echo htmlspecialchars($student['password']); ?>"
       required>
</div>

<button type="submit"
        name="update_profile"
        class="btn btn-primary">

Update Profile

</button>

<a href="dashboard.php"
   class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

</div>

</body>
</html>