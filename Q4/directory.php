<?php
$directory = 'uploads/';

if (is_dir($directory)) {
    if ($handle = opendir($directory)) {
        echo "Files in '$directory':<br><br>";

        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != "..") {
                echo "File: $file<br>";
            }
        }

        closedir($handle);
    }
} else {
    echo "The specified directory does not exist.";
}
?>
