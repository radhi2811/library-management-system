<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student')
{
    header("Location: ../login.php");
    exit();
}

$books = mysqli_query($conn,
"SELECT * FROM books ORDER BY book_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Search Books</title>

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

            <h3 class="mb-0">
                <i class="fas fa-search"></i>
                Search Books
            </h3>

        </div>

        <div class="card-body">

            <div class="mb-3">

                <input type="text"
                       id="searchBook"
                       class="form-control search-box"
                       placeholder="Search by Book Name, Author or Category">

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover"
                       id="booksTable">

                    <thead>

                    <tr>
                        <th>ID</th>
                        <th>Cover</th>
                        <th>Book Name</th>
                        <th>Author</th>
                        <th>Category</th>    
                        <th>Total Quantity</th>
                        <th>Available</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php while($row = mysqli_fetch_assoc($books)) { ?>

                    <tr>

                        <td><?php echo $row['id']; ?></td>

                       <td>

<?php if(!empty($row['cover_image'])) { ?>

<img src="../uploads/books/<?php echo $row['cover_image']; ?>"
     width="60"
     height="80"
     style="object-fit:cover;
            border-radius:8px;">

<?php } else { ?>

No Image

<?php } ?>

</td>

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
                            <?php echo $row['quantity']; ?>
                        </td>

                        <td>

                            <?php if($row['available_quantity'] > 0) { ?>

                                <span class="badge bg-success">
                                    <?php echo $row['available_quantity']; ?>
                                </span>

                            <?php } else { ?>

                                <span class="badge bg-danger">
                                    Out of Stock
                                </span>

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