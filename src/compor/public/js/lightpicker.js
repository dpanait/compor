const picker = new Litepicker({
  element: document.getElementById('period'),
  singleMode: false,
  startDate: first_day_mon,
  endDate: last_day_mon,
  format: "YYYY-MM-DD",
  numberOfColumns: screenWidth <= 600 ? 1 : 2,
  numberOfMonths: screenWidth <= 600 ? 1 : 2,
  lang: "es-ES"
});