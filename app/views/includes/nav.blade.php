<nav role="navigation" class="navbar navbar-default">

	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" data-target="#navbarCollapse"
			data-toggle="collapse" class="navbar-toggle">
			<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
			<span class="icon-bar"></span> <span class="icon-bar"></span>
		</button>

		<a href="#" class="navbar-brand">{{Config::get('appInfo.name')}}</a>
	</div>

	<!-- Collection of nav links, forms, and other content for toggling -->
	<div id="navbarCollapse" class="collapse navbar-collapse">

		<ul class="nav navbar-nav">
			{{HTML::cleverLink('IndexController@index', 'Home')}}
			@if (boxsupport\Helpers\AuthenticationHelper::checkAuth('accountID'))
			{{HTML::cleverLink('BoxController@showBoxes', 'Show Box Orders', array('accountID' => Session::get('accountID')))}}
						{{HTML::cleverLink('AccountController@logout', 'Log out')}}
			@endif

		</ul>
		
	</div>

</nav>