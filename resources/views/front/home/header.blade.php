<header class="page-header-ui page-header-ui-light bg-custom">
    <div class="page-header-ui-content pt-5">
        <div class="container">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6 text-light" data-aos="fade-up">
                    <h1 class="page-header-ui-title text-light mb-5 bold font-weight-bold fw-bolder">
                        {{ __('front/home.boostYourResult') }}
                    </h1>
                    <li class="dot-custom fs-6 mb-4 custom-indent">
                        {{ __('front/home.listItem1') }}
                    </li>
                    <li class="dot-custom fs-6 mb-4 custom-indent">
                        {{ __('front/home.listItem2') }}
                    </li>
                    <li class="dot-custom fs-6 mb-4 custom-indent">
                        {{ __('front/home.listItem3') }}
                    </li>
                    <div class="d-flex flex-column flex-sm-row mt-5">
                        <a class="btn btn-lg btn-primary fw-500 me-sm-3 mb-3 mb-sm-0"
                           href="{{ route('filament.admin.auth.login') }}">
                            {{ __('common.letsGo') }}
                            <i class="ms-2" data-feather="arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block ml-2" data-aos="fade-up" data-aos-delay="100">
                    <img class="img-fluid"
                         src="https://blush.design/api/download?shareUri=iwWSGHbGRFcaHlKD&c=Elements_0%7Eff830f-0.2%7E5ebac3-0.6%7E2945ff-0.10%7Eff830f_Rainbow_0%7Ef2a34c-0.2%7Ef283ca-0.6%7Ef283ca-0.10%7E77cffb&w=800&h=800&fm=png"
                         alt="..."/>
                </div>
            </div>
        </div>
    </div>
    <div class="svg-border-rounded text-light">
        <!-- Rounded SVG Border-->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none"
             fill="currentColor">
            <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
        </svg>
    </div>
</header>
