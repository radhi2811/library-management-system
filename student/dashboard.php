<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student')
{
    header("Location: ../login.php");
    exit();
}

// Total Books
$booksQuery = mysqli_query($conn,
"SELECT COUNT(*) AS total_books FROM books");
$books = mysqli_fetch_assoc($booksQuery);

// My Issued Books
$user_id = $_SESSION['user_id'];

$issuedQuery = mysqli_query($conn,
"SELECT COUNT(*) AS total_issued
 FROM issued_books
 WHERE student_id='$user_id'
 AND status='Issued'");

$issued = mysqli_fetch_assoc($issuedQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Dashboard</title>

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
</style>
</head>
<body>

<div class="container py-5">

    <div class="card mb-4">
        <div class="card-body">
            <h2>
                Welcome,
                <?php echo $_SESSION['name']; ?> 👋
            </h2>

            <p class="text-muted">
                Student Dashboard
            </p>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6 mb-4">

            <div class="card bg-primary text-white">

                <div class="card-body">

                    <h5>Total Books</h5>

                    <h2>
                        <?php echo $books['total_books']; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card bg-success text-white">

                <div class="card-body">

                    <h5>My Issued Books</h5>

                    <h2>
                        <?php echo $issued['total_issued']; ?>
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <a href="search_books.php"
               class="btn btn-primary me-2">

                Search Books

            </a>

            <a href="my_books.php"
               class="btn btn-success me-2">

                My Books

            </a>
     
        <a href="profile.php"
   class="btn btn-warning me-2">
   My Profile
</a>

            <a href="../logout.php"
               class="btn btn-danger">

                Logout

            </a>

        </div>

    </div>

</div>

</body>
</html>