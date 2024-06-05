@extends('layouts.app')

@section('content')
<div class="mx-5">
    <table class="table table-xs table-pin-rows table-pin-cols">
        <thead class="text-lg">
            <tr>
                <td>Id:</td> 
                <td>Nombre:</td>
                <td>cantidad:</td>
                <td>Precio unidad (S/.):</td>
                <td>Precio comprado (S/.):</td>
                <td>Vencimiento:</td>
                <td>Lote:</td> 
            </tr>
        </thead> 
        <tbody>
            @foreach($medicamentos as $key => $data)
            <tr>    
                <td class="text-base">{{$data->id}}</td>
                <td class="text-base">{{$data->nombre}}</td>
                <td class="text-base">{{$data->cantidad}}</td>
                <td class="text-base">{{$data->precio_venta}}</td>
                <td class="text-base">{{$data->precio_comprado}}</td>
                <td class="text-base">{{ \Carbon\Carbon::parse($data->vencimiento)->format('Y-m-d') }}</td>
                <td class="grid grid-flow-col">
                  <div class="row-span-1">
                  <a href="">
                      <button class="bg-green-600 h-10 w-24 rounded-lg"> 
                        <p class="text-white text-sm">Añadir venta</p>
                      </button>  
                    </a>
                  </div>    
                  <div class="row-span-1">
                    <button class="delete-button" onclick="toggleDeleteModal('{{$data->id}}', '{{$data->nombre}}')"> 
                     
                    </button>
                    </div>
                </td>                 
            </tr>
            @endforeach
        </tbody> 
    </table>
    {{$medicamentos->links('pagination::tailwind')}}
</div>

<!--Modal para ingresar datos-->
<dialog id="deleteModal" class="modal">
  <div class="modal-box">
  <h3 class="font-bold text-lg">Formulario de ingreso de archivo</h3>
    <p class="py-4">¿Está seguro de borrar el elemento?</p>
    <p id="fieldName"></p>  
    <form method="POST" action="{{route('delete')}}" enctype="multipart/form-data">
      @csrf <!-- {{ csrf_field() }} -->
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" type="button" onclick="deleteModal.close()">✕</button>
      <input type="hidden" id="idToDelete" name="id"/>
      <input type="hidden" id="name" name="name"/>
      <input type="hidden" id="type" name="type"/>
      <div>
        <button 
          class="btn text-white bg-gradient-to-r from-red-400 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
        >
          Borrar
        </button>
        <button class="btn" type="button" onclick="deleteModal.close()">Cerrar</button>
      </div>
    </form>    
  </div>
</dialog>

<script type="text/javascript">
    function toggleDeleteModal(id, name) {
        document.getElementById('deleteModal').showModal();
        $("#fieldName").html(name); 
        document.getElementById("idToDelete").value = id;
    }
</script>

@endsection
