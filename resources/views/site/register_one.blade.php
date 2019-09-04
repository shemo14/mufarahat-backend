<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ settings('site_name_' . lang()) }} | {{ trans('site.register') }}</title>
    <link rel="shortcut icon" href="{{ Request::root() }}/design/site/img/logo.png">

    <link href="{{ Request::root() }}/design/site/css/all.min.css" rel="stylesheet" />
    <link href="{{ Request::root() }}/design/site/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ Request::root() }}/design/site/css/owl.carousel.css" rel="stylesheet" />
    <link href="{{ Request::root() }}/design/site/css/hover.css" rel="stylesheet" />
    <link href="{{ Request::root() }}/design/site/css/jquery.fancybox.min.css" rel="stylesheet" />
    <link href="{{ Request::root() }}/design/site/css/animate.css" rel="stylesheet" />
    <link href="{{ Request::root() }}/design/site/css/style.css" rel="stylesheet" />

    @if(App::isLocale('en'))§
        <link rel="stylesheet" href="{{ Request::root() }}/design/site/css/styleLTR.css">
    @endif

</head>
<body >

<!-- Start Loading Page -->

<div class="layer-preloader">
    <img src="{{ Request::root() }}/design/site/img/splash.png" alt="logo">
    <div>{{ trans('site.intro') }}</div>
</div>


<!-- End Loading Page -->

<!--  Start login  -->
<div class='loginDiv'>
    <h2 class=" wow fadeInDown " data-wow-delay=".1s">{{ trans('site.register') }}</h2>
    <img src="{{ Request::root() }}/design/site/img/apple.png" alt="fa3lyat" class="appleImg wow rightApple fadeIn " data-wow-delay=".5s">
    <img src="{{ Request::root() }}/design/site/img/apple_left.png" alt="fa3lyat" class="appleImg leftApple wow fadeIn " data-wow-delay=".5s">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <form class="mainForm needs-validation" action="{{ route('next_register') }}" novalidate method="get">

                    <img src="{{ Request::root() }}/design/site/img/logo.png" alt="logo" class="logoImg">
                    <div class="form-group has-float-label wow fadeInUp " data-wow-delay=".6s">
                        <div class="inputFocus"></div>
                        <input type="text" name="name" class="form-control" id="username" placeholder="{{ trans('site.username') }}" autocomplete="off" required>
                        <label for="username">{{ trans('site.username') }}</label>
                        <i class="far fa-user formIcon"></i>
                        <div class="invalid-feedback">
                            {{ trans('site.username_validation') }}
                        </div>
                    </div>
                    <div class="form-group has-float-label wow fadeInUp " data-wow-delay=".8s">
                        <div class="inputFocus"></div>
                        <input type="tel" name="phone" class="form-control" id="phone" placeholder="{{ trans('site.phone') }}" autocomplete="off" required>
                        <label for="phone">{{ trans('site.phone') }}</label>
                        <i class="fas fa-mobile-alt formIcon"></i>
                        <div class="invalid-feedback">
                            {{ trans('site.phone_validation') }}
                        </div>
                    </div>
                    <div class="form-group has-float-label wow fadeInUp " data-wow-delay="1s">
                        <div class="inputFocus"></div>
                        <input type="email" name="email" class="form-control" id="email" placeholder="{{ trans('site.email') }}" autocomplete="off" required>
                        <label for="email">{{ trans('site.email') }}</label>
                        <i class="far fa-envelope formIcon"></i>
                        <div class="invalid-feedback">
                            {{ trans('site.email_validation') }}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary formBtn wow fadeInUp " data-wow-delay="1.2s">{{ trans('site.next') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--  end login  -->

<script>
	// Example starter JavaScript for disabling form submissions if there are invalid fields
	(function() {
		'use strict';
		window.addEventListener('load', function() {
			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.getElementsByClassName('needs-validation');
			// Loop over them and prevent submission
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) {
						event.preventDefault();
						event.stopPropagation();
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	})();
</script>
<script src="{{ Request::root() }}/design/site/js/jquery-3.3.1.min.js"></script>
<script src="{{ Request::root() }}/design/site/js/bootstrap.min.js"></script>
<script src="{{ Request::root() }}/design/site/js/jquery.nicescroll.min.js"></script>
<script src="{{ Request::root() }}/design/site/js/owl.carousel.min.js"></script>
<script src="{{ Request::root() }}/design/site/js/jquery.fancybox.min.js"></script>
<script src="{{ Request::root() }}/design/site/js/masonry-docs.min.js"></script>
<script src="{{ Request::root() }}/design/site/js/wow.min.js"></script>
<script src="{{ Request::root() }}/design/site/js/scripts.js"></script>
<script>
	new WOW().init();
</script>
</body>
</html>
