@extends('layouts.app')
<style>
        .total-permission-count{background:#6777ef;border-bottom-left-radius:30px;border-top-left-radius:30px;bottom:0;color:#fff;font-weight:600;padding:1px 5px 2px 8px;position:absolute;right:0;transition:all .3s ease-in-out}
        .role-cards{min-height:89px!important}
        /* .removeMarginX{margin:1em -1.7em!important} */
        .hover-card{transition-duration:.6s}.hover-card:hover{opacity:1;transform:translateY(-5px);z-index:999}
        /* style  */
        
    a {
    color: #6777ef;
    font-weight: 500;
    transition: all .5s;
    -webkit-transition: all .5s;
    -o-transition: all .5s; }
    .text-primary, .text-primary-all *, .text-primary-all *:before, .text-primary-all *:after {
    color: #6777ef !important; }
    .text-dark, .text-dark-all *, .text-dark-all *:before, .text-dark-all *:after {
    color: #191d21 !important; }

    .permFont {
    font-weight: 700; }

    .shadow {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03); }
    /* 3.2 Form */
    .form-control,
    .input-group-text,
    .custom-select,
    .custom-file-label {
    background-color: #fdfdff;
    border-color: #e4e6fc; }

    .input-group-text,
    select.form-control:not([size]):not([multiple]),
    .form-control:not(.form-control-sm):not(.form-control-lg) {
    font-size: 14px;
    padding: 10px 15px;
    height: 42px; }

    /* 3.5 Card */
    .card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
    background-color: #fff;
    border-radius: 3px;
    border: none;
    position: relative;
    margin-bottom: 30px; }
    .card .card-header, .card .card-body, .card .card-footer {
        background-color: transparent;
        padding: 20px 25px; }
    .card .card-body {
        padding-top: 20px;
        padding-bottom: 20px; }
    .card .card-header {
        border-bottom-color: #f9f9f9;
        line-height: 30px;
        -ms-grid-row-align: center;
        align-self: center;
        width: 100%;
        min-height: 70px;
        padding: 15px 25px;
        display: flex;
        align-items: center; }
        .card .card-header h4 {
        font-size: 16px;
        line-height: 28px;
        color: #6777ef;
        padding-right: 10px;
        margin-bottom: 0; }
    .card.card-primary {
        border-top: 2px solid #6777ef; }
    .card.card-dark {
        border-top: 2px solid #191d21; }



</style>
@section('content')
  
    <div class="card-body">
        
        {{-- <div class="triangless"></div> --}}
        <div  class="row">
            <div class="d-flex">
                <h1 class="p-2 flex-grow-1 align-items-start page__heading"></h1>
                <div class="p-2 justify-content-end">
                    <a class="pull-right btn btn-primary" href="{{route('role.create')}}">New Role <i class="bi bi-plus-lg"></i>
                    </a>
                </div>
            </div>
    @foreach ($roles as $role)
        @if ($role['id'] !== 1)
             <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="livewire-card card card-primary shadow mb-5 rounded removeMarginX hover-card">
                    <div class="card-header d-flex justify-content-between align-items-center p-3 role-cards">
                        

                        <button type="button" class="btn text-primary icon-medium-bold" data-bs-toggle="modal" data-bs-target="#viewModal{{ $role['id'] }}">
                            {{-- <i class="bi bi-box-arrow-up-left"></i> --}}
                             <h4 class="text-primary ml-2"><b>{{ $role['name'] }} </b></h4>
                        </button>
                        <a href="#"  data-bs-toggle="dropdown" aria-expanded="false"
                            class="notification-toggle  mr-1 dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            
                            <li>
                                <a href="{{route('role.edit',$role['id'])}}"
                                    class="dropdown-item dropdown-item-desc edit-btn" data-id="{{$role['id']}}">
                                    <i class="bi bi-pen-fill text-primary"></i> Edit
                                </a>
                            </li>
                            
                            <li>
                                @livewire('role-component', ['id' => $role['id']])
                                
                            </li>
                        </ul>
                        

                    </div>
                    <div class="card-body d-flex justify-content-between align-items-center p-2 mt-3">
                        <div>
                            <span class="total-permission-count">
                                <big class="font-weight-bold">{{count($role->permissions);}} </big>Permissions</span>
                        </div>
                    </div>
                </div>
            </div> 
            
                 @include('role.delete')
                 
                @include('role.show')
        
         @endif
    @endforeach
            {{--end roles --}}
        </div>


        <!-- Livewire Component wire-end:EG9daxIi0I6fwB3CZZzu -->
    </div>
@endsection
