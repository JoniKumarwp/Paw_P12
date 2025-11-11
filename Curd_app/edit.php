<?php
include 'db.php';
$id = $_GET['id'];
 
$sql = "SELECT * FROM vehicle WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $vehicle_name = $_POST['vehicle_name'];
    $model = $_POST['model'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $newPhoto = $_FILES['photo']['name'];

    if ($newPhoto) {
        $target = 'uploads/' . basename($newPhoto);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
        if ($row['photo']) {
            unlink('uploads/' . $row['photo']);
        }
    } else {
        $newPhoto = $row['photo'];
    }

    $updateSql = "UPDATE vehicle 
                  SET vehicle_name='$vehicle_name', model='$model', brand='$brand', price='$price', photo='$newPhoto'
                  WHERE id=$id";

    if (mysqli_query($conn, $updateSql)) {
        header('Location: index.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<h2>Edit Vehicle</h2>
<form method="POST" enctype="multipart/form-data">
  Vehicle Name: <input type="text" name="vehicle_name" value="<?php echo $row['vehicle_name']; ?>" required><br><br>
  Model: <input type="text" name="model" value="<?php echo $row['model']; ?>" required><br><br>
  Brand: <input type="text" name="brand" value="<?php echo $row['brand']; ?>" required><br><br>
  Price: <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>" required><br><br>
  Current Photo: <img src="uploads/<?php echo $row['photo']; ?>" width="80"><br><br>
  New Photo: <input type="file" name="photo"><br><br>
  <button type="submit" name="update">Update</button>
</form>
