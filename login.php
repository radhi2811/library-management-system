<?php
session_start();
include 'includes/db.php';

$message = "";

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    // Admin Check
    $adminQuery = mysqli_query($conn,
    "SELECT * FROM admins WHERE email='$email' AND password='$password'");

    if(mysqli_num_rows($adminQuery) > 0)
    {
        $admin = mysqli_fetch_assoc($adminQuery);

        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['name'] = $admin['name'];
        $_SESSION['role'] = 'admin';

        header("Location: admin/dashboard.php");
        exit();
    }

    // Student Check
    $studentQuery = mysqli_query($conn,
    "SELECT * FROM students WHERE email='$email' AND password='$password'");

    if(mysqli_num_rows($studentQuery) > 0)
    {
        $student = mysqli_fetch_assoc($studentQuery);

        $_SESSION['user_id'] = $student['id'];
        $_SESSION['name'] = $student['name'];
        $_SESSION['role'] = 'student';

        header("Location: student/dashboard.php");
        exit();
    }

    $message = "<div class='alert alert-danger'>
                Invalid Email or Password!
                </div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    background: linear-gradient(to right,#0d6efd,#00c6ff);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-card{
    width:100%;
    max-width:450px;
    border:none;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.card-header{
    background:#0d6efd;
    color:white;
    text-align:center;
    padding:20px;
}

.back-link{
    text-decoration:none;
}

</style>

</head>
<body>

<div class="container">

    <div class="card login-card mx-auto">

        <div class="card-header">
            <h3>
                <i class="fas fa-sign-in-alt"></i>
                Login
            </h3>
        </div>

        <div class="card-body p-4">

            <?php echo $message; ?>

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Email Address
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>

                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter Email"
                               required>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               placeholder="Enter Password"
                               required>

                        <button type="button"
                                class="btn btn-outline-secondary"
                                onclick="togglePassword()">

                            <i class="fas fa-eye"></i>

                        </button>

                    </div>

                </div>

                <div class="d-grid">

                    <button type="submit"
                            name="login"
                            class="btn btn-primary btn-lg">

                        Login

                    </button>

                </div>

            </form>

            <div class="text-center mt-3">

                Don't have an account?

                <a href="register.php" class="back-link">
                    Register
                </a>

            </div>

            <div class="text-center mt-2">

                <a href="index.php" class="back-link">
                    ← Back to Home
                </a>

            </div>

        </div>

    </div>

</div>

<script>

function togglePassword()
{
    let password = document.getElementById("password");

    if(password.type === "password")
    {
        password.type = "text";
    }
    else
    {
        password.type = "password";
    }
}

</script>

</body>
</html>