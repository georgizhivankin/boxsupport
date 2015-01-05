@extends('layouts.default')
@section('content')
<div class="page-header">
<h1>{{Config::get('appInfo.name')}} | <small>Welcome</small></h1>
</div>
<br/>
@if (!Session::has('accountID'))
@include('pages.account.retrieveAccount')
@else
    <p>Welcome to the account ID {{Session::get('accountID')}}. Please choose an action from the menu above.</p>
    @endif
@stop