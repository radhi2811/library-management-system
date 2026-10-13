<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

// Delete Book
if(isset($_GET['delete']))
{
    $id = (int)$_GET['delete'];

    mysqli_query($conn, "DELETE FROM books WHERE id=$id");

    header("Location: manage_books.php");
    exit();
}

// Fetch Books
$books = mysqli_query($conn, "SELECT * FROM books ORDER BY id DESC");

$totalBooksQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM books");
$totalBooks = mysqli_fetch_assoc($totalBooksQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Books</title>

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
    background:#0d6efd;
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

        <div class="card-header bg-primary text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="mb-0">
                    <i class="fas fa-book"></i>
                    Manage Books
                </h3>

                <span class="badge bg-light text-dark fs-6">
                    Total Books:
                    <?php echo $totalBooks['total']; ?>
                </span>

            </div>

        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-6">

                    <input type="text"
                           id="searchBook"
                           class="form-control search-box"
                           placeholder="Search Book...">

                </div>

                <div class="col-md-6 text-end">

                    <a href="add_book.php"
                       class="btn btn-success">

                        <i class="fas fa-plus"></i>
                        Add Book

                    </a>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover"
                       id="booksTable">

                    <thead>

                    <tr>
                        <th>ID</th>
                        <th>Book Name</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Available</th>
                        <th>Cover</th>
                        <th width="180">Actions</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php while($row = mysqli_fetch_assoc($books)) { ?>

                    <tr>

                        <td><?php echo $row['id']; ?></td>
    
                        <td><?php if(!empty($row['cover_image'])) 
                       { ?>
                     <img src="../uploads/books/<?php echo $row['cover_image']; ?>"
                      width="60  height="80  style="object-fit:cover; border-radius:8px;"> <?php }
                      else { ?> No Image<?php }
                      ?> </td>

                        <td><?php echo $row['book_name']; ?></td>

                        <td><?php echo $row['author_name']; ?></td>

                        <td><?php echo $row['category']; ?></td>

                        <td><?php echo $row['quantity']; ?></td>

                        <td><?php echo $row['available_quantity']; ?></td>

                        <td>

                            <a href="edit_book.php?id=<?php echo $row['id']; ?>"
                               class="btn btn-warning btn-sm">

                                <i class="fas fa-edit"></i>
                                Edit

                            </a>

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
    return confirm("Are you sure you want to delete this book?");
}

// Live Search

document.getElementById("searchBook")
.addEventListener("keyup", function(){

    let value = this.value.toLowerCase();

    let rows =
    document.querySelectorAll("#booksTable tbody tr");

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