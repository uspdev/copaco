<div class="form-group">
    <label for="nome">Grupos de {{ $user->name }}:</label>
    <br>
    @foreach($roles->sortBy('nome') as $role)
        <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $user->hasRole($role->nome) ? 'checked' : ''}}> {{ $role->nome }}<br>
    @endforeach
</div>

<br>
<button type="submit" class="btn btn-primary">Enviar</button>

