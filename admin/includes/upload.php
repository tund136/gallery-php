<?php
if(isset($_POST['submit'])) {
    echo "<pre>";
    print_r($_FILES['file_upload']);
    echo "<pre>";

    $upload_errors = array(
        UPLOAD_ERR_OK           => "There is no error.",
        UPLOAD_ERR_INI_SIZE     => "The uploaded file exceeds the upload_max_filesize directive in php.nit.",
        UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was  specified in php.init.",
        UPLOAD_ERR_PARTIAL      => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE      => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload."
    );

    $temp_name = $_FILES['file_upload']['tmp_name'];
    $the_file = $_FILES['file_upload']['name'];
    $directory = "uploads";

    $the_error = $_FILES['file_upload']['error'];
    $the_message = $upload_errors[$the_error];
}
?>