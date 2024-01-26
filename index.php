<!DOCTYPE html>
<html>
<head>
    <title>CSV File Upload</title>
    <style>
        body {
            font-family: arial, sans-serif;
        }

        h1 {
            margin-bottom: 50px;
            color: blue;
        }

        .wrapper {
            width: 675px;
            margin: 0 auto;
        }

        .subheader {
            font-weight: bold;
            font-size: "110%";
            margin-bottom: -10px;
            padding: 20px 0 0 0;
            color: darkblue;
        }

        .note {
            font-size: "80%";
            color: #666;
        }

        .message {
            margin-top: 20px;
            color: darkred;
        }

        a:link, a:visited {
            color: blue;
        }

        hr {
            margin: 20px 0;
        }

        ul, li {
            margin: 10px;
            padding: 0;
            list-style: none;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Parse Consult Booking Data</h1>
    <form action="process.php" method="post" enctype="multipart/form-data">
        <p><label for="fileToUpload">1) Select exported consult data CSV file to upload:</label>
        <input type="file" name="fileToUpload" id="fileToUpload"></p>
        <p class="upload">2) <input type="submit" value="Upload File" name="submit"></p>
    </form>

    <?php if (isset($_GET['message'])): ?>
        <p class="message"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['file'])): ?>
        3)  <a href="<?php echo htmlspecialchars($_GET['file']); ?>" download>Click To Download New Processed File</a>
    <?php endif; ?>

            <div>
                <?php
                    function listDownloadableFiles() {
                        $directory = 'output-files/';
                        $files = scandir($directory);
                        
                        if(count($files) > 2) {
                           echo '<hr />
                           <p class="subheader">Stored Processed Files</p>
                           <p class="note"><i>Files will be stored for one year.</i></p>'; 
                        }

                        // Start the unordered list
                        echo '<ul>';

                        foreach ($files as $file) {
                            // Skip directories and hidden files
                            if (is_dir($directory . $file) || $file[0] === '.') {
                                continue;
                            }

                            // Create a list item with a link for each file
                            echo '<li><a href="' . htmlspecialchars($directory . $file) . '" download>' . htmlspecialchars($file) . '</a></li>';
                        }

                        // End the unordered list
                        echo '</ul>';
                    }

                    // Call the function to display the list
                    listDownloadableFiles();

                ?>
            </div>
        </div>
</body>
</html>
