@extends('back-end.components.master')
@section('contens')
  <div class="row">
    <div class="col-md-4 grid-margin">
      <div class="card">
        <div class="card-body">
          
        
        </div>
      </div>
    </div>
    @include('back-end.messages.profile.viewProfile')

    <div class="col-md-8 grid-margin">
        <div class="card">
          <div class="card-body">
            @include('back-end.messages.alert.alert')
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="me-2 nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Overview</button>
                        <button class="me-2 nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Edit Profile</button>
                        <button class="me-2 nav-link" id="nav-saling-tab" data-bs-toggle="tab" data-bs-target="#nav-saling" type="button" role="tab" aria-controls="nav-saling" aria-selected="false">Saling</button>
                        <button class="me-2 nav-link {{ Session::has('password') ? ' active ' : '' }}" id="nav-change-pass-tab" data-bs-toggle="tab" data-bs-target="#nav-change-pass" type="button" role="tab" aria-controls="nav-change-pass" aria-selected="false">Change Password</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade   {{ Session::has('avatar') ? 'active show' : '' }}" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <form method="POST" action="{{ route('update.profile') }}" class=" p-4 formUpdateProfile" enctype="multipart/form-data">
                         @csrf
                           <div class="form-group">
                                <label for="">Profile Image</label>
                                <div class="show-profile">
                                    <input type="hidden" name="profile" id="profile">
                                    {{-- @if ($user->image != null) --}}
                                      {{-- <img src="{{ asset('uploads/image/'.$user->image) }}" alt="">
                                    @else --}}
                                    @if (Auth::user()->image > 0)
                                    <img class="rounded-circle profile-update" src="{{ asset('uploads/user/'.Auth::user()->image) }}" alt="">
                                    @elseif (Auth::user()->image == null)
                                    <img class="rounded-circle profile-update" src="https://t4.ftcdn.net/jpg/05/89/93/27/360_F_589932782_vQAEAZhHnq1QCGu5ikwrYaQD0Mmurm0N.jpg" alt="">

                                    @endif
                                    {{-- @endif --}}
                                    
                                    <label for="image" class=" btn choose"><i class="bi bi-pen text-primary"></i></label>
                                    <br><br>
                                    <button onclick="upldateAvatar('.formUpdateProfile')" onclick="" type="button" class=" btn btn-info btn-sm"><i class="bi bi-upload"></i></button>
                                    <button onclick="cancelAvatar({{ Auth::user()->id }})" type="button" class=" btn btn-danger btn-sm"><i class="bi bi-trash3"></i></button>
                                    
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"  type="button" class=" btn btn-facebook btn-sm"><i class="bi bi-card-image"></i></button>
                                    

                                    <input type="file" name="image" id="image" class="d-none">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name !=null ? Auth::user()->name : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email !=null ? Auth::user()->email : '' }}">
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{  Auth::user()->phone !=null ? Auth::user()->phone : "" }}">
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" value="{{ $address->address ?? ''}}" name="address" id="address">
                            </div>

                            <div class="form-group">
                                <label for="facebook">Facebook</label>
                                <input type="text" class="form-control" value="{{ $contacts['Facebook'] ?? '' }}" id="facebook" name="link[]"  placeholder="link to you facebook profile">
                            </div>

                            <div class="form-group">
                                <label for="telegram">Telegram</label>
                                <input type="text" class="form-control" value="{{ $contacts['Telegram'] ?? '' }}" id="telegram"  name="link[]" placeholder="link to you telegram account">
                            </div>

                            

                            <button type="submit" class=" btn btn-primary">Update</button>
                            

                        </form>
                        
                    </div>

                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">...</div>
                    <div class="tab-pane fade" id="nav-saling" role="tabpanel" aria-labelledby="nav-saling-tab" tabindex="0">...</div>

                    <div class="tab-pane  p-5 {{ Session::has('password') ? 'show active ' : '' }}" id="nav-change-pass" role="tabpanel" aria-labelledby="nav-change-pass-tab" tabindex="0">

                        <form action="{{ route('profile.change.password') }}" method="POST" >
                            @csrf
                            <div class="form-group">
                                <label for="current_pass">Current Password</label>
                                <input type="password" class="form-control @error('current_pass') is-invalid  @enderror" id="current_pass" name="current_pass">
                                {{-- @error('current_pass')
                                    <p class="text-danger {{ Session::has('error') ? 'text-danger' : '' }}">{{ $message }}</p>
                                @enderror --}}
                                @if (Session::has('error'))
                                    <p class="text-danger is-invalid ">{{ Session::get('error') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="new_pass">New Password</label>
                                <input type="password" class="form-control @error('new_pass') is-invalid  @enderror" id="new_pass" name="new_pass">
                                @error('new_pass')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="c_password">Confirm Password</label>
                                <input type="password" class="form-control @error('c_password') is-invalid  @enderror" id="c_password" name="c_password">
                                @error('c_password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                       

                    </div>

                </div>
          </div>
        </div>
      </div>

  </div>
@endsection

@section('scripts')
   <script>
        const  upldateAvatar =  (form)=>{
            let payloads = new FormData($(form)[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('change.avata') }}",
                data: payloads,
                contentType:false,
                processData:false,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                    $('.show-profile img').attr('src', `{{ asset('uploads/temp/${response.avatar}') }}`);
                    $('#profile').val(response.avatar)
                        Message(response.message)
                    }else{
                        Message(response.message, false)
                    }
                    
                }
            });
        }
        const cancelAvatar = () =>{
            let tempAvatar = $('#profile').val();
            if(!tempAvatar) return;
            $.ajax({
                type: "post",
                url: "{{ route('cancel.avatar') }}",
                data:{
                    avatar:tempAvatar
                },
                dataType:'json',
                success: function (response) {
                    if(response.status ==200){
                        $('.show-profile img').attr('src', `{{ asset('uploads/user/'. Auth::user()->image) }}`);
                        $('#profile').val('');
                        Message(response.message)
                    }
                }
            });
        }



    const downloadActiveImage = ()=>{
        $('#downloadBtn').on('click',function(){
            const activeImg = $('#carouselExampleFade .carousel-item.active img');
            if(activeImg.length){
                const imgSrc = activeImg.attr('src');
                const filename = imgSrc.split('/').pop();
                const link = document.createElement('a');
                link.href = imgSrc;
                link.download = filename;
                link.click();
            }
        });
    }    

   </script>
@endsection