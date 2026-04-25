<!-- ======= Header ======= -->
<style>
    .cardsNot {
        /* width: 100%; */
        width: 320px;
        /* height: 70px; */
        margin: 5px;
        padding: 5px;
        /* background: #faf9f9; */
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: left;
        backdrop-filter: blur(10px);
        transition: 0.5s ease-in-out;
    }

    .cardsNot:hover {
        cursor: pointer;
        transform: scale(1.03);
    }

    .img {
        width: 50px;
        height: 50px;
        margin-left: 10px;
        border-radius: 10px;
        background: linear-gradient(to right, #4b6cb7, #182848);
    }

    .cardsNot:hover>.img {
        transition: 1s ease-in-out;
        background: linear-gradient(to right, #859398, #283048);
    }

    .textBox {
        width: calc(100% - 90px);
        margin-left: 10px;
        /* color: white; */
        font-family: 'Poppins' sans-serif;
    }

    .textContent {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .span {
        font-size: 10px;
    }

    .h1 {
        
        font-size: 14px;
        font-weight: bolder;
        color: #0b798a
    }

    .p {
        font-family: 'georgia';
        font-size: 12px;
        font-weight: lighter;
        color: #859398
    }

    .he-100 {
        min-height: 350px !important;
    }

    .font-w {
        font-weight: 600;
    }




    .tooltip {
        position: absolute;
        left: 50%;
        top: 70%;
        transform: translateX(-50%);
        opacity: 0;
        visibility: hidden;
        background: #0b798a;
        color: #fff;
        padding: 10px;
        border-radius: 4px;
        transition: opacity 0.3s, visibility 0.3s, top 0.3s, background 0.3s;
        /* z-index: 1; */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .tooltip::before {
        content: "";
        position: absolute;
        bottom: 100%;
        left: 50%;
        border-width: 8px;
        border-style: solid;
        border-color: transparent transparent #0b798a transparent;
        transform: translateX(-50%);
    }

    .tooltip-container:hover .tooltip {
        left: 50%;
        top: 70%;
        opacity: 1;
        visibility: visible;
        background: #0e94a0;
        transform: translate(-50%, -5px);
    }

    /* style menu button */
        .hamburger {
    cursor: pointer;
    }

    .hamburger input {
    display: none;
    }

    .hamburger svg {
    /* The size of the SVG defines the overall size */
    height: 2em;
    /* Define the transition for transforming the SVG */
    transition: transform 400ms cubic-bezier(0.4, 0, 0.2, 1);
    }

    .line {
    fill: none;
    stroke: rgb(0, 0, 0);
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-width: 3;
    /* Define the transition for transforming the Stroke */
    transition: stroke-dasharray 500ms cubic-bezier(0.4, 0, 0.2, 1),
                stroke-dashoffset 500ms cubic-bezier(0.4, 0, 0.2, 1);
    }

    .line-top-bottom {
    stroke-dasharray: 12 63;
    }
    @media only screen and (min-width : 1199px ){
    .hamburger input:not(:checked) + svg {
    transform: rotate(-45deg);
    }

    .hamburger input:not(:checked) + svg .line-top-bottom {
    stroke-dasharray: 20 300;
    stroke-dashoffset: -32.42;
    }
    }
    @media only screen and (max-width : 1198px ) {
    .hamburger input:checked + svg {
    transform: rotate(-45deg);
    }

    .hamburger input:checked + svg .line-top-bottom {
    stroke-dasharray: 20 300;
    stroke-dashoffset: -32.42;
    }
    }
</style>
<header id="header" class="header fixed-top d-flex align-items-center">
  @php
    $agence = \App\Models\Agence::first();
@endphp
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset($agence->logo) }}"  class="me-0" alt="logo">
        </a>
        {{-- <i class="bi bi-list toggle-sidebar-btn"></i> --}}
        <label  class="hamburger  ">
            
            <input type="checkbox" class="toggle-sidebar-btn">
            <svg viewBox="0 0 32 32">
              <path class="line line-top-bottom" 
              d="M27 10 13 10C10.8 10 9 8.2 9 6 9 3.5 10.8 2 13 2 15.2 2 17 3.8 17 6L17 26C17 28.2 18.8 30 21 30 23.2 30 25 28.2 25 26 25 23.8 23.2 22 21 22L7 22"></path>
              <path class="line" d="M7 16 27 16"></path>
            </svg>
          </label>

    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">

        <ul class="d-flex align-items-center">

            
         
           
            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset(Auth::user()->photo) }}" width="36" height="36"
                        alt="Profile" class="rounded-circle">
                    <span
                        class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->prenom[0] }}.{{ Auth::user()->nom }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h6>
                       
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item d-flex align-items-center"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </li>

                </ul><!-- End Profile Dropdown Items -->

            </li><!-- End Profile Nav -->
           
        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->


{{-- Our client's website hosting has expired


Subject: Hosting Expiration Notification

Dear [Client],

We hope this message finds you well. We would like to inform you that the hosting for your website is set to expire on [expiration date].

To ensure uninterrupted service and continued accessibility of your website, we kindly recommend renewing your hosting plan before the expiration date.

If you have any questions or require assistance with the renewal process, our support team is ready to help.

Thank you for your attention to this matter.

Best regards,
[Your Company Name] --}}