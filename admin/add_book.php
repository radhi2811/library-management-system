<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

$message = "";

if(isset($_POST['add_book']))
{
    $book_name = mysqli_real_escape_string($conn, trim($_POST['book_name']));
    $author_name = mysqli_real_escape_string($conn, trim($_POST['author_name']));
    $category = mysqli_real_escape_string($conn, trim($_POST['category']));
    $quantity = (int)$_POST['quantity'];

    $cover_image = "";

    // Upload Image
    if(isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0)
    {
        $file_name = time() . "_" . basename($_FILES['cover_image']['name']);

        $target_path = "../uploads/books/" . $file_name;

        if(move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_path))
        {
            $cover_image = $file_name;
        }
    }

    if(empty($book_name) || empty($author_name) || empty($category) || $quantity <= 0)
    {
        $message = "<div class='alert alert-danger'>
                    Please fill all fields correctly.
                    </div>";
    }
    else
    {
        $sql = "INSERT INTO books
        (
            book_name,
            author_name,
            category,
            quantity,
            available_quantity,
            cover_image
        )
        VALUES
        (
            '$book_name',
            '$author_name',
            '$category',
            '$quantity',
            '$quantity',
            '$cover_image'
        )";

        if(mysqli_query($conn, $sql))
        {
            $message = "<div class='alert alert-success'>
                        Book added successfully!
                        </div>";
        }
        else
        {
            $message = "<div class='alert alert-danger'>
                        Database Error: "
                        . mysqli_error($conn) .
                        "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Book</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    background:#f4f6f9;
}

.book-card{
    max-width:750px;
    margin:auto;
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.preview-image{
    width:120px;
    height:150px;
    object-fit:cover;
    border-radius:10px;
    border:1px solid #ddd;
    display:none;
}

</style>

</head>
<body>

<div class="container py-5">

<div class="card book-card">

<div class="card-header bg-primary text-white">

<h3 class="mb-0">
<i class="fas fa-plus-circle"></i>
Add New Book
</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label class="form-label">
Book Name
</label>

<input type="text"
       name="book_name"
       class="form-control"
       required>

</div>

<div class="mb-3">

<label class="form-label">
Author Name
</label>

<input type="text"
       name="author_name"
       class="form-control"
       required>

</div>

<div class="mb-3">

<label class="form-label">
Category
</label>

<input type="text"
       name="category"
       class="form-control"
       required>

</div>

<div class="mb-3">

<label class="form-label">
Quantity
</label>

<input type="number"
       name="quantity"
       class="form-control"
       min="1"
       required>

</div>

<div class="mb-3">

<label class="form-label">
Book Cover Image
</label>

<input type="file"
       name="cover_image"
       id="cover_image"
       class="form-control"
       accept="image/*">

</div>

<div class="mb-3 text-center">

<img id="preview"
     class="preview-image"
     alt="Preview">

</div>

<div class="d-grid">

<button type="submit"
        name="add_book"
        class="btn btn-primary btn-lg">

Add Book

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

<script>

document.getElementById('cover_image')
.addEventListener('change', function(e)
{
    const file = e.target.files[0];

    if(file)
    {
        const reader = new FileReader();

        reader.onload = function(event)
        {
            const preview =
            document.getElementById('preview');

            preview.src = event.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(file);
    }
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>