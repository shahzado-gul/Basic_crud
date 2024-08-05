<?php
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: login.php');
    exit();
}
?>

<?php
    $conn = mysqli_connect("localhost", "root", "", "product") or die("Database Connection Failed");

    if(isset($_POST['submit'])){
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);

        // Insert Data
        $query = "INSERT INTO product_item (item, descriptions, price) VALUES ('$name', '$description', '$price')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Product added successfully";
        } else {
            echo "Product Not Added Successfully! " . mysqli_error($conn);
        }
    }

    if(isset($_GET['delete_id'])){
        $product_id = $_GET['delete_id'];
        // Delete Data
        $query = "DELETE FROM product_item WHERE id = $product_id";
        $results = mysqli_query($conn, $query);
        if($results){
            echo "Product Deleted Successfully";
        } else {
            echo "Product Deletion Failed: " . mysqli_error($conn);
        }
    }

    // Read Data
    $query = "SELECT * FROM product_item";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <title>Basic Crud</title>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="./index.php">Basic Crud</a>
  </div>
  <div>
    <a href="./login.php" class="btn btn-primary m-2">Login</a>
  </div>
  <div>
    <a href="./register.php" class="btn btn-primary m-2">SignUp</a>
  </div>
  <div>
    <a href="./logout.php" class="btn btn-warning m-2">Logout</a>
  </div>
</nav>
  
<form action="#" method="POST" class="rounded shadow-sm">
    <div class="container mt-5">
        <h2 class="text-center mb-3 fw-bold">ADD PRODUCT</h2>
        <div class="mb-3">
            <label for="name">Item Name</label>
            <input class="form-control" type="text" name="name" placeholder="Enter Item Name" required>
        </div>
        <div class="mb-3">
            <label for="description">Item Description</label>
            <input class="form-control" type="text" name="description" placeholder="Enter Description" required>
        </div>
        <div class="mb-3">
            <label for="price">Price</label>
            <input class="form-control" type="text" name="price" placeholder="Enter Price" required>
        </div>
        <div>
            <input class="btn btn-primary w-100" type="submit" value="Submit" name="submit"/>
        </div>
    </div>
</form>

<div class="container mt-5">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">Item Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && mysqli_num_rows($result)) { ?>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['item']; ?></td>
                        <td width="40%"><?= $row['descriptions']; ?></td>
                        <td><?= $row['price']; ?></td>
                        <td>
                            <a href="edit.php?edit_id=<?= $row['id']; ?>" class="btn btn-primary">EDIT</a>
                            <a href="index.php?delete_id=<?= $row['id']; ?>" class="btn btn-danger">DELETE</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5">No Record Found!!</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
