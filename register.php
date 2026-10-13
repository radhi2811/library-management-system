<?php
session_start();
include 'includes/db.php';

$message = "";

if(isset($_POST['register']))
{
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, trim($_POST['confirm_password']));

    // Empty Validation
    if(empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password))
    {
        $message = "<div class='alert alert-danger'>All fields are required!</div>";
    }
    // Password Match Validation
    elseif($password != $confirm_password)
    {
        $message = "<div class='alert alert-danger'>Passwords do not match!</div>";
    }
    else
    {
        // Check Email Already Exists
        $checkEmail = mysqli_query($conn, "SELECT * FROM students WHERE email='$email'");

        if(mysqli_num_rows($checkEmail) > 0)
        {
            $message = "<div class='alert alert-warning'>Email already registered!</div>";
        }
        else
        {
            $insert = mysqli_query($conn,
            "INSERT INTO students(name,email,phone,password)
             VALUES('$name','$email','$phone','$password')");

            if($insert)
            {
                $message = "<div class='alert alert-success'>
                            Registration Successful! 
                            <a href='login.php'>Login Here</a>
                            </div>";
            }
            else
            {
                $message = "<div class='alert alert-danger'>Something went wrong!</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Registration</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    background: linear-gradient(to right, #0d6efd, #00c6ff);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.register-card{
    width:100%;
    max-width:500px;
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

.input-group-text{
    background:#f8f9fa;
}

.back-link{
    text-decoration:none;
}

</style>

</head>
<body>

<div class="container">

    <div class="card register-card mx-auto">

        <div class="card-header">
            <h3>
                <i class="fas fa-user-plus"></i>
                Student Registration
            </h3>
        </div>

        <div class="card-body p-4">

            <?php echo $message; ?>

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Full Name
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Enter Full Name"
                               required>
                    </div>

                </div>

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
                        Phone Number
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-phone"></i>
                        </span>

                        <input type="text"
                               name="phone"
                               class="form-control"
                               placeholder="Enter Phone Number"
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
                                onclick="togglePassword('password')">

                            <i class="fas fa-eye"></i>

                        </button>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Confirm Password
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>

                        <input type="password"
                               name="confirm_password"
                               id="confirm_password"
                               class="form-control"
                               placeholder="Confirm Password"
                               required>

                        <button type="button"
                                class="btn btn-outline-secondary"
                                onclick="togglePassword('confirm_password')">

                            <i class="fas fa-eye"></i>

                        </button>

                    </div>

                </div>

                <div class="d-grid">

                    <button type="submit"
                            name="register"
                            class="btn btn-primary btn-lg">

                        Register

                    </button>

                </div>

            </form>

            <div class="text-center mt-3">

                Already have an account?

                <a href="login.php" class="back-link">
                    Login
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

function togglePassword(id)
{
    let field = document.getElementById(id);

    if(field.type === "password")
    {
        field.type = "text";
    }
    else
    {
        field.type = "password";
    }
}

</script>

</body>
</html>