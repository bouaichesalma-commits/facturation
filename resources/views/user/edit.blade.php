@extends('layouts.app')

@section('content')
<style>
        /*------ Settings ------*/
        .container {
            --color: #a5a5b0;
            --size: 15px;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            position: relative;
            bottom: 12px;
            cursor: pointer;
            font-size: var(--size);
            user-select: none;
            fill: var(--color);
        }

        .container .eye {
            position: absolute;
            animation: keyframes-fill .5s;
        }

        .container .eye-slash {
            position: absolute;
            animation: keyframes-fill .5s;
            display: none;
        }

        /* ------ On check event ------ */
        .container input:checked~.eye {
            display: none;
        }

        .container input:checked~.eye-slash {
            display: block;
        }

        /* ------ Hide the default checkbox ------ */
        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* ------ Animation ------ */
        @keyframes keyframes-fill {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
                color: #3e34fe
            }
        }

        section {
            font-family: Poppins, Helvetica, sans-serif;
        }

        .avatar-wrapper {
            position: relative;
            height: 200px;
            width: 200px;
            margin-top: 0px;
            margin-bottom: 10px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 1px 1px 15px -5px black;
            transition: all .3s ease;

            &:hover {
                transform: scale(1.05);
                cursor: pointer;
            }

            &:hover .profile-pic {
                filter: grayscale(100%);
                opacity: .5;
            }

            .profile-pic {
                height: 100%;
                width: 100%;
                transition: all .3s ease;
                object-fit: cover;
                filter: grayscale(80%);
                
                &:after {
                    font-family: FontAwesome;
                    content: "\f007";
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    position: absolute;
                    font-size: 150px;
                    background: #ecf0f1;
                    color: #34495e;
                    text-align: center;
                }
            }

            .upload-button {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;

                .bi-cloud-upload {
                    position: absolute;
                    font-size: 150px;
                    top: 2px;
                    left: 26px;
                    text-align: center;
                    opacity: 0;
                    transition: all .3s ease;
                    color: #201658;
                }

                &:hover .bi-cloud-upload {
                    opacity: .9;
                }
            }
        }

        /* ---------Tooltip------------- */
       

        .item-hints .hint {
            /* margin: 150px auto; */
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }



        .item-hints .hint[data-position="1"] .hint-content {
            top: 85px;
            left: 50%;
            margin-left: 56px;
        }

        .item-hints .hint-content {
            width: 300px;
            position: absolute;
            z-index: 5;
            padding: 110px 55px;
            opacity: 0;
            transition: opacity 0.7s ease, visibility 0.7s ease;
            color: #201658;
            visibility: hidden;
            pointer-events: none;
        }

        .item-hints .hint:hover .hint-content {
            position: absolute;
            z-index: 5;
            padding: 110px 55px;
            opacity: 1;
            -webkit-transition: opacity 0.7s ease, visibility 0.7s ease;
            transition: opacity 0.7s ease, visibility 0.7s ease;
            color: #201658;
            visibility: visible;
            pointer-events: none;
        }

        .item-hints .hint-content::before {
            width: 0px;
            bottom: 120px;
            left: 49.5px;
            content: "";
            background-color: #163045;
            height: 1.5px;
            position: absolute;
            transition: width 0.4s;
        }

        .item-hints .hint:hover .hint-content::before {
            width: 180px;
            transition: width 0.4s;
        }

        .item-hints .hint-content::after {
            -webkit-transform-origin: 0 50%;
            transform-origin: 0 50%;
            -webkit-transform: rotate(-225deg);
            transform: rotate(-225deg);
            bottom: 120px;
            left: 50px;
            width: 50px;
            content: "";
            background-color: #163045;
            height: 1.5px;
            position: absolute;
            opacity: 1;
            -webkit-transition: opacity 0.5s ease;
            transition: opacity 0.5s ease;
            -webkit-transition-delay: 0s;
            transition-delay: 0s;
        }

        .item-hints .hint:hover .hint-content::after {
            opacity: 1;
            visibility: visible;
        }

        .item-hints .hint[data-position="4"] .hint-content {
            bottom: 20px;
            left: 50%;
            margin-left: 56px;
        }
        
