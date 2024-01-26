<?php

function deleteOldFiles() {
    $directory = 'output-files/';
    $files = scandir($directory);
    $current_time = time();

    foreach ($files as $file) {
        if (is_dir($directory . $file)) {
            continue;
        }

        $file_creation_time = filemtime($directory . $file);
        $age_in_days = ($current_time - $file_creation_time) / 86400; // 86400 seconds in a day

        if ($age_in_days > 365) {
            unlink($directory . $file);
            echo "Deleted file: " . $file . "\n";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    if ($_FILES["fileToUpload"]["error"] == 0) {
        $inputDirectory = "input-files";
        $outputDirectory = "output-files";
        $inputFileName = $_FILES["fileToUpload"]["tmp_name"];
        $outputFileName = "results_" . date("Y-m-d") . '_' . date("H-i-s") . ".csv";

        deleteOldFiles();

        if (!file_exists($inputDirectory)) {
            mkdir($inputDirectory);
        }

        if (!file_exists($outputDirectory)) {
            mkdir($outputDirectory);
        }

        $filePath = $inputDirectory . "/" . basename($_FILES["fileToUpload"]["name"]);
        if (move_uploaded_file($inputFileName, $filePath)) {
            $file = fopen($filePath, "r");
            $outputFilePath = $outputDirectory . "/" . $outputFileName;
            $outputFile = fopen($outputFilePath, "w");
            while (($line = fgetcsv($file)) !== FALSE) {
              foreach ($line as $cell) {

                if (preg_match("/How Did You Hear About Fifty Flowers\?\s+(.*?)\s+What/", $cell, $matches)) {
                  if (isset($matches[1])) {
                      $cleanedMatch = str_replace('"', '', $matches[1]);
                  }
                }

                if (preg_match('/"name":"([^"]+)"/', $cell, $matchesName)) {
                  $name = $matchesName[1];
                  fputcsv($outputFile, [$name, $cleanedMatch]);
                }

                  
              }
          }
            fclose($file);
            fclose($outputFile);

            $message = "Processing complete. File ready for download.";
            unlink($filePath);
            header("Location: index.php?message=".urlencode($message)."&file=".urlencode($outputFilePath));
            exit;
        } else {
            $message = "There was an error uploading your file.";
            header("Location: index.php?message=".urlencode($message));
            exit;
        }
    } else {
        $message = "No file was uploaded.";
        header("Location: index.php?message=".urlencode($message));
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
