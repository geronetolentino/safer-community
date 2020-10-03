<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} - Privacy Policy</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{ asset('css/pages/privacy/privacy.css') }}" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
</head>
<body>
    
    <div id="headerWrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-12 text-center mb-5">
                    {{-- <a href="" class="navbar-brand-privacy">
                        <img src="assets/img/logo.svg" class="img-fluid" alt="logo">
                    </a> --}}
                </div>
                <div class="col-md-12 col-sm-12 col-12 text-center">
                    <h2 class="main-heading"><a href="{{ route('login') }}" class="text-light">{{ env('APP_NAME') }}</a></h2>
                </div>
            </div>
        </div>
    </div>

    <div id="privacyWrapper" class="">
        <div class="privacy-container">
            <div class="privacyContent">

                <div class="d-flex justify-content-between privacy-head">
                    <div class="privacyHeader">
                        <h1>Privacy Policy</h1>
                        <p>Updated Sep 15, 2020</p>
                    </div>

                    {{-- <div class="get-privacy-terms align-self-center">
                        <button class="btn btn-primary">
                        	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer">
                        		<polyline points="6 9 6 2 18 2 18 9"></polyline>
                        		<path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        		<rect x="6" y="14" width="12" height="8"></rect>
                        	</svg> Print
                        </button>
                    </div> --}}

                </div>

                <div class="privacy-content-container">

                    <section>
                        {{-- <h5>Please read our policy carefully</h5> --}}
                        <p>The Tzar-Melissa Digital Consultants (“TMDC”) cares about the privacy of the information being shared by the users which we dedicate to protect our end-user’s privacy. This is under the data privacy laws and regulation also known as the Data Privacy Act of 2012 (“DPA”) and its implementing rules and regulations “DPA IRR”.</p>
                    </section>

                    <section>
                        <h5> WHAT INFORMATION WE PROCESS </h5>
                        <p>TMDC IT Solution doesn’t have access to any PERSONAL DATA of the end-users, we only facilitate the registration process, and generation for Person of Interest (POI) number as your identity on the system with standard encryption in place.</p>

                        <p>We process the following information from the end-user listed below:</p>
                        <ul>
                            <li>Full Address (Province, Municipal, Baragay/ etc.)</li>
                            <li>Full Name</li>
                            <li>Phone Number (For Verification Purpose)</li>
                            <li>Email Address (For Verification Purpose)</li>
                            <li>Username</li>
                            <li>Password</li>
                        </ul>

                        <p>TMDC IT Solution voluntarily develops the (“I AM SAFE”) web application to address the growing challenges for COVID 19 contact tracing. We provide this solution free of charge to Province of Pangasinan to support and provide an effective COVID 19 contact tracing solution.</p>
                    </section>
                        
                    <section>
                        <h5> SECURITY OF YOUR INFORMATION</h5>
                        <p> We implemented security controls based on the regulatory and international application security standards, we also ensure that servers are properly configured with supporting security perimeters like firewall, encryption and access control.</p>
                        <p> These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p>
                    </section> 
                        
                    <section>
                        <h5>COOKIES</h5>
                        <p>Cookies are small files that we use to make your use of safeentry.pangasinan.com better. We temporarily store cookies in your device which is required for website operation. The purpose of the cookie is to use our references, and understand how the user interacts with safeentry.pangasinan.com.</p>
                    </section> 
                        
                    <section>
                        <h5> PERSONAL DATA CHANGE OR DELETE</h5>
                        <p> As the Data Owner you have the right to ask for a copy or request for deletion of your information, this is to align with the Data Privacy Act which gives rights to your information. If you have any concern or request with regards to your information and practice your rights, please contact our Data Protection Officer at dpo@tmdcitsolutions.com</p>
                    </section> 

                </div>

            </div>
        </div>
    </div>

    <div id="miniFooterWrapper" class="">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="position-relative">
                        <div class="arrow text-center">
                            <p class="">Up</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 mx-auto col-lg-6 col-md-6 site-content-inner text-md-left text-center copyright align-self-center">
                            <p class="mt-md-0 mt-4 mb-0"> 
                            	&copy; 2020 All Rights Reserved. 
	                            SafeEntry is a product of 
	                            <a href="https://www.tmdcitsolutions.com/" target="blank">TMDC IT Solutions.</a><br>
	                            Web hosting provided by <a href="https://bnshosting.net/" target="blank">Bitstop Network Services.</a>
	                        </p>
                        </div>
                        <div class="col-xl-5 mx-auto col-lg-6 col-md-6 site-content-inner text-md-right text-center align-self-center">
                            <p class="mb-0"> </p>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <script>
        // Scroll To Top
        $(document).on('click', '.arrow', function(event) {
          event.preventDefault();
          var body = $("html, body");
          body.stop().animate({scrollTop:0}, 500, 'swing');
        });
    </script>

</body>
</html>