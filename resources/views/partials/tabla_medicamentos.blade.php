@foreach($medicamentos as $data)
<tr>
    <td><input type="checkbox" class="rowCheckbox"></td>
    <td class="text-base">{{ $data->id }}</td>
    <td class="text-base">{{ $data->nombre }}</td>
    <td class="text-base">{{ $data->cantidad }}</td>
    <td class="text-base">{{ $data->precio_venta }}</td>
    <td class="text-base">{{ $data->precio_comprado }}</td>
    <td class="text-base">{{ \Carbon\Carbon::parse($data->vencimiento)->format('Y-m-d') }}</td>
    <td class="text-base">{{ $data->lote }}</td>
    <td class="grid grid-flow-col">
        <div class="row-span-1">
            <a href="">
                <button class="bg-green-600 h-10 w-24 rounded-lg">
                    <p class="text-white text-sm">Añadir venta</p>
                </button>
            </a>
        </div>
        <div class="row-span-1">
            <button class="delete-button" onclick="toggleDeleteModal('{{ $data->id }}', '{{ $data->nombre }}')">
                <!-- Aquí puedes poner el ícono de eliminar -->
            </button>
        </div>
    </td>
</tr>
@endforeach
