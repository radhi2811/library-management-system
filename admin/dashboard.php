<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

// Total Books
$booksQuery = mysqli_query($conn, "SELECT COUNT(*) AS total_books FROM books");
$books = mysqli_fetch_assoc($booksQuery);

// Total Students
$studentsQuery = mysqli_query($conn, "SELECT COUNT(*) AS total_students FROM students");
$students = mysqli_fetch_assoc($studentsQuery);

// Issued Books
$issuedQuery = mysqli_query($conn, "SELECT COUNT(*) AS total_issued FROM issued_books WHERE status='Issued'");
$issued = mysqli_fetch_assoc($issuedQuery);

 
// Returned Books
$returnedQuery = mysqli_query($conn,"SELECT COUNT(*) AS total_returned FROM issued_books WHERE status='Returned'" );
$returned = mysqli_fetch_assoc($returnedQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    background:#f4f6f9;
}

.sidebar{
    min-height:100vh;
    background:#212529;
}

.sidebar a{
    color:white;
    text-decoration:none;
    display:block;
    padding:15px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#0d6efd;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.stat-card{
    color:white;
}

</style>
</head>
<body>

<div class="container-fluid">

<div class="row">

<!-- Sidebar -->

<div class="col-md-2 sidebar p-0">

    <h4 class="text-center text-white py-4">
        <i class="fas fa-book-open"></i>
        Library
    </h4>

    <a href="dashboard.php">
        <i class="fas fa-chart-line"></i>
        Dashboard
    </a>

    <a href="add_book.php">
        <i class="fas fa-plus-circle"></i>
        Add Book
    </a>

    <a href="manage_books.php">
        <i class="fas fa-book"></i>
        Manage Books
    </a>

    <a href="students.php">
    <i class="fas fa-users"></i>
    Manage Students
</a>

<a href="return_book.php">
    <i class="fas fa-undo"></i>
    Return Book
</a>

    <a href="issue_book.php">
        <i class="fas fa-arrow-right"></i>
        Issue Book
    </a>

    <a href="../logout.php">
        <i class="fas fa-sign-out-alt"></i>
        Logout
    </a>

</div>

<!-- Main Content -->

<div class="col-md-10">

    <div class="p-4">

        <div class="card mb-4">

            <div class="card-body">

                <h2>
                    Welcome,
                    <?php echo $_SESSION['name']; ?> 👋
                </h2>

                <p class="text-muted">
                    Digital Library Management System
                    Admin Dashboard
                </p>

            </div>

        </div>

        <div class="row">

            <!-- Books Card -->

            <div class="col-md-4 mb-4">

                <div class="card stat-card bg-primary">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h5>Total Books</h5>

                                <h2>
                                    <?php echo $books['total_books']; ?>
                                </h2>

                            </div>

                            <i class="fas fa-book fa-3x"></i>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Students Card -->

            <div class="col-md-4 mb-4">

                <div class="card stat-card bg-success">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h5>Total Students</h5>

                                <h2>
                                    <?php echo $students['total_students']; ?>
                                </h2>

                            </div>

                            <i class="fas fa-user-graduate fa-3x"></i>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Issued Books Card -->

            <div class="col-md-4 mb-4">

                <div class="card stat-card bg-warning">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h5>Issued Books</h5>

                                <h2>
                                    <?php echo $issued['total_issued']; ?>
                                </h2>

                            </div>

                            <i class="fas fa-right-left fa-3x"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Returned Books Card -->

   <div class="col-md-4 mb-4">

       <div class="card stat-card bg-danger">

           <div class="card-body">

               <div class="d-flex justify-content-between">

                  <div>

                      <h5>Returned Books</h5>

                      <h2>
                          <?php echo $returned['total_returned']; ?>
                      </h2>

                  </div>

                  <i class="fas fa-undo fa-3x"></i>

              </div>

          </div>

      </div>

  </div>

        <!-- Quick Actions -->

        <div class="card">

            <div class="card-header">
                Quick Actions
            </div>

            <div class="card-body">

                <a href="add_book.php"
                   class="btn btn-primary me-2">
                    Add New Book
                </a>

                <a href="manage_books.php"
                   class="btn btn-success me-2">
                    Manage Books
                </a>

                <a href="issue_book.php"
                   class="btn btn-warning">
                    Issue Book
                </a>

            </div>

        </div>
      

<!-- Library Charts -->

<div class="row mt-4">

    <!-- Bar Chart -->

    <div class="col-lg-7 mb-4">

        <div class="card h-100">

            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Library Statistics - Bar Chart</h5>
            </div>

            <div class="card-body">
                <canvas id="libraryChart"></canvas>
            </div>

        </div>

    </div>

    <!-- Pie Chart -->

    <div class="col-lg-5 mb-4">

        <div class="card h-100">

            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Library Overview - Pie Chart</h5>
            </div>

            <div class="card-body d-flex align-items-center justify-content-center">
                <div style="width:100%; max-width:350px;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>

        </div>

    </div>

</div>



    </div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const booksCount = <?php echo (int)$books['total_books']; ?>;
const studentsCount = <?php echo (int)$students['total_students']; ?>;
const issuedCount = <?php echo (int)$issued['total_issued']; ?>;
const returnedCount = <?php echo (int)$returned['total_returned']; ?>;

const chartLabels = ['Books', 'Students', 'Issued', 'Returned'];

const chartColors = ['#0d6efd', '#198754', '#ffc107', '#dc3545'];

// Bar Chart
new Chart(document.getElementById('libraryChart'), {
    type: 'bar',

    data: {
        labels: chartLabels,
        datasets: [{
            label: 'Library Statistics',
            data: [
                booksCount,
                studentsCount,
                issuedCount,
                returnedCount
            ],
            backgroundColor: chartColors,
            borderRadius: 6
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

// Pie Chart
new Chart(document.getElementById('pieChart'), {
    type: 'pie',

    data: {
        labels: chartLabels,
        datasets: [{
            data: [
                booksCount,
                studentsCount,
                issuedCount,
                returnedCount
            ],
            backgroundColor: chartColors,
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: true,

        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>