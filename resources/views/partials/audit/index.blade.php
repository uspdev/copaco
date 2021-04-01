<table class="table">
  <thead>
    <tr>
      <th scope="col">Data</th>
      <th scope="col">Usuário(a)</th>
      <th scope="col">Mudanças</th>
    </tr>
  </thead>
  <tbody>
  @foreach($model->audits as $audit)
    <tr>
      <td> {{ \Carbon\Carbon::parse($audit->getMetadata()['audit_created_at'])->format('d/m/Y H:i') }} </td>
      <td> {{ $audit->getMetadata()['user_name'] }}</td>
      <td> 
        @foreach($audit->getModified() as $field=>$modified)
        <b>{{$field}}:</b> {{ $modified['old'] ?? '' }} <b>-></b> {{ $modified['new'] }}<br>
        @endforeach
      </td>
    </tr>
  @endforeach
  </tdoby>
</table>