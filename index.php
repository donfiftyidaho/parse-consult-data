<!DOCTYPE html>
<html>
<head>
    <title>CSV File Upload</title>
</head>
<body>
    <form action="process.php" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Select CSV file to upload:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>

    <?php if (isset($_GET['message'])): ?>
        <p><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['file'])): ?>
        <a href="<?php echo htmlspecialchars($_GET['file']); ?>" download>Download Processed File</a>
    <?php endif; ?>
</body>
</html>
