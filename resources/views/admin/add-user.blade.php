@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ $isEdit ? 'Edit':'Add New' }} {{ $type ? ucwords($type) : 'User' }}</h4>
          <div class="row">
            <div class="col-12">
              @include('admin.inc.session-message')
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card"> 
                <div class="card-body">
                  <form class="cmxform" id="signupForm" method="post" action="{{route('admin-add-user', $type)}}">
                    @csrf
                    @if($isEdit)
                      <input type="hidden" value="{{$user->id}}" name="editId">
                    @endif
                    <fieldset>
                      <div class="form-group">
                        <label for="firstname">Full Name</label>
                        <input id="firstname" class="@error('name') is-invalid @enderror form-control" name="name" type="text" value="{{ $isEdit && $user->name ? $user->name:'' }}">
                        @include('admin.inc.error_message',['name'=>'name'])
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label> 
                        <input id="email" class="@error('email') is-invalid @enderror form-control" name="email" type="email" value="{{ $isEdit && $user->email ? $user->email:'' }}">
                        @include('admin.inc.error_message',['name'=>'email'])
                      </div>                      
                      <div class="form-group">
                        <label for="lastname">Phone</label>
                        <input id="lastname" class="@error('phone') is-invalid @enderror form-control" name="phone" type="text" value="{{ $isEdit && $user->mobile ? $user->mobile:'' }}" {{ $isEdit ? 'readonly':'' }}>
                        @include('admin.inc.error_message',['name'=>'phone']) 
                      </div>

                      <div class="form-group">
                        <label for="parent">Role</label>
                        <select class="@error('role') is-invalid @enderror form-control form-control-lg py-3" id="role" name="role">
                          <option value="">Select Role</option>
                          <option value="a" {{ $isEdit && $user->role=='a' ? 'selected':'' }}>Admin</option>
                          @if($isEdit)
                          <option value="s" {{ $user->role=='s' ? 'selected':'' }}>Supplier</option>
                          <option value="c" {{ $user->role=='c' ? 'selected':'' }}>Customer</option>  
                          @else
                          <option value="s" {{ $type=='supplier' ? 'selected':'' }}>Supplier</option>
                          <option value="c" {{ $type=='customer' || $type=='user' ? 'selected':'' }}>Customer</option>
                          @endif
                        </select>
                       @include('admin.inc.error_message',['name'=>'role']) 
                      </div>
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" class="@error('password') is-invalid @enderror form-control" name="password" type="password">
                        @include('admin.inc.error_message',['name'=>'password'])
                      </div>
                      <div class="form-group">
                        <label for="confirm_password">Confirm password</label>
                        <input id="confirm_password" class="@error('confirm_password') is-invalid @enderror form-control" name="confirm_password" type="password">
                        @include('admin.inc.error_message',['name'=>'confirm_password'])
                      </div>
                      <div class="form-group">
                        <label for="parent">Status</label>
                        <select class="@error('status') is-invalid @enderror form-control form-control-lg py-3" id="role" name="status">
                          <option value="1" {{ $isEdit && $user->status==true ? 'selected':'' }}>Active</option>
                          <option value="0" {{ $isEdit && $user->status==false ? 'selected':'' }}>Inactive</option>
                          
                        </select>
                       @include('admin.inc.error_message',['name'=>'status']) 
                      </div>                      

                      <input class="btn btn-primary" type="submit" value="Submit">
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection