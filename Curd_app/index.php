<?php
include 'db.php';

 
$search = isset($_GET['search']) ? $_GET['search'] : '';

 
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

 
$countSql = "SELECT COUNT(*) AS total FROM vehicle WHERE vehicle_name LIKE '%$search%'";
$countResult = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countResult);
$total = $countRow['total'];
$pages = ceil($total / $limit);

 
$sql = "SELECT * FROM vehicle WHERE vehicle_name LIKE '%$search%' LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);
?>

<h2>Vehicle List</h2>
<form method="GET">
  <input type="text" name="search" placeholder="Search by vehicle name..." value="<?php echo $search; ?>">
  <button type="submit">Search</button>
</form>

<a href="add.php">+ Add New Vehicle</a>
<br><br>

<table border="1" cellpadding="10">
  <tr>
    <th>ID</th>
    <th>Vehicle Name</th>
    <th>Model</th>
    <th>Brand</th>
    <th>Price</th>
    <th>Photo</th>
    <th>Action</th>
  </tr>

  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['vehicle_name']; ?></td>
    <td><?php echo $row['model']; ?></td>
    <td><?php echo $row['brand']; ?></td>
    <td><?php echo $row['price']; ?></td>
    <td><img src="uploads/<?php echo $row['photo']; ?>" width="80"></td>
    <td>
      <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
      <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this record?')">Delete</a>
    </td>
  </tr>
  <?php } ?>
</table>

<?php for ($i = 1; $i <= $pages; $i++) { ?>
  <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
<?php } ?>
