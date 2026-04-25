@extends('layouts.app')
<style>
   
   .card-example-user-email {
      color: #34395e;
      font-size: 12px;
      font-weight: 600;
      height: auto;
      letter-spacing: .5px;
      line-height: 20px !important;
      overflow: hidden;
      width: auto
    }

    .client-card-example-name,
    .user-card-example-name {
      margin-right: auto
    }

    .card-example-client-website {
      font-size: 12px;
      font-weight: 600;
      height: auto;
      letter-spacing: .5px;
      line-height: 20px !important;
      overflow: hidden;
      width: 180px
    }

    .user-card-example-index {
      padding: 15px 15px 2px !important
    }

    .email-verified {
      color: #6be295
    }

    .hover-card-example {
      transition-duration: .6s
    }

    .link-a {
      color: #6777ef;
      font-weight: 500;
      transition: all .5s;
      -webkit-transition: all .5s;
      -o-transition: all .5s;
    }

    .link-a:not(.btn-social-icon):not(.btn-social):not(.page-link) .ion,
    .link-a:not(.btn-social-icon):not(.btn-social):not(.page-link) .fas,
    .link-a:not(.btn-social-icon):not(.btn-social):not(.page-link) .far,
    .link-a:not(.btn-social-icon):not(.btn-social):not(.page-link) .fal,
    .link-a:not(.btn-social-icon):not(.btn-social):not(.page-link) .fab {
      margin-left: 4px;
    }

    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6 {
      font-weight: 700;
    }

    .shadow {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
    }

    .card-example {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
      background-color: #fff;
      border-radius: 3px;
      border: none;
      position: relative;
      margin-bottom: 30px;
    }

    .card-example .card-example-header,
    .card-example .card-example-body,
    .card-example .card-example-footer {
      background-color: transparent;
      padding: 20px 25px;
    }

    .card-example .card-example-body {
      padding-top: 20px;
      padding-bottom: 20px;
    }

    .card-example .card-example-header {
      border-bottom-color: #f9f9f9;
      line-height: 30px;
      -ms-grid-row-align: center;
      align-self: center;
      width: 100%;
      min-height: 70px;
      padding: 15px 25px;
      display: flex;
      align-items: center;
    }

    .card-example .card-example-header h4 {
      font-size: 16px !important;
      line-height: 28px !important;
      color: #6777ef;
      padding-right: 10px;
      margin-bottom: 0;
    }

    .card-example.card-example-primary {
      border-top: 2px solid #6777ef;
    }

    .badge {
      vertical-align: middle;
      padding: 7px 12px;
      font-weight: 600;
      letter-spacing: .3px;
      border-radius: 30px;
      font-size: 12px;
    }

    .badge.badge-primary {
      background-color: #6777ef;
    }

    .badge.badge-dark {
      background-color: #191d21;
    }

    .dropdown-menu-user {
      box-shadow: 0 10px 40px 0 rgba(51, 73, 94, 0.15);
      border: none;
      width: 200px;
    }

    :root {
      /* Colors */
      --primary: #6777ef;
      --secondary: #34395e;
      --success: #47c363;
      --info: #3abaf4;
      --warning: #ffa426;
      --danger: #fc544b;
      --light: #e3eaef;
      --dark: #191d21;
    }

    body,
    html {
      min-height: 100%;
    }

    body {
      background-color: #f4f6f9;
      font-size: 14px;
      font-weight: 400;
      font-family: "Nunito", "Segoe UI", arial;
      color: #6c757d;
    }

    .fas,
    .far,
    .fab,
    .fal {
      font-size: 13px;
    }
    .user-avatar-image {
       object-fit: cover;
       height: 50px;
    }
</style>
@section('content')

    {{-- @if (auth()->user()->can('create user'))
    <div class="d-flex py-2">
        <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>
        <div class="p-2 justify-content-end">
            <a class="pull-right btn btn-primary" href="{{route('users.create')}}">Ajouter
                un {{ __('Name.User') }} <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>
    @endif  --}}
    
    @if (auth()->user()->can('create user'))
    <div class="d-flex py-2">
        <!-- Heading -->
        <h1 class="h1 p-2 flex-grow-1 align-items-start page__heading"></h1>

        <!-- Buttons Section -->
        <div class="p-2 d-flex justify-content-end">
          


            <!-- Button: Ajouter un User -->
            <a class="btn btn-primary me-3" href="{{route('users.create')}}">
                @lang('messages.Ajouter un Utilisateur') <i class="bi bi-plus-lg"></i>
            </a>
        </div>
    </div>
