document.addEventListener('DOMContentLoaded', function () {
  // Your JavaScript code here
  function getCurrentDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');

    const formattedDate = `${year}-${month}-${day}`;
    return formattedDate;
  }

  const currentDate = getCurrentDate();
  const inputFilePath = './input-files/consult-booking-data.csv';
  const outputFilePath = `./output-files/consult-booking-data-output_${currentDate}.csv`;
  const regexPattern = /How Did You Hear About Fifty Flowers\?\s+(.*)$/;

  function uploadFile() {
    const fileInput = document.getElementById('fileInput');
    const uploadStatus = document.getElementById('uploadStatus');
    const formData = new FormData();

    if (fileInput.files.length > 0) {
      formData.append('file', fileInput.files[0]);

      // Call the searchAndWriteCSV function with arguments
      searchAndWriteCSV(inputFilePath, outputFilePath, regexPattern);

      uploadStatus.innerHTML = 'File uploaded successfully!';
    } else {
      uploadStatus.innerHTML = 'Please select a file to upload.';
    }
  }

  // Add an event listener to the file input to trigger the upload process
  const fileInput = document.getElementById('fileInput');
  fileInput.addEventListener('change', function () {
    uploadFile();
  });
});
