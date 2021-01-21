<!DOCTYPE html>
<html lang="en">
<head>
<title>{{ $title }}</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="OneTech shop project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/site/styles/bootstrap4/bootstrap.min.css') }}">
<link href="{{ asset('assets/site/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/site/plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/site/plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/site/plugins/OwlCarousel2-2.2.1/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/site/plugins/slick-1.8.0/slick.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/site/styles/main_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/site/styles/responsive.css') }}">

<!-- Toaster -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@yield('style')


</head>

<body>

<div class="super_container">

	<!-- Header -->

	<header class="header">

		<!-- Top Bar -->
		@include('site.layouts.top_bar')

		<!-- Header Main -->
        @include('site.layouts.header_main')

		<!-- Main Navigation -->
        @include('site.layouts.main_nav')

		<!-- Menu -->
        @include('site.layouts.page_menu')

	</header>

	<!-- Banner -->
    @include('site.layouts.banner')


	<!-- Characteristics -->
    @include('site.layouts.characteristics')

	<!-- Deals of the week -->

	<div class="deals_featured">
		<div class="container">
			<div class="row">
				<div class="col d-flex flex-lg-row flex-column align-items-center justify-content-start">

					<!-- Deals -->
                    @include('site.layouts.deals')

                    <!-- Featured -->
                     @include('site.layouts.featured')

				</div>
			</div>
		</div>
	</div>

	<!-- Popular Categories -->
    @include('site.layouts.popular_categories')


	<!-- Banner -->
    @include('site.layouts.banner_2')

	<!-- Hot New Arrivals -->
    @include('site.layouts.new_arrivals')

	<!-- Best Sellers -->
    @include('site.layouts.best_sellers')

	<!-- Adverts -->
    @include('site.layouts.adverts')

	<!-- Trends -->
    @include('site.layouts.trends')


	<!-- Reviews -->
    @include('site.layouts.reviews')

	<!-- Recently Viewed -->
    @include('site.layouts.viewed')

	<!-- Brands -->
    @include('site.layouts.brands')

    <!-- Newsletter -->
    @include('site.layouts.newsletter')

	<!-- Footer -->
    @include('site.layouts.footer')

	<!-- Copyright -->
    @include('site.layouts.copyright')

</div>

<script src="{{ asset('assets/site/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/site/styles/bootstrap4/popper.js') }}"></script>
<script src="{{ asset('assets/site/styles/bootstrap4/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/site/plugins/greensock/TweenMax.min.js') }}"></script>
<script src="{{ asset('assets/site/plugins/greensock/TimelineMax.min.js') }}"></script>
<script src="{{ asset('assets/site/plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
<script src="{{ asset('assets/site/plugins/greensock/animation.gsap.min.js') }}"></script>
<script src="{{ asset('assets/site/plugins/greensock/ScrollToPlugin.min.js') }}"></script>
<script src="{{ asset('assets/site/plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
<script src="{{ asset('assets/site/plugins/slick-1.8.0/slick.js') }}"></script>
<script src="{{ asset('assets/site/plugins/easing/easing.js') }}"></script>
<script src="{{ asset('assets/site/js/custom.js') }}"></script>

<!-- toaster js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



<script>
    $(document).ready(function(){
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}")
                break;

                case 'success':
                    toastr.success("{{ Session::get('message') }}")
                break;

                case 'warning':
                    toastr.warning("{{ Session::get('message') }}")
                break;

                case 'error':
                    toastr.error("{{ Session::get('message') }}")
                break;

                default:
                    toastr.info("ALERT");
                break;
            }
        @endif
    })
</script>

@yield('script')

</body>

</html>
