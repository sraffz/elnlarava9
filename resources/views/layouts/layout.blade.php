<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ePenghulu - @yield('title')</title>
	<link rel="stylesheet" type="text/css" href="{{ asset("css/bootstrap.min.css")}}">
	@yield('header')
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				@yield('content')
			</div>
		</div>
	</div>
</body>
@yield('script')
</html>