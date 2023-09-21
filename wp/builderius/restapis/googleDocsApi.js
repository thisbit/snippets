// use this with your google shhe document set to public to get the data as rest api json 

function getSheetDataAsJSON() {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  var range = sheet.getDataRange();
  var values = range.getValues();
  var headers = values[0];
  var jsonData = [];

  for (var i = 1; i < values.length; i++) {
    var row = values[i];
    var rowObj = {};

    for (var j = 0; j < headers.length; j++) {
      rowObj[headers[j]] = row[j];
    }

    jsonData.push(rowObj);
  }

  return JSON.stringify(jsonData);
}

function doGet() {
  return ContentService.createTextOutput(getSheetDataAsJSON())
    .setMimeType(ContentService.MimeType.JSON);
}