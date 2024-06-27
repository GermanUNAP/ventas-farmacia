@extends('layouts.app')

@section('content')
<div class="mx-5">
    <input type="text" id="searchInput" class="mb-3" placeholder="Buscar...">
    <table id="medicamentosTable" class="table table-xs table-pin-rows table-pin-cols">
        <thead class="text-lg">
            <tr>
                <th></th>
                <th>Id:</th>
                <th>Nombre:</th>
                <th>Cantidad:</th>
                <th>Precio unidad (S/.):</th>
                <th>Precio comprado (S/.):</th>
                <th>Vencimiento:</th>
                <th>Lote:</th>
                <th>Acciones:</th>
            </tr>
        </thead>
        <tbody id="medicamentosBody">
            <!-- Aquí se cargará la tabla de medicamentos -->
            @include('partials.tabla_medicamentos')
        </tbody>
    </table>
    {{$medicamentos->links('pagination::tailwind')}}
    <button class="btn btn-danger mt-3" onclick="eliminarSeleccionados()">Eliminar Seleccionados</button>
</div>

<!-- Modal para ingresar datos -->
<dialog id="deleteModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Formulario de ingreso de archivo</h3>
        <p class="py-4">¿Está seguro de borrar el elemento?</p>
        <p id="fieldName"></p>
        <form method="POST" action="{{route('delete')}}" enctype="multipart/form-data">
            @csrf <!-- {{ csrf_field() }} -->
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" type="button" onclick="deleteModal.close()">✕</button>
            <input type="hidden" id="idToDelete" name="id" />
            <input type="hidden" id="name" name="name" />
            <input type="hidden" id="type" name="type" />
            <div>
                <button class="btn text-white bg-gradient-to-r from-red-400 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Borrar
                </button>
                <button class="btn" type="button" onclick="deleteModal.close()">Cerrar</button>
            </div>
        </form>
    </div>
</dialog>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#searchInput').on('keyup', function() {
            fetchMedicamentos($(this).val());
        });
    });

   
    function eliminarSeleccionados() {
        var ids = [];
        $('.rowCheckbox:checked').each(function() {
            ids.push($(this).closest('tr').find('.text-base:eq(0)').text());
        });
        
        if (ids.length === 0) {
            alert("Seleccione al menos un medicamento para eliminar.");
            return;
        }

        // Envía una solicitud al servidor para eliminar los medicamentos seleccionados
        $.ajax({
            url: "{{ route('eliminar.medicamentos') }}",
            type: 'POST',
            data: {ids: ids},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Vuelve a cargar los medicamentos después de eliminar los seleccionados
                fetchMedicamentos($('#searchInput').val());
                alert("Los medicamentos seleccionados han sido eliminados con éxito.");
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert("Error al eliminar los medicamentos seleccionados.");
            }
        });
    }
</script>

@endsection
