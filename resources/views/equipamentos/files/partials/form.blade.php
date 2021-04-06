<form action="/files" enctype="multipart/form-data" method="POST">
    @csrf
    <input type="hidden" name="equipamento_id" value="{{$equipamento->id}}">
    <div class="row">
        <div class="form-group col-sm">
            <input type="file" class="form-control-file" id="arquivo-do-trabalho" name="file">
        </div>
    </div>     
    <div class="row">
        <div class="form-group col-sm">
            <button type="submit" class="btn btn-success float-right">Enviar</button> 
        </div> 
    </div>
</form>
