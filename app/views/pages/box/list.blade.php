@section('content')
@if (isset($accountID))
<h2>Box Orders for Account ID {{$accountID}}</h2>
@else
    <h2>All Box Orders</h2>
    @endif
<div class="table-responsive">
<table class="table-responsive">
<thead>
<tr>
<th>ID</th>
<th>Delivery Date</th>
</tr>
</thead>
<tbody>
@if (!$accountBoxes->isEmpty())
    @foreach ($accountBoxes as $box)
	<tr>
	<td>{{HTML::linkAction('BoxController@show', 'View products in box '.$box->id, array('id' => $box->id, 'accountID' => $accountID))}}</td>
	<td>{{$box->delivery_date}}</td>
	</tr>
	@endforeach
	@else
	<tr>
	<td colspan="3" class="alert alert-info">No boxes were found for this account.
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	</td>
		</tr>
	@endif
	</tbody>
</table>
</div>
<br/>
{{$accountBoxes->links();}}
@stop