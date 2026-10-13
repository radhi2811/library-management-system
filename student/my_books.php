<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student')
{
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

$books = mysqli_query($conn,
"SELECT
    ib.id,
    b.book_name,
    b.author_name,
    b.category,
    ib.issue_date,
    ib.return_date,
    ib.status
FROM issued_books ib
INNER JOIN books b ON ib.book_id = b.id
WHERE ib.student_id = '$student_id'
ORDER BY ib.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>My Books</title>

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

</style>

</head>
<body>

<div class="container py-5">

    <div class="card">

        <div class="card-header bg-success text-white">

            <h3 class="mb-0">
                <i class="fas fa-book-reader"></i>
                My Books
            </h3>

        </div>

        <div class="card-body">

            <?php if(mysqli_num_rows($books) > 0) { ?>

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>

                    <tr>
                        <th>ID</th>
                        <th>Book Name</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php while($row = mysqli_fetch_assoc($books)) { ?>

                    <tr>

                        <td><?php echo $row['id']; ?></td>

                        <td>
                            <?php echo htmlspecialchars($row['book_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['author_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['category']); ?>
                        </td>

                        <td>
                            <?php echo $row['issue_date']; ?>
                        </td>

                        <td>
                            <?php
                            echo $row['return_date']
                            ? $row['return_date']
                            : '-';
                            ?>
                        </td>

                        <td>

                            <?php if($row['status'] == 'Issued') { ?>

                                <span class="badge bg-warning text-dark">
                                    Issued
                                </span>

                            <?php } else { ?>

                                <span class="badge bg-success">
                                    Returned
                                </span>

                            <?php } ?>

                        </td>

                    </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

            <?php } else { ?>

                <div class="alert alert-info">

                    You have not borrowed any books yet.

                </div>

            <?php } ?>

            <div class="mt-3">

                <a href="dashboard.php"
                   class="btn btn-secondary">

                    Back to Dashboard

                </a>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>