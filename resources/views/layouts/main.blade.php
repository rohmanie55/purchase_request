<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ asset('js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{ asset('css/fonts.min.css') }}"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/atlantis.min.css') }}">
	<link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.10.16/r-2.2.1/datatables.min.css">
</head>
<body>
	<div class="wrapper">
		<div class="main-header">
			<div class="logo-header" data-background-color="blue">
				
				<a href="/" class="logo">
					<img src="{{ asset('img/brand/hs.png') }}" alt="navbar brand" class="navbar-brand" style="max-height: 40px;background:white">
					<span style="color: white"><b class="small">Hotel Santika</b></span>
				</a>
                @if (auth()->check())
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
                @endif
			</div>
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
				<div class="container-fluid">
					<div class="collapse" id="search-nav">
                        <h3 class="text-white">@yield('title')</h3>
						{{-- <form class="navbar-left navbar-form nav-search mr-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pr-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Search ..." class="form-control">
							</div>
						</form> --}}
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>
                        @if (auth()->check())
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="{{ asset('img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="{{ asset('img/profile.jpg') }}" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4>{{ auth()->user()->name }}</h4>
												<p class="text-muted">{{ auth()->user()->aksess }}</p>
											</div>
										</div>
									</li>
									<li>
										<form method="POST" action="{{ route('logout') }}" style="display: inline">
											@csrf
											<button class="dropdown-item" >Logout</button>
										</form>
									</li>
								</div>
							</ul>
						</li>
                        @endif
					</ul>
				</div>
			</nav>
        </div>
        @if (auth()->check())
        <div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{ asset('img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									{{ auth()->user()->name }}
									<span class="user-level">{{ auth()->user()->aksess }}</span>
								</span>
							</a>
							<div class="clearfix"></div>
						</div>
					</div>
					<ul class="nav nav-primary">
						<li class="nav-item {{ in_array(Route::currentRouteName(), ['home']) ? 'active' : '' }}">
							<a href="{{ route('home') }}">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
						@if (in_array(auth()->user()->aksess, ['purchasing', 'manager']))
						<li class="nav-item {{ in_array(Route::currentRouteName(), ['user.index', 'user.create', 'user.edit']) ? 'active' : '' }}">
							<a href="{{ route('user.index') }}">
								<i class="fas fa-user-friends"></i>
								<p>Master User</p>
							</a>
						</li>
						@endif
						@if (in_array(auth()->user()->aksess, ['purchasing']))
                        <li class="nav-item {{ in_array(Route::currentRouteName(), ['barang.index',  'barang.create', 'barang.edit']) ? 'active' : '' }}">
							<a href="{{ route('barang.index') }}">
								<i class="fas fa-box"></i>
								<p>Master Barang</p>
							</a>
						</li>
						@endif
						@if (in_array(auth()->user()->aksess, ['purchasing']))
                        <li class="nav-item {{ in_array(Route::currentRouteName(), ['supplier.index',  'supplier.create', 'supplier.edit']) ? 'active' : '' }}">
							<a href="{{ route('supplier.index') }}">
								<i class="fas fa-truck-loading"></i>
								<p>Master Supplier</p>
							</a>
						</li>
						@endif
						@if (in_array(auth()->user()->aksess, ['departement']))
                        <li class="nav-item {{ in_array(Route::currentRouteName(), ['request.index', 'request.create', 'request.edit']) ? 'active' : '' }}">
							<a href="{{ route('request.index') }}">
								<i class="fas fa-shopping-basket"></i>
								<p>Purchase Request</p>
							</a>
						</li>
						@endif
						@if (in_array(auth()->user()->aksess, ['purchasing', 'manager']))
                        <li class="nav-item {{ in_array(Route::currentRouteName(), ['order.index', 'order.create', 'order.edit']) ? 'active' : '' }}">
							<a href="{{ route('order.index') }}">
								<i class="fas fa-shopping-cart"></i>
								<p>Purchase Order</p>
							</a>
						</li>
						@endif
						@if (in_array(auth()->user()->aksess, ['ap']))
                        <li class="nav-item {{ in_array(Route::currentRouteName(), ['pembelian.index', 'pembelian.create', 'pembelian.edit']) ? 'active' : '' }}">
							<a href="{{ route('pembelian.index') }}">
								<i class="fas fa-money-check"></i>
								<p>Pembelian</p>
							</a>
						</li>
						@endif
                        <li class="nav-item {{ in_array(Route::currentRouteName(), ['report']) ? 'active' : '' }}">
							<a href="{{ route('report') }}">
								<i class="fas fa-receipt"></i>
								<p>Laporan</p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
        @endif
        <div class="main-panel">
			<div class="content">
                @yield('content')
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright ml-auto">
                        2018, made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://www.themekita.com">ThemeKita</a>
                    </div>				
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ asset('js/core/popper.min.js') }}"></script>
	<script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.10.16/r-2.2.1/datatables.min.js"></script>
    {{-- <script src="{{ asset('js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script> --}}
    <script src="{{ asset('js/atlantis.min.js') }}"></script>
    {{-- <script src="{{ asset('js/plugin/sweetalert/sweetalert.min.js') }}"></script> --}}
    <script src="{{ asset('js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script>
		    function convertToRupiah(angka){
				var rupiah = '';		
				var angkarev = angka.toString().split('').reverse().join('');
				for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
				return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
			}
    </script>
    @yield('script')
	{{-- 
	<script src="{{ asset('js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
	<script src="../assets/js/plugin/chart.js/chart.min.js"></script>
	<script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
	<script src="../assets/js/plugin/chart-circle/circles.min.js"></script>
	<script src="../assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
	<script src="../assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script> --}}


</body>
</html>