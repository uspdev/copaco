<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" value="{{ $role->nome or old('nome')  }}" placeholder="Ex: Departamento de Música" required >
</div>

<div class="form-group">

    @if(old('grupoadmin')=='' and isset($role->grupoadmin))
        <input type="checkbox" name="grupoadmin" {{ $role->grupoadmin ? 'checked' : ''}}>
    @else
        <input type="checkbox" name="grupoadmin" {{ (old('grupoadmin') == 'on') ? 'checked' : ''}}>
    @endif

    <b>Grupo administrativo?</b>
    Marque essa opção caso você queira que as pessoas desse grupo 
vizualizem e administrem os equipamentos do mesmo.

        
</div>

<div class="form-group">
    <label for="rede">Redes do grupo <i>{{ $role->nome or old('nome') }}:</i></label>
    <br>
    @foreach($redes->sortBy('nome') as $rede)

        @if(old('redes[]')=='' and isset($role->nome))
        <input type="checkbox" name="redes[]" value="{{ $rede->id }}" {{ $rede->hasRole($role->nome) ? 'checked' : ''}}> {{ $rede->nome }}<br>
        @else
        <input type="checkbox" name="redes[]" value="{{ $rede->id }}" {{ (old('redes[]') == $rede->id)? 'checked' : ''}}> {{ $rede->nome }}<br>
        @endif
    @endforeach
</div>



<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Enviar Dados">
</div>
