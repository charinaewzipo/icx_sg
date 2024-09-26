<?php
// Directory where the uploaded files will be saved
$targetDir = "app/aig/upload/"; 
$targetFile = $targetDir . basename($_FILES["file_upload"]["name"]);
$uploadOk = 1;

// Check if file was uploaded
if(isset($_FILES["file_upload"])) {

    // Check file size (limit is 20MB in this example)
    if ($_FILES["file_upload"]["size"] > 20000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // If $uploadOk is 1, move the file to the target directory
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $targetFile)) {
            echo "The file ". basename($_FILES["file_upload"]["name"]). " has been uploaded and replaced if it already existed.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

} else {
    echo "No file was uploaded.";
}
?>