@section('content')
<div class="table-responsive">
<table class="table-responsive">
<thead>
<tr colspan="2">
<th>ID</th>
</tr>
</thead>
<tbody>
@if (!$accounts->isEmpty())
	@foreach ($accounts as $account)
	<tr>
	<td>{{$account->id}}</td>
	<td>{{link_to_action('BoxController@showBoxes', 'View customer\'s boxes ('.count($account->boxes).')', array('id' => $account->id), array('class' => 'btn btn-primary'))}}</td>
		</tr>
	@endforeach
	@else
		<tr>
		<td colspan="2" class="alert alert-info">No accounts were found in the system.
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		</td>
		</tr>
	@endif
	</tbody>
</table>
</div>
<br/>
{{$accounts->links()}}
@stop