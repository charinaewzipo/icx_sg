<?php
header('Content-Type: text/html; charset=utf-8');

include("../../function/StartConnect.inc");

function calculateAge($dob) {
    $dobDate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($dobDate)->y;
    return $age;
}

// Define age ranges
$ageRanges = [
    '0-4' => '0-4 years old',
    '5-9' => '5-9 years old',
    '10-14' => '10-14 years old',
    '15-19' => '15-19 years old',
    '20-24' => '20-24 years old',
    '25-29' => '25-29 years old',
    '30-34' => '30-34 years old',
    '35-39' => '35-39 years old',
    '40-44' => '40-44 years old',
    '45-49' => '45-49 years old',
    '50-54' => '50-54 years old',
    '55-59' => '55-59 years old',
    '60-64' => '60-64 years old',
    '65-69' => '65-69 years old (renewal only)'
];

if (isset($_POST['plan_id']) && isset($_POST['plan_poi']) && isset($_POST['insuredDateOfBirth'])) {
    $plan_id = $_POST['plan_id'];
    $plan_poi = $_POST['plan_poi'];
    $insuredDateOfBirth = $_POST['insuredDateOfBirth'];
    $age = calculateAge($insuredDateOfBirth);

    // Determine the age range
    $ageRange = '';
    foreach ($ageRanges as $range => $description) {
        list($min, $max) = explode('-', $range);
        if ($age >= $min && $age <= $max) {
            $ageRange = $description;
            break;
        }
    }

    // Use the determined age range in the SQL query
    $strSQL = "SELECT id, age_group, plan_type, net_premium 
               FROM t_aig_sg_plan 
               WHERE plan_id='$plan_id' 
                 AND age_group='$ageRange' 
                 AND plan_poi='$plan_poi'";
    $objQuery = mysqli_query($Conn, $strSQL);

    $options = "<option value=''> <-- Please select an option --></option>";

    while ($row = mysqli_fetch_array($objQuery)) {
        $options .= "<option value='{$row['id']}' 
                     data-netpremium='{$row['net_premium']}'
                     data-name='{$row['plan_type']}'
                     >{$row['plan_type']}</option>";
    }

    echo $options;
    mysqli_close($Conn);
}
?>
