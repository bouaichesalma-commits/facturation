 @extends('layouts.app')
 @section('content')

<style>
    #nameRole::placeholder {
    color: rgb(253, 57, 57) !important;
    opacity: 0.5 !important;
    }
    

    .checkmark {
        

  --green-color: #3e414143;
  --main-color: #4f565643;
  border: 2px solid var(--main-color);
  box-shadow: 4px 4px var(--green-color) !important;
  position: relative;
  top: -2px;
  
  width: 18px;
  height: 18px;
  /* background-color: var(--input-out-of-focus); */
  transition: all 0.3s;
}
.reset-file {
    all: revert;
}
</style>
     <div class="section-body">
         <div class="row">
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-body">
                        
                        @if (session()->has('SuccessRole'))
                            <div id='alert' class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="mb-0">{{ session('SuccessRole') }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                         <form method="POST" action="{{route('role.store')}}" accept-charset="UTF-8" id="createRoleForm" class="role-form">
                            @csrf
                             <div class="row">
                                 <!-- Name Field -->
                                 <div class=" col-sm-12 col-md-7 ">
                                     <label for="name" class="badge text-dark pb-2 ps-1 ">{{__('Name.Name Role')}}:</label><span
                                         class="text-danger">* </span>
                                     <input class="form-control @error('nameRole') is-invalid @enderror" placeholder="@error('nameRole') {{$message}} @enderror" name="nameRole" type="text"
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

                                     <label for="detail" class="badge text-dark pb-2 pt-4">{{__('Name.Permissions')}}:
                                         <div class="form-check form-switch ">
                                             <input class="form-check-input" type="checkbox" role="switch" id="checkAll"
                                                 name="checkall"><label class="form-check-label badge text-dark  "
                                                 for="flexSwitchCheckDefault">{{__('Name.Check All')}}</label>
                                         </div>
                                     </label>


                                     <div class="row">
                                        
                                    @foreach ($allPermission as  $Perm) 
                                        @if ($Perm->name != "no permission")
                                            
                                            <div class="checkbox col-4 role-checkbox pb-3 ps-3">
                                                <div class="custom-control custom-checkbox form-check">
                                                    <input type="checkbox"
                                                        class="checkboxClass checkmark custom-control-input form-check-input ml-4"
                                                        id="permission{{$Perm->id}}" name="permissions[]" value="{{$Perm->id}}">
                                                    <label class="custom-control-label form-check-label text-secondary mx-2"
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
                                     {{__('save')}}</button>
                                 <button type="reset"
                                     class="btn btn-light ml-1">{{__('cancel')}}</button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection


 