<?php 
include "wlog.php";
header('Content-Type: application/json; charset=utf-8');

include("../../function/StartConnect.inc");

// Sanitize and validate input parameters
$product_id = isset($_GET['product_id']) ? mysqli_real_escape_string($Conn, $_GET['product_id']) : '';
$plan_poi = isset($_GET['plan_poi']) ? mysqli_real_escape_string($Conn, $_GET['plan_poi']) : '';
$plan_group = isset($_GET['plan_group']) ? mysqli_real_escape_string($Conn, $_GET['plan_group']) : '';

// Check if product_id is provided
if (empty($product_id)) {
    echo json_encode(['error' => 'Product ID is required']);
    exit;
}

// Prepend '%' to the plan_group to match values ending with plan_group
$plan_group = $plan_group . '%';

// Prepare the base SQL query
$strSQL = "SELECT * FROM t_aig_sg_plan WHERE product_id = ? AND plan_group LIKE ?";

// Add condition for plan_poi if it's provided
if (!empty($plan_poi)) {
    $plan_poi = (int)$plan_poi; 
    if ($plan_poi === 12) { // Check for plan_poi = 12
        $strSQL .= " AND plan_poi = 12";
    } else { // For any other value, exclude plan_poi = 12
        $strSQL .= " AND plan_poi <> 12";
    }
}

// Prepare the SQL statement
if ($stmt = mysqli_prepare($Conn, $strSQL)) {
    // Bind parameters for product_id and plan_group
    mysqli_stmt_bind_param($stmt, 'ss', $product_id, $plan_group);

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
    // Output the MySQL error for debugging
    echo json_encode(['error' => 'Failed to prepare SQL statement: ' . mysqli_error($Conn)]);
}

// Close the database connection
mysqli_close($Conn);
?>
