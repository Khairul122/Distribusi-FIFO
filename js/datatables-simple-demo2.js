window.addEventListener('DOMContentLoaded', event => {
  // Simple-DataTables
  // https://github.com/fiduswriter/Simple-DataTables/wiki

  const datatablesSimple2 = document.getElementById('datatablesSimple2');
  if (datatablesSimple2) {
      new simpleDatatables.DataTable(datatablesSimple2);
  }
});