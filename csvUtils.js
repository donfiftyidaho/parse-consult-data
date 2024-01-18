const fs = require('fs');
const csv = require('csv-parser');
const createCsvWriter = require('csv-writer').createObjectCsvWriter;

function searchAndWriteCSV(inputFilePath, outputFilePath, regexPattern) {
  const results = [];

  fs.createReadStream(inputFilePath)
    .pipe(csv())
    .on('data', (row) => {
      // Modify this part to match your specific search criteria
      for (const key in row) {
        if (row.hasOwnProperty(key) && String(row[key]).match(regexPattern)) {
          results.push(row);
          break; // Stop searching this row after the first match
        }
      }
    })
    .on('end', () => {
      // Write the matching results to a new CSV file
      const csvWriter = createCsvWriter({
        path: outputFilePath,
        header: Object.keys(results[0]),
      });

      csvWriter
        .writeRecords(results)
        .then(() => {
          console.log(`Matching rows written to ${outputFilePath}`);
        })
        .catch((error) => {
          console.error('Error writing CSV file:', error);
        });
    });
}
