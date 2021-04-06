<div class="card">
    <div class="card-header">Arquivos</div>
    <div class="card-body form-group">
        @can('equipamentos.update', $equipamento)
            @include('equipamentos.files.partials.form')
        @endcan
        <br>
        <br>
        <table class="table table-striped" style="text-align: center;">
            <theader>
                <tr>
                    <th>Nome do Arquivo</th>
                    <th>Data de Envio</th>
                    <th>Ações</th>
                </tr>
            </theader>
            <tbody>
            @foreach ($equipamento->files as $file)
                <tr>
                    @if(preg_match('/jpeg|png/i', $file->mimetype))
                        <td>
                            <a class="d-inline-block ml-1 mr-1" data-fancybox="arquivo-galeria" href="files/{{ $file->id }}">
                                <img class="arquivo-img" width="100px" src="files/{{ $file->id }}"
                                alt="{{ $file->original_name }}" data-toggle="tooltip" data-placement="top"
                                title="{{ $file->original_name }}">
                            </a>
                        </td>
                    @else
                        <td><a href="/files/{{$file->id}}">{{ $file->original_name }}</a></td>
                    @endif
                    <td>
                        {{ Carbon\Carbon::parse($file->created_at)->format('d/m/Y') }}
                    </td>
                    @can('equipamentos.delete', $equipamento)
                        <td>
                            <form method="POST" class="form-group" action="/files/{{$file->id}}">
                                @csrf 
                                @method('delete')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Você tem certeza que deseja apagar?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

