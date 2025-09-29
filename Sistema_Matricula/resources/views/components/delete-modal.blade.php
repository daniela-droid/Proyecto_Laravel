
     @props(['id', 'route', 'message'])

<x-adminlte-modal id="{{ $id }}" title="Confirmar eliminación"
    theme="danger" icon="fas fa-exclamation-triangle" v-centered static-backdrop>

    <p>{!! $message !!}</p>

    <x-slot name="footerSlot">
        <form action="{{ $route }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <x-adminlte-button type="submit" theme="danger" label="Sí, eliminar" icon="fas fa-trash"/>
        </form>
        <x-adminlte-button theme="secondary" label="Cancelar" data-dismiss="modal" />
    </x-slot>
</x-adminlte-modal>

