@extends('layouts.app')
@section('content')

<style>
#nameRole::placeholder {
 color: rgb(253, 57, 57) !important;
 opacity: 0.5 !important;
 
}
.invalid-feedbacks {
    /* display: none; */
    width: 100%;
    margin-top: 0.25rem;
    font-size: .875em;
    color: #dc3545;
}
</style>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                       
                       @if (session()->has('SuccessRoleupdate'))
                           <div id='alert' class="alert alert-success alert-dismissible fade show" role="alert">
                               <p class="mb-0">{{ session('SuccessRoleupdate') }}</p>
                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                           </div>
                       @endif

                        <form method="POST" action="{{route('role.update',$role['id'])}}" accept-charset="UTF-8" id="createRoleForm" class="role-form">
                           @csrf
                           @method('PUT')
                            <div class="row">
                                <!-- Name Field -->
                                <div class=" col-sm-12 col-md-7 ">
                                    <label for="name" class="badge text-dark pb-2 ps-1 ">Name Role:</label><span
                                        class="text-danger">* </span>
                                        @error('nameRole') 
                                                <div class="invalid-feedbacks">
                                                    {{$message}}
                                                </div>
                                        @enderror
                                    <input class="form-control @error('nameRole') is-invalid @enderror" placeholder="@error('nameRole') {{$message}} @enderror" 
                                    name="nameRole" type="text"
                                    value="{{old('nameRole')?old('nameRole'):$role['name']}}"
                                        id="nameRole">
                                </div>
                                <!-- Detail Field -->


                                <script>
                                   $(document).ready(function() {
                                       $("#checkAll").click(function() {
                                           $(".checkboxClass").prop('checked', $(this).prop('checked'));
                                       })
                               
                                   });
                               </script>

                                <div class="form-group col-sm-12 col-md-12">

                                    <label for="detail" class="badge text-dark pb-2 pt-4">Permissions:
                                        <div class="form-check form-switch ">
                                            <input class="form-check-input" type="checkbox" role="switch" id="checkAll"
                                                name="checkall"><label class="form-check-label badge text-dark  "
                                                for="flexSwitchCheckDefault">Check All</label>
                                        </div>
                                    </label>


                                    <div class="row">
                                       
                                   @foreach ($allPermission as  $key=>$Perm) 
                                    @if ($Perm->name != "no permission")
                                        
                                        <div class="checkbox col-4 role-checkbox pb-3 ps-3">
                                            <div class="custom-control custom-checkbox form-check">
                                                <input type="checkbox"
                                                    class="checkboxClass custom-control-input form-check-input"
                                                    id="permission{{$Perm->id}}" name="permissions[]" value="{{$Perm->id}}" 
                                                    @checked(in_array($Perm->id, $roleWithpermission->toArray()) ? true : false)>
                                                <label class="custom-control-label form-check-label text-secondary"
                                                    for="permission{{$Perm->id}}">{{__("role.".$Perm->name)}}</label>
                                            </div>
                                        </div>
                                    @endif
                                   
                                   @endforeach
                                       
                                   

                                    </div>
                                </div>
                            </div>
                            <!-- Submit Field -->
                            <div class="form-group col-sm-12 pt-4">
                                <button type="submit" 
                                    class="btn btn-primary save-btn"
                                    data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing..." id="butSubmitRole">
                                    {{__("Name.save")}}</button>
                                <button type="reset"
                                    class="btn btn-light ml-1">{{__("Name.cancel")}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


