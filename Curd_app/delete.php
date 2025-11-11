<?php
include 'db.php';
$id = $_GET['id'];

// Get image name
$get = mysqli_query($conn, "SELECT photo FROM vehicle WHERE id=$id");
$row = mysqli_fetch_assoc($get);

// Delete image file if exists
if ($row['photo'] && file_exists('uploads/' . $row['photo'])) {
    unlink('uploads/' . $row['photo']);
}

// Delete record
$sql = "DELETE FROM vehicle WHERE id=$id";
if (mysqli_query($conn, $sql)) {
    header('Location: index.php');
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
