$(document).ready( function () {
    $('#myTable').DataTable({
      "stateSave": true, // se habilita guardar el estado
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
            "infoFiltered": "(filtrado de _MAX_ entradas en total)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros coincidentes",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});

// Mosrar modal de confirmación al eliminar una película
function confirmDelete(nombre, id)
{
  Swal.fire({
    title: 'Está seguro?',
    text: 'Está acción no se podrá revertir!',
    icon: 'warning',
    color:'#ffffff',
    background:'#333333',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, eliminar'
    }).then((result) => {
      if (result.isConfirmed) {
        let form  = document.getElementById(`${nombre}${id}`);
        form.submit();
      }
  });
}

