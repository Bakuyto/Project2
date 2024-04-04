<?php
// Include your database connection file
include '../connection/connect.php';

// Initialize search text variable
$searchText = "";

// Check if search parameter is provided
if(isset($_GET['search'])) {
    // Sanitize and store the search parameter
    $searchText = mysqli_real_escape_string($conn, $_GET['search']);
}

// Prepare the SQL query with the search text parameter
$sql = "CALL update_table_column('$searchText')";
$result = $conn->query($sql);

// Prepare an array to hold the fetched data
$data = array();

if ($result && $result->num_rows > 0) {
    // Fetch each row from the result set
    while ($row = $result->fetch_assoc()) {
        // Add modified row to the data array
        $data[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output data as JSON
echo json_encode($data);
?>
