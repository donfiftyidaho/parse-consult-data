<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    if ($_FILES["fileToUpload"]["error"] == 0) {
        $inputDirectory = "input-files";
        $outputDirectory = "output-files";
        $inputFileName = $_FILES["fileToUpload"]["tmp_name"];
        $outputFileName = "results_" . date("Y-m-d") . ".csv";

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
