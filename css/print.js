function printElement(elem, title) {
  var popup = window.open(
    "",
    "_blank",
    `width=${window.innerWidth}, height=${window.innerHeight}`
  );

  popup.document.write(
    '<html><head><link rel="stylesheet" href="/schoolapp/css/custom.min.css"><title>' +
      title +
      '</title>'
  );
  popup.document.write('<style></style>');
  popup.document.write('</head><body>');
  popup.document.write(document.getElementById(elem).innerHTML);
  popup.document.write('</body></html>');

  popup.document.close();
  popup.focus();

  popup.print();
  popup.close();

  return true;
}
