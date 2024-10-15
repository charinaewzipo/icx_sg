<?php include "wlog.php"; ?>
<?php
header('Content-Type: application/json; charset=utf-8');

include("../../function/StartConnect.inc");

// Sanitize and validate input parameters
$product_id = isset($_GET['product_id']) ? mysqli_real_escape_string($Conn, $_GET['product_id']) : '';
$plan_poi = isset($_GET['plan_poi']) ? mysqli_real_escape_string($Conn, $_GET['plan_poi']) : '';

// Check if product_id is provided
if (empty($product_id)) {
    echo json_encode(['error' => 'Product ID is required']);
    exit;
}

// Prepare the SQL query with placeholders
$strSQL = "SELECT * FROM t_aig_sg_plan WHERE product_id = ?";

// Add condition for payment_mode if it's provided
if (!empty($plan_poi)) {
    $plan_poi = (int)$plan_poi; 
    if ($plan_poi === 12) { // Check for plan_poi as 12
        $strSQL .= " AND plan_poi = 12";
    } else { // For any other value, exclude plan_poi = 12
        $strSQL .= " AND plan_poi <> 12";
    }
}



// Prepare the SQL statement
$stmt = mysqli_prepare($Conn, $strSQL);

if ($stmt) {
    // Bind parameters based on whether payment_mode is provided
    if (!empty($payment_mode)) {
        mysqli_stmt_bind_param($stmt, 'ss', $product_id, $payment_mode);
    } else {
        mysqli_stmt_bind_param($stmt, 's', $product_id);
    }

    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    
    // Fetch data into an array
    $plans = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $plans[] = $row;
    }

    // Return JSON data
    echo json_encode($plans);

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['error' => 'Failed to prepare SQL statement']);
}

// Close the database connection
mysqli_close($Conn);
?>
