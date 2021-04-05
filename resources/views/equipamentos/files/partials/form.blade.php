<form action="/files" enctype="multipart/form-data" method="POST">
    @csrf
    <input type="hidden" name="equipamento_id" value="{{$equipamento->id}}">
    <div class="row">
        <div class="form-group col-sm">
            <input type="file" class="form-control-file" id="arquivo-do-trabalho" name="file">
            <span class="badge badge-warning"><b>Atenção:</b> Os arquivos a serem enviados devem ter no máximo 12mb, nos formatos: pdf, jpg ou png.</span><br>
        </div>
    </div>     
    <div class="row">
        <div class="form-group col-sm">
            <button type="submit" class="btn btn-success float-right">Enviar</button> 
        </div> 
    </div>
</form>
