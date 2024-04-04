<?php
include '../connection/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['id'];
    $newValue = $_POST['newValue'];
    $column = $_POST['column'];

    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("UPDATE tblproduct_transaction JOIN tblproduct_sales_months ON tblproduct_transaction.product_pk = tblproduct_sales_months.product_fk SET $column = ? WHERE product_pk = ?");
    $stmt->bind_param("si", $newValue, $productId);

    if ($stmt->execute()) {
        // Return success message as JSON
        echo json_encode(['success' => true, 'message' => 'Updated successfully']);
    } else {
        // Return error message as JSON
        echo json_encode(['success' => false, 'message' => 'Error updating record: ' . $conn->error]);
    }

    $stmt->close();
}

$conn->close();