@endif




    <div class="card-body">
        {{-- wire:id="EG9daxIi0I6fwB3CZZzu" --}}

        @if (session()->has('deleted'))
          <div id='alert' class="alert alert-warning alert-dismissible fade show" role="alert">
              <p class="mb-0">{{ session('deleted') }}</p>
              <button type="button" class="btn-close" data-bs-dismiss="alert"
                  aria-label="Close"></button>
          </div>
        @endif
        <div class="row">
            {{-- <div class="mt-0 mb-3 col-12 d-flex justify-content-end">
                <div class="pr-0 pl-2 pt-2 pb-2">
                    <input wire:model.debounce.100ms="search" type="search" class="form-control" placeholder="Search"
                        id="search">
                </div>
            </div>
            <div class="col-md-12">
                <div wire:loading="" id="live-wire-screen-lock">
                    <div class="live-wire-infy-loader">
                        <div id="infyLoader" class="infy-loader">
                            <svg class="loader-position" width="150px" height="75px" viewBox="0 0 187.3 93.7"
                                preserveAspectRatio="xMidYMid meet">
                                <path stroke="#00c6ff" id="outline" fill="none" stroke-width="5" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10"
                                    d="M93.9,46.4c9.3,9.5,13.8,17.9,23.5,17.9s17.5-7.8,17.5-17.5s-7.8-17.6-17.5-17.5c-9.7,0.1-13.3,7.2-22.1,17.1 				c-8.9,8.8-15.7,17.9-25.4,17.9s-17.5-7.8-17.5-17.5s7.8-17.5,17.5-17.5S86.2,38.6,93.9,46.4z">
                                </path>
                                <path id="outline-bg" opacity="0.05" fill="none" stroke="#f5981c" stroke-width="5"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                    d="				M93.9,46.4c9.3,9.5,13.8,17.9,23.5,17.9s17.5-7.8,17.5-17.5s-7.8-17.6-17.5-17.5c-9.7,0.1-13.3,7.2-22.1,17.1 				c-8.9,8.8-15.7,17.9-25.4,17.9s-17.5-7.8-17.5-17.5s7.8-17.5,17.5-17.5S86.2,38.6,93.9,46.4z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- top Users --}}
            @foreach ($users as $user)
                @if ($user['id'] !== 1)

            <div class="col-12 col-md-6 col-lg-4 col-xl-4 extra-large">
                <div
                  class="livewire-card-example card-example card-example-primary shadow mb-5 rounded user-card-example-view hover-card-example">
                  <div class="card-example-header d-flex align-items-center user-card-example-index d-sm-flex-wrap-0">
                    <div class="author-box-left pl-0 mb-auto">
                        <img src="{{ asset($user['photo'] ) }}"  width="50" alt="Profile" class="rounded-circle user-avatar-image uAvatar">
                    
                    </div>
                    <div class="ml-2 w-100 mb-auto px-3">
                      <div class="justify-content-between d-flex">
                        <div class="user-card-example-name pb-1">
                          @if (auth()->user()->can('show one user'))

                            <a class="link-a" href="{{route('users.show',$user['id'])}}" title="Afficher un utilisateur">
                              <h4 class="h4"><b>{{ $user['nom'] }} {{ $user['prenom'] }} </b></h4>
                            </a>

                          @else

                          <div class="link-a" >
                            <h4 class="h4"><b>{{ $user['nom'] }} {{ $user['prenom'] }} </b></h4>
                          </div>
                          @endif
                        </div>
                        
                        @if (auth()->user()->can('delete user') || auth()->user()->can('update user'))
                          <a href="#"  data-bs-toggle="dropdown" aria-expanded="false"
                              class="notification-toggle  mr-1 dropdown">
                              <i class="bi bi-three-dots-vertical"></i>
                          </a>

                          <ul class="dropdown-menu dropdown-menu-user ">
                              <li>
                                
                            @if (auth()->user()->can('update user'))
                                  <a href="{{route('users.edit',$user['id'])}}"
                                      class="dropdown-item dropdown-item-desc edit-btn" data-id="{{$user['id']}}">
                                      <i class="bi bi-pen-fill text-primary"></i> Edit
                                  </a>
                              @endif
                              </li>


                              <li>
                                  
                                  @livewire('user-component', ['id' => $user['id']])
                              </li>
                          </ul>
                        @endif
            
                      </div>
                      <div class="card-example-client-website ">
                        {{$user->getRoleNames()->first()}}
                      </div>
                      <div class="card-example-user-email pt-1 mb-3">
                        {{$user['email']}}
                        <span data-toggle="tooltip" title="" data-original-title="Email is verified"><i
                            class="fas fa-check-circle email-verified"></i></span>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              
              @include('user.delete')
                 
              {{-- @include('user.show') --}}
                @endif
            @endforeach
            {{-- end Users --}}
        </div>

        <!-- Livewire Component wire-end:EG9daxIi0I6fwB3CZZzu -->
    </div>
@endsection
