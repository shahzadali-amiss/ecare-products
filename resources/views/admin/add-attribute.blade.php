@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row"> 
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ $is_edit ? 'Edit Attribute' : 'Add New Attribute' }}</h4>
          <div class="row">
            <div class="col-12">
              @if(Session::has('msg'))
              <div class="alert alert-warning" role="alert">
                  <strong>Heads up!</strong> {{Session::get('msg')}}
              </div>
              @endif              
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card"> 
                <div class="card-body">
                  <form class="cmxform" id="signupForm" method="post" action="{{ route('add_attribute', $is_edit) }}">
                    @csrf
                    @if($is_edit)
                      <input type="hidden" value="{{ $attribute->id }}" name="edit_id">
                    @endif
                    <fieldset> 

                      <div class="form-group">
                        <label for="firstname">Attribute Name</label>
                        <input id="firstname" class="@error('name') is-invalid @enderror form-control" name="name" type="text" value="{{ $is_edit ? $attribute->name : '' }}">
                        @include('admin.inc.error_message',['name'=>'name'])
                      </div>

                      <div class="form-group">
                        <label for="parent">Category</label>
                        <select class="@error('role') is-invalid @enderror form-control form-control-lg py-3" id="role" name="category">
                          <option value="">Select Category</option>
                          @foreach($child_categories as $cc)
                          <option value="{{$cc->id}}" {{ ($is_edit and ($cc->id == $attribute->category_id)) ? 'selected' : '' }}>{{ucwords($cc->name)}}</option>
                          @endforeach                          
                        </select> 
                        @include('admin.inc.error_message',['name'=>'category']) 
                      </div>
<!-- 
                    
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" class="@error('password') is-invalid @enderror form-control" name="password" type="password">
                        @include('admin.inc.error_message',['name'=>'password'])
                      </div>
                      <div class="form-group">
                        <label for="confirm_password">Confirm password</label>
                        <input id="confirm_password" class="@error('c_password') is-invalid @enderror form-control" name="c_password" type="password">
                        @include('admin.inc.error_message',['name'=>'c_password'])
                      </div>
                      <div class="form-group">
                        <label for="parent">Status</label>
                        <select class="@error('status') is-invalid @enderror form-control form-control-lg py-3" id="role" name="status">
                          <option>Select Status</option>
                          <option value="1">Avtive</option>
                          <option value="0">Inactive</option>
                          
                        </select>
                       @include('admin.inc.error_message',['name'=>'status']) 
                      </div>  -->                   
                    <div class="form-group">
                      <input class="btn btn-primary" type="submit" value="Submit">
                    </div>  
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