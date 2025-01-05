window.addEventListener("DOMContentLoaded", (event) => {
  // Simple-DataTables
  // https://github.com/fiduswriter/Simple-DataTables/wiki

  const datatablesSimple3 = document.getElementById("datatablesSimple3");
  if (datatablesSimple3) {
    new simpleDatatables.DataTable(datatablesSimple3);
  }
});
