@section('content')
<h2>Products in Box {{$boxID}}</h2>
{{ Form::open(array('action' => array('BoxController@update', 'accountID' => $accountID, 'boxID' => $boxID), 'id' => 'updateRating')) }}
  <div class="form-group">
<div class="table-responsive">
<table class="table-responsive">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th></th>
<th>Category</th>
<th>Rating</th>
</tr>
</thead>
<tbody>
	@foreach ($boxProducts as $product)
	<tr>
	<td>{{$product->id}}</td>
	<td>{{$product->name}}</td>
	<td><img src="{{$product->image_url}}" class="img-thumbnail"></td>
	<td>{{$product->category}}</td>
	<td>{{ Form::label('selectRating['.$product->id.']', '&nbsp;') }}
	{{ Form::select('selectRating['.$product->id.']', $ratingValues, ((!empty($product->rating))||(!$product->rating=='0'))?($product->rating):("1"), array('class' => 'selectRating')) }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>
</div>
{{ Form::close() }}
@stop