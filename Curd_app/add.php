<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $vehicle_name = $_POST['vehicle_name'];
    $model = $_POST['model'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $photo = $_FILES['photo']['name'];
    $target = 'uploads/' . basename($photo);

    // Make sure folder exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        $sql = "INSERT INTO vehicle (vehicle_name, model, brand, price, photo)
                VALUES ('$vehicle_name', '$model', '$brand', '$price', '$photo')";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "File upload failed!";
    }
}
?>

<h2>Add New Vehicle</h2>
<form method="POST" enctype="multipart/form-data">
  Vehicle Name: <input type="text" name="vehicle_name" required><br><br>
  Model: <input type="text" name="model" required><br><br>
  Brand: <input type="text" name="brand" required><br><br>
  Price: <input type="number" step="0.01" name="price" required><br><br>
  Photo: <input type="file" name="photo" required><br><br>
  <button type="submit" name="submit">Save</button>
</form>
