<h2>Retrieve an Account</h2>
<br>
<p>Please enter the account ID you would like to retrieve all box orders for, and click on the Retrieve button.</p>
<br/>
{{ Form::open(array('action' => 'AccountController@verifyAccount', 'method' => 'post')) }}

@if($errors->all())
<ul>
	{{ implode('', $errors->all('
	<li class="error">:message</li>'))}}
</ul>
@endif

<div>{{ Form::label('accountID', 'Account ID') }} {{ Form::text('accountID', '', array('Placeholder' => 'Account ID'))
	}}</div>

{{ Form::submit('Retrieve') }}
{{ Form::close() }}