<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

$message = "";

// Return Book
if(isset($_GET['return']))
{
    $issue_id = (int)$_GET['return'];

    // Get Issue Record
    $issueQuery = mysqli_query($conn,
    "SELECT * FROM issued_books
     WHERE id='$issue_id'
     AND status='Issued'");

    if(mysqli_num_rows($issueQuery) > 0)
    {
        $issue = mysqli_fetch_assoc($issueQuery);

        $book_id = $issue['book_id'];
        $return_date = date("Y-m-d");

        // Update Issue Record
        mysqli_query($conn,
        "UPDATE issued_books
         SET status='Returned',
             return_date='$return_date'
         WHERE id='$issue_id'");

        // Increase Available Quantity
        mysqli_query($conn,
        "UPDATE books
         SET available_quantity = available_quantity + 1
         WHERE id='$book_id'");

        $message = "<div class='alert alert-success'>
                    Book returned successfully!
                    </div>";
    }
}

// Fetch Issued Books
$records = mysqli_query($conn,
"SELECT
    ib.id,
    s.name AS student_name,
    b.book_name,
    ib.issue_date,
    ib.return_date,
    ib.status
FROM issued_books ib
INNER JOIN students s ON ib.student_id = s.id
INNER JOIN books b ON ib.book_id = b.id
ORDER BY ib.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Return Book</title>

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
                <i class="fas fa-undo"></i>
                Return Books
            </h3>

        </div>

        <div class="card-body">

            <?php echo $message; ?>

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>

                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php while($row = mysqli_fetch_assoc($records)) { ?>

                    <tr>

                        <td><?php echo $row['id']; ?></td>

                        <td>
                            <?php echo htmlspecialchars($row['student_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['book_name']); ?>
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

                        <td>

                            <?php if($row['status'] == 'Issued') { ?>

                                <a href="?return=<?php echo $row['id']; ?>"
                                   class="btn btn-success btn-sm"
                                   onclick="return confirmReturn();">

                                    Return

                                </a>

                            <?php } else { ?>

                                <button class="btn btn-secondary btn-sm"
                                        disabled>

                                    Returned

                                </button>

                            <?php } ?>

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

function confirmReturn()
{
    return confirm(
        "Are you sure you want to return this book?"
    );
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>