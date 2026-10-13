<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

$message = "";

// Students
$students = mysqli_query($conn,
"SELECT id, name FROM students ORDER BY name ASC");

// Available Books
$books = mysqli_query($conn,
"SELECT * FROM books WHERE available_quantity > 0 ORDER BY book_name ASC");

if(isset($_POST['issue_book']))
{
    $student_id = (int)$_POST['student_id'];
    $book_id = (int)$_POST['book_id'];
    $issue_date = date("Y-m-d");

    // Check Book
    $bookQuery = mysqli_query($conn,
    "SELECT * FROM books WHERE id='$book_id'");

    $book = mysqli_fetch_assoc($bookQuery);

    if(!$book)
    {
        $message = "<div class='alert alert-danger'>Book not found.</div>";
    }
    elseif($book['available_quantity'] <= 0)
    {
        $message = "<div class='alert alert-danger'>Book not available.</div>";
    }
    else
    {
        // Insert into issued_books
        $insert = mysqli_query($conn,
        "INSERT INTO issued_books
        (student_id, book_id, issue_date, status)
        VALUES
        ('$student_id', '$book_id', '$issue_date', 'Issued')");

        if($insert)
        {
            // Reduce Available Quantity
            mysqli_query($conn,
            "UPDATE books
             SET available_quantity = available_quantity - 1
             WHERE id='$book_id'");

            $message = "<div class='alert alert-success'>
                        Book issued successfully!
                        </div>";
        }
        else
        {
            $message = "<div class='alert alert-danger'>
                        Failed to issue book.
                        </div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Issue Book</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    background:#f4f6f9;
}

.issue-card{
    max-width:750px;
    margin:auto;
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

</style>

</head>
<body>

<div class="container py-5">

    <div class="card issue-card">

        <div class="card-header bg-success text-white">

            <h3 class="mb-0">
                <i class="fas fa-book-reader"></i>
                Issue Book
            </h3>

        </div>

        <div class="card-body p-4">

            <?php echo $message; ?>

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Select Student
                    </label>

                    <select name="student_id"
                            class="form-select"
                            required>

                        <option value="">
                            Choose Student
                        </option>

                        <?php
                        mysqli_data_seek($students, 0);

                        while($student =
                        mysqli_fetch_assoc($students))
                        {
                        ?>

                        <option
                        value="<?php echo $student['id']; ?>">

                        <?php echo $student['name']; ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Select Book
                    </label>

                    <select name="book_id"
                            class="form-select"
                            required>

                        <option value="">
                            Choose Book
                        </option>

                        <?php
                        mysqli_data_seek($books, 0);

                        while($book =
                        mysqli_fetch_assoc($books))
                        {
                        ?>

                        <option
                        value="<?php echo $book['id']; ?>">

                        <?php
                        echo $book['book_name']
                        . " (Available: "
                        . $book['available_quantity']
                        . ")";
                        ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Issue Date
                    </label>

                    <input type="text"
                           class="form-control"
                           value="<?php echo date('d-m-Y'); ?>"
                           readonly>

                </div>

                <div class="d-grid">

                    <button type="submit"
                            name="issue_book"
                            class="btn btn-success btn-lg">

                        Issue Book

                    </button>

                </div>

            </form>

            <div class="text-center mt-3">

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