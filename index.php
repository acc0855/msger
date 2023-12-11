<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "base";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connection was successful<br>";

    $sql = "CREATE TABLE IF NOT EXISTS phptrip (
        sno INT(6) NOT NULL AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        dest VARCHAR(50) NOT NULL,
        PRIMARY KEY (sno)
    )";

    if (mysqli_query($conn, $sql)) {
        echo "The table was created successfully!<br>";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = mysqli_real_escape_string($conn, $_POST['name']);

        $insertData = "INSERT INTO phptrip (name, dest) VALUES ('$name', 'SomeDestination')";
        if (mysqli_query($conn, $insertData)) {
            echo "Data inserted successfully!<br>";
        } else {
            echo "Error inserting data: " . mysqli_error($conn);
        }
    }

    // Retrieve names from the database
    $fetchNames = "SELECT name FROM phptrip";
    $result = mysqli_query($conn, $fetchNames);

    if (mysqli_num_rows($result) > 0) {
        echo "Names in the database:<br>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['name'] . "<br>";
        }
    } else {
        echo "No names found in the database";
    }
}

mysqli_close($conn);
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Name: <input type="text" name="name"><br>
    <input type="submit" value="Submit">
</form>
