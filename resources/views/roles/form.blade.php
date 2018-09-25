<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" value="{{ $role->nome or old('nome')  }}" placeholder="Ex: Departamento de Música" required >
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Enviar Dados">
</div>
