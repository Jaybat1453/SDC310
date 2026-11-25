<?php
$conn = new mysqli("localhost", "ecpi_user", "Password1", "sdc310_wk3pa");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["add"])) {
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $color = $_POST["color"];
    $place = $_POST["place"];
    $nickname = $_POST["nickname"];

    $sql = "INSERT INTO personal_info (name, dob, favorite_color, favorite_place, nickname)
            VALUES ('$name', '$dob', '$color', '$place', '$nickname')";
    $conn->query($sql);
}

if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $color = $_POST["color"];
    $place = $_POST["place"];
    $nickname = $_POST["nickname"];

    $sql = "UPDATE personal_info SET name='$name', dob='$dob',
            favorite_color='$color', favorite_place='$place',
            nickname='$nickname' WHERE id=$id";
    $conn->query($sql);
}

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM personal_info WHERE id=$id");
}

$edit = null;
if (isset($_GET["edit"])) {
    $id = $_GET["edit"];
    $result = $conn->query("SELECT * FROM personal_info WHERE id=$id");
    $edit = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jayden Batista Wk 3 Performance Assessment</title>
</head>
<body>
    <h1>Jayden Batista Wk 3 Performance Assessment</h1>

    <h2><?php echo $edit ? "Update Information" : "Add Information"; ?></h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $edit['id'] ?? ''; ?>">

        Name:
        <input type="text" name="name" required value="<?php echo $edit['name'] ?? ''; ?>"><br><br>

        Date of Birth:
        <input type="date" name="dob" required value="<?php echo $edit['dob'] ?? ''; ?>"><br><br>

        Favorite Color:
        <input type="text" name="color" required value="<?php echo $edit['favorite_color'] ?? ''; ?>"><br><br>

        Favorite Place To Visit:
        <input type="text" name="place" required value="<?php echo $edit['favorite_place'] ?? ''; ?>"><br><br>

        Nickname:
        <input type="text" name="nickname" required value="<?php echo $edit['nickname'] ?? ''; ?>"><br><br>

        <?php if ($edit): ?>
            <button type="submit" name="update">Update</button>
            <a href="index.php">Cancel</a>
        <?php else: ?>
            <button type="submit" name="add">Add</button>
        <?php endif; ?>
    </form>

    <h2>Stored Personal Information</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Favorite Color</th>
            <th>Favorite Place To Visit</th>
            <th>Nickname</th>
            <th>Actions</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM personal_info");
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row["name"]); ?></td>
            <td><?php echo htmlspecialchars($row["dob"]); ?></td>
            <td><?php echo htmlspecialchars($row["favorite_color"]); ?></td>
            <td><?php echo htmlspecialchars($row["favorite_place"]); ?></td>
            <td><?php echo htmlspecialchars($row["nickname"]); ?></td>
            <td>
                <a href="index.php?edit=<?php echo $row['id']; ?>">Edit</a> |
                <a href="index.php?delete=<?php echo $row['id']; ?>"
                   onclick="return confirm('Delete this record?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
