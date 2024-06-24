<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>@yield('title') | {{APP_NAME}} </title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="/assets/css/select2.min.css" />
    <link rel="stylesheet" href="/assets/css/sweetalert.css" />
    <link rel="stylesheet" href="/assets/css/nice-select2.css" />
    <link href="/assets/vendor/DataTables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/main/src/css/toastify.min.css">
    <!-- Helpers -->
    <script src="/assets/js/sweetalert.js"></script>
    <script src="/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>

    <style>
                .toggle2 {
        cursor: pointer;
        display: inline-block;
        }

        .toggle-switch {
        display: inline-block;
        background: #ccc;
        border-radius: 16px;
        width: 58px;
        height: 32px;
        position: relative;
        vertical-align: middle;
        transition: background 0.25s;
        }
        .toggle-switch:before, .toggle-switch:after {
        content: "";
        }
        .toggle-switch:before {
        display: block;
        background: linear-gradient(to bottom, #fff 0%, #eee 100%);
        border-radius: 50%;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.25);
        width: 24px;
        height: 24px;
        position: absolute;
        top: 4px;
        left: 4px;
        transition: left 0.25s;
        }
        .toggle2:hover .toggle-switch:before {
        background: linear-gradient(to bottom, #fff 0%, #fff 100%);
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.5);
        }
        .toggle-checkbox:checked + .toggle-switch {
        background: #56c080;
        }
        .toggle-checkbox:checked + .toggle-switch:before {
        left: 30px;
        }

        .toggle-checkbox {
        position: absolute;
        visibility: hidden;
        }

        .toggle-label {
        margin-left: 5px;
        position: relative;
        top: 2px;
        }

        .overlay2 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

       .overlay2 .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        .loader21 {
    position: relative;
    width: 64px;
    height: 64px;
    background-color: rgba(0, 0, 0, 0.5);
    transform: rotate(45deg);
    overflow: hidden;
  }
  .loader21:after{
    content: '';
    position: absolute;
    inset: 8px;
    margin: auto;
    background: #222b32;
  }
  .loader21:before{
    content: '';
    position: absolute;
    inset: -15px;
    margin: auto;
    background: #de3500;
    animation: diamondLoader 2s linear infinite;
  }
  @keyframes diamondLoader {
    0%  ,10% {
      transform: translate(-64px , -64px) rotate(-45deg)
    }
    90% , 100% {
      transform: translate(0px , 0px) rotate(-45deg)
    }
  }

  .swal2-container {
    z-index: 3000; /* Ensure it's higher than Bootstrap's modal */
}
      
        </style>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="/" class="app-brand-link">
              <span class="app-brand-logo demo">
               <img src="/main/assets/images/logo.svg" style="width: 50%;" class="logo-image img-fluid"/>
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item">
              <a href="/" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <li class="menu-item ">
              <a href="{{route('user.services')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-download"></i>
                <div data-i18n="Service">Service</div>
              </a>
            </li>

            <li class="menu-item ">
              <a href="{{route('user.campaigns')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-copy-alt"></i>
                <div data-i18n="Campaign">Campaign</div>
              </a>
            </li>

            <li class="menu-item ">
              <a href="{{route('user.wishes')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-gift"></i>
                <div data-i18n="Wishes">Wishes</div>
              </a>
            </li>

            <li class="menu-item ">
              <a href="{{route('users.messages')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-message"></i>
                <div data-i18n="Messages">Messages</div>
              </a>
            </li>



            <!-- Layouts -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Account">Account</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="{{route('profile')}}" class="menu-link">
                    <div data-i18n="Profile">Profile</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{route('wallet')}}" class="menu-link">
                    <div data-i18n="Wallet">Wallet</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{route('user.payment')}}" class="menu-link">
                    <div data-i18n="Payment">Payment</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{route('user.activity')}}" class="menu-link">
                    <div data-i18n="Activities">Activities</div>
                  </a>
                </li>

                <li class="menu-item">
                  <a href="{{route('user.review')}}" class="menu-link">
                    <div data-i18n="Review">Reviews</div>
                  </a>
                </li>
              
              </ul>
            </li>

           
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
               

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="/images/{{Admin('image_folder').Admin('image')}}" alt class=" rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="/images/{{Admin('image_folder').Admin('image')}}" alt class=" rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{Admin('username')}}</span>
                            <small class="text-muted">
                            @if (Admin('role') == 2)
                                Creator
                            @else 
                                User
                            @endif</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('profile')}}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('wallet')}}">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Wallet</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('logout')}}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

                   <!-- / Navbar -->
                   <div id="" class="overlay2 d-none">
                    
                        <span class="loader21"></span>
                </div>
          <!-- Content wrapper -->
          <div class="content-wrapper">

          @yield('content')

            <!-- Footer -->
    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
          <div class="mb-2 mb-md-0">
            ©
            <script>
              document.write(new Date().getFullYear());
            </script>
            , made with ❤️ by
            <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
          </div>
          <div>
            <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
            <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>
  
            <a
              href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
              target="_blank"
              class="footer-link me-4"
              >Documentation</a
            >
  
            <a
              href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
              target="_blank"
              class="footer-link me-4"
              >Support</a
            >
          </div>
        </div>
      </footer>
      <!-- / Footer -->
  
      <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="https://sdk.monnify.com/plugin/monnify.js"></script>
    <script src="https://js.paystack.co/v2/inline.js"></script>
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/select2.min.js"></script>
    <script src="/assets/js/nice-select2.js"></script>
    <script src="https://cdn.tiny.cloud/1/v0glwdxxasyoipqr3m39t3nrablmv69w3nenrbpor3axfjfs/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="/assets/vendor/DataTables/datatables.min.js"></script>
    <script src="/assets/js/user_main.js"></script>
    <script type="text/javascript" src="/main/src/js/toastify-js.js"></script>
    <!-- Page JS -->
    <script src="/assets/js/dashboards.js"></script>
    <script src="/assets/js/pages-account-settings-account.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>