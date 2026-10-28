@extends('template.base')

@section('before-content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
<a class="btn btn-secondary" href="{{ route('modulo.create') }}">Crear Alumno</a>
</div>
</div>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Abreviatura</th>
                        <th>Nota</th>
                        <th>Género</th>
                        <th>Fecha Nac.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($modulos as $modulo)
                        <tr>
                            <td>{{ $modulo->id }}</td>
                            <td>{{ $modulo->nombre }}</td>
                            <td>{{ $modulo->abreviatura }}</td>
                            <td>{{ $modulo->horas }}</td>
                            <td>{{ $modulo->creditos }}</td>
                           

                            <td> <a href="{{route('modulo.show', $modulo->id)}}"class="btn btn-secondary">View</a></td>
                             <td> <a href="{{route('modulo.edit', $modulo->id )}}"class="btn btn-secondary">Edit</a></td>
                              <!--<td> <a href="{{route('index')}}"class="btn btn-secondary">Delete</a></td>-->
                              <td><form class="confirm-dialog" data-message="{{$modulo->nombre}}" action="{{route('modulo.destroy', $modulo)}}"method="post">
                                @csrf
                                @method('delete')
                                <input type="submit" value="Delete" class="btn btn-secondary"></input>
                                </form>
</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.querySelectorAll('form.confirm-dialog').forEach(
        form => {
            form.addEventListener('submit', e => {
                const message = '¿Seguro que quieres borrar el modulo '+ form.dataset.message +'?' ;
                if(!confirm(message)){
                    e.preventDefault();
                }
            });
        }
    );
    </script>
@endsection