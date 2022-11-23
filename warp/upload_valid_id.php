<?php

// Get reference to uploaded image
//$valid_id = $_FILES["valid_id"];

// Exit if no file uploaded
if (!isset($valid_id)) {
    die('No file uploaded.');
}

// Exit if image file is zero bytes
if (filesize($valid_id["tmp_name"]) <= 0) {
    die('Uploaded file has no contents.');
}

// Exit if is not a valid image file
$image_type = exif_imagetype($valid_id["tmp_name"]);
if (!$image_type) {
    die('Uploaded file is not an image.');
}

// Get file extension based on file type, to prepend a dot we pass true as the second parameter
$image_extension = image_type_to_extension($image_type, true);

// Create a unique image name
$image_name = bin2hex(random_bytes(16)) . $image_extension;

// Move the temp image file to the images directory
move_uploaded_file(
    // Temp image location
    $valid_id["tmp_name"],

    // New image location
    __DIR__ . "/shelter/production/images/valid_id/" . $image_name
);
?>