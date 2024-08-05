<?php
    $connection = mysqli_connect("localhost", "root", "", "product");
    if (!$connection) {
        echo "Database Connection Failed!";
        die("Connection failed: " . mysqli_connect_error());
    }

    $product = [];
    $product_id = null;

    if(isset($_GET['edit_id'])){
        $product_id = $_GET['edit_id'];
    

        $query = "SELECT * FROM product_item WHERE id = $product_id";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
        } else {
            die("Product Not Found.");
        }

    if(isset($_POST['update'])){
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $description = mysqli_real_escape_string($connection, $_POST['description']);
        $price = mysqli_real_escape_string($connection, $_POST['price']);

        $query =  "UPDATE product_item SET item='$name', descriptions='$description', price='$price' WHERE id = $product_id";
        $result = mysqli_query($connection, $query);
        if($result){
            header("Location: index.php?message=Product Updated Successfully!");
        }
        else{
            echo "Error";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=], initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<style>
</style>
<body>
    <form action="edit.php?edit_id=<?= $product_id ?>" method="POST" class="rounded shadow-sm">
        <div class="container mt-5">
            <h2 class="text-center mb-3 fw-bold">EDIT PRODUCT</h2>
            <div class="mb-3">
                <label for="">Item Name</label>
                <input class="form-control" type="text" name="name" placeholder="Enter Item Name" value="<?= $product['item'] ?? "" ?>">
            </div>
            <div class="mb-3">
                <label for="">Item Description</label>
                <input class="form-control" type="text" name="description" placeholder="Enter Description" value="<?= $product['descriptions'] ?? "" ?>">
            </div>
            <div class="mb-3">
                <label for="">Price</label>
                <input class="form-control" type="text" name="price" placeholder="Enter Price" value="<?= $product['price'] ?? "" ?>">
            </div>
            <div>
                <input class="btn btn-primary w-100" type="submit" value="UPDATE" name="update"/>
            </div>
        </div>
    </form>
</body>
</html>