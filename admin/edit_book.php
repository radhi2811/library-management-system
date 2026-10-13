<?php
session_start();
include '../includes/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

if(!isset($_GET['id']))
{
    header("Location: manage_books.php");
    exit();
}

$id = (int)$_GET['id'];

$result = mysqli_query($conn,
"SELECT * FROM books WHERE id='$id'");

if(mysqli_num_rows($result) == 0)
{
    header("Location: manage_books.php");
    exit();
}

$book = mysqli_fetch_assoc($result);

$message = "";

if(isset($_POST['update_book']))
{
    $book_name = mysqli_real_escape_string(
        $conn,
        trim($_POST['book_name'])
    );

    $author_name = mysqli_real_escape_string(
        $conn,
        trim($_POST['author_name'])
    );

    $category = mysqli_real_escape_string(
        $conn,
        trim($_POST['category'])
    );

    $quantity = (int)$_POST['quantity'];

    $available_quantity =
    (int)$_POST['available_quantity'];

    $cover_image = $book['cover_image'];

    // New Image Upload
    if(isset($_FILES['cover_image']) &&
       $_FILES['cover_image']['error'] == 0)
    {
        $file_name =
        time() . "_" .
        basename($_FILES['cover_image']['name']);

        $target_path =
        "../uploads/books/" . $file_name;

        if(move_uploaded_file(
            $_FILES['cover_image']['tmp_name'],
            $target_path))
        {
            // Delete old image
            if(!empty($book['cover_image']) &&
               file_exists(
               "../uploads/books/" .
               $book['cover_image']))
            {
                unlink(
                "../uploads/books/" .
                $book['cover_image']);
            }

            $cover_image = $file_name;
        }
    }

    $update = mysqli_query($conn,
    "UPDATE books SET
        book_name='$book_name',
        author_name='$author_name',
        category='$category',
        quantity='$quantity',
        available_quantity='$available_quantity',
        cover_image='$cover_image'
    WHERE id='$id'");

    if($update)
    {
        $message =
        "<div class='alert alert-success'>
        Book updated successfully!
        </div>";

        $result = mysqli_query($conn,
        "SELECT * FROM books WHERE id='$id'");

        $book = mysqli_fetch_assoc($result);
    }
    else
    {
        $message =
        "<div class='alert alert-danger'>
        ".mysqli_error($conn)."
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Edit Book</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

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

.preview-image{
    width:120px;
    height:160px;
    object-fit:cover;
    border-radius:10px;
    border:1px solid #ddd;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="card">

<div class="card-header bg-warning">

<h3 class="mb-0">
<i class="fas fa-edit"></i>
Edit Book
</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST"
      enctype="multipart/form-data">

<div class="mb-3">

<label class="form-label">
Book Name
</label>

<input type="text"
       name="book_name"
       class="form-control"
       value="<?php echo htmlspecialchars($book['book_name']); ?>"
       required>

</div>

<div class="mb-3">

<label class="form-label">
Author Name
</label>

<input type="text"
       name="author_name"
       class="form-control"
       value="<?php echo htmlspecialchars($book['author_name']); ?>"
       required>

</div>

<div class="mb-3">

<label class="form-label">
Category
</label>

<input type="text"
       name="category"
       class="form-control"
       value="<?php echo htmlspecialchars($book['category']); ?>"
       required>

</div>

<div class="mb-3">

<label class="form-label">
Quantity
</label>

<input type="number"
       name="quantity"
       class="form-control"
       value="<?php echo $book['quantity']; ?>"
       min="1"
       required>

</div>

<div class="mb-3">

<label class="form-label">
Available Quantity
</label>

<input type="number"
       name="available_quantity"
       class="form-control"
       value="<?php echo $book['available_quantity']; ?>"
       min="0"
       required>

</div>

<div class="mb-3">

<label class="form-label">
Current Cover Image
</label>

<br>

<?php if(!empty($book['cover_image'])) { ?>

<img
src="../uploads/books/<?php echo $book['cover_image']; ?>"
class="preview-image">

<?php } else { ?>

<p class="text-muted">
No Image Available
</p>

<?php } ?>

</div>

<div class="mb-3">

<label class="form-label">
Change Cover Image
</label>

<input type="file"
       name="cover_image"
       class="form-control"
       accept="image/*">

</div>

<button type="submit"
        name="update_book"
        class="btn btn-warning">

<i class="fas fa-save"></i>
Update Book

</button>

<a href="manage_books.php"
   class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>