</style>
<section class="section mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card p-md-3 p-lg-4">
                    <div class="card-body">
                        @if (session()->has('info'))
                            <div id='alert' class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="mb-0">{{ session('info') }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('users.update',$user->id) }}" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12 d-flex justify-content-center item-hints">

                                <div class="hint" data-position="4">
                                    <span class="hint-radius"></span>
                                    <div class="avatar-wrapper" @error('image_user')
                                        style="box-shadow: 1px 1px 15px -5px rgb(255, 0, 0); !important"
                                    @enderror>
                                        <img class="profile-pic" src="{{ asset($user->photo) }}" />
                                        <div class="upload-button">
                                            <i class="bi bi-cloud-upload"aria-hidden="true"></i>


                                        </div>
                                        <input  type="file" class="file-upload"  name="image_user" accept="image/*" id="image_user" />
                                    </div>
                                    <div class="hint-content do--split-children">
                                        <p>Uploding image user.</p>
                                    </div>
                                      

                                </div> 
                            </div>
                                    @error('image_user')
                                         <div class="col-md-12 d-flex justify-content-center text-danger mb-2">{{ $message }}</div>
                                    @enderror

                            <div class="col-md-6">
                                <label for="inputNom" class="form-label">Nom :</label>
                                <span class="text-danger fs-6 ">*</span>
                                <input type="text" name="nom" value="{{ old('nom')?old('nom'):$user->nom }}"
                                    class="form-control @error('nom') is-invalid @enderror" id="inputNom">
                                @error('nom')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputprenom" class="form-label">Prenom :</label><span
                                class="text-danger fs-6 ">*</span>
                                <input type="text" name="prenom" value="{{ old('prenom')?old('prenom'):$user->prenom }}"
                                    class="form-control @error('prenom') is-invalid @enderror" id="inputprenom">
                                @error('prenom')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="inputEmail" class="form-label">Email :</label>
                                <span class="text-danger fs-6 ">*</span>
                                <input type="text" name="email" value="{{ old('email')?old('email'):$user->email }}"
                                    class="form-control @error('email') is-invalid @enderror" id="inputEmail">
                                @error('email')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- <div class="col-md-6">
                                <label for="inputpassword" class="form-label">New password :</label>
                                <span class="text-danger fs-6 ">*</span>
                                <div class="is-invalid mb-3">

                                    <input type="password" 
                                        class="form-control @error('password') is-invalid @enderror"
                                        aria-label="Recipient's username"
                                         aria-describedby="basic-addon2" 
                                         name="password"
                                        autocomplete="new-password"
                                        id="password"
                                    >

                                    {{-- input checked  --}
                                    <label class="container ">
                                        <input type="checkbox" checked="checked" id="password">
                                        <svg class="eye" xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 576 512">
                                            <path
                                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z">
                                            </path>
                                        </svg>
                                        <svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 640 512">
                                            <path
                                                d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z">
                                            </path>
                                        </svg>
                                    </label>

                                </div>
                                @error('password')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-6">
                                <label for="inputpassword_confirmation" class="form-label">Confirm password :</label>
                                <span class="text-danger fs-6 ">*</span>

                                <div class=" mb-3">
                                    <input 
                                        type="password" 
                                        class="form-control 
                                        @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" 
                                        aria-label="Recipient's username"
                                        aria-describedby="basic-addon2"
                                        autocomplete="new-password"
                                        id="password_confirmation"
                                    >

                                    <label class="container ">
                                        <input type="checkbox" checked="checked" id="password_confirmation">
                                        <svg class="eye" xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 576 512">
                                            <path
                                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z">
                                            </path>
                                        </svg>
                                        <svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 640 512">
                                            <path
                                                d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z">
                                            </path>
                                        </svg>
                                    </label>

                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div> --}}


                            <div class="col-md-12">
                                <label for="role" class="form-label">Role :</label>
                                <span class="text-danger fs-6 ">*</span>
                                <select class="form-select @error('role') is-invalid @enderror" id="role"
                                    name="role" data-placeholder="Séléctionner le role">
                                    {{-- <option></option> --}}
                                    <option value="" hidden>-- Séléctionner le Role --</option>
                                    @foreach ($role as $rol)
                                        @if ($rol['name'] != "admin")
                                            <option @selected(old('role')?( old('role') == $rol['name']):( $user->getRoleNames()->first() == $rol['name'])) value="{{ $rol['name'] }}">
                                                {{ $rol['name'] }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('role')
                                    <div class="text-danger ps-3">{{ $message }}</div>
                                @enderror
                            </div>





                            <div class="text-center mt-5">
                                <button type="reset" class="btn btn-secondary">Effacer</button>
                                <button type="submit" class="btn btn-primary"
                                    onclick="event.preventDefault();this.disabled = true; this.closest('form').submit();">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script>
        $(document).ready(() => {
            $("#password").click(() => {
                if ($("#password").prop('checked') == true) {
                    alert('yes')
                } else {
                    alert('non')
                }

            })
        })

        $(document).ready(function() {

            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".file-upload").on('change', function() {
                readURL(this);
                // console.log(this.files[0]);
            });

            $(".upload-button").on('click', function() {
                $(".file-upload").click();
            });
        });
    </script>
@endsection
