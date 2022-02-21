@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ $is_edit ? 'Edit Attribute Value' : 'Add New Attribute Value' }}</h4>
          <div class="row">
            <div class="col-12">
              @include('admin.inc.session-message')            
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card"> 
                <div class="card-body">
                  <form class="cmxform" id="signupForm" method="post" action="{{ route('add_attribute_values', $is_edit) }}">
                    @csrf
                      @if($is_edit)
                        <input type="hidden" value="{{ $attribute_value->id }}" name="edit_id">
                      @endif
                          <fieldset> 
                            <div class="form-group">
                              <label for="parent">Attribute Name</label>
                              <select class="@error('att_name') is-invalid @enderror form-control form-control-lg py-3" id="role" name="attr_name">
                                <option value="">Select Attribute</option>
                                  @foreach($attributes as $attr)
                                    <option value="{{$attr->id}}" {{ $is_edit && $attr->id == $attribute_value->attribute_id ? 'selected' : '' }}>
                                      {{$attr->name}} of {{$attr->cat_name}}
                                    </option>
                                  @endforeach                          
                              </select> 
                              @include('admin.inc.error_message',['name'=>'att_name']) 
                            </div>

                            <div class="form-group">
                              <label for="firstname">Attribute Value</label>
                              <input id="firstname" class="@error('value') is-invalid @enderror form-control" name="value" type="text" value="{{ $is_edit ? $attribute_value->value : '' }}">
                              @include('admin.inc.error_message',['name'=>'value'])
                            </div>
                            @if($is_edit)
                            <div class="form-group">
                              <label for="is_verified">Is Verified</label>
                              <select class="@error('is_verified') is-invalid @enderror form-control form-control-lg py-3" id="is_verified" name="is_verified">
                                    <option value="1" {{$attribute_value->is_verified==true ? 'selected':''}}>Verified</option>   
                                    <option value="0" {{$attribute_value->is_verified==false ? 'selected':''}}>Not Verified</option>   
                              </select> 
                              @include('admin.inc.error_message',['name'=>'is_verified']) 
                            </div>
                            @else
                            <input type="hidden" value="1" name="is_verified">
                            @endif

                            <div class="form-group">
                              <label for="status">Status</label>
                              <select class="@error('status') is-invalid @enderror form-control form-control-lg py-3" id="status" name="status">
                                <option value="1" {{$is_edit && $attribute_value->status==true ? 'selected':''}}>Active</option>
                                <option value="0" {{$is_edit && $attribute_value->status==false ? 'selected':''}}>Inactive</option>
                              </select> 
                              @include('admin.inc.error_message',['name'=>'status']) 
                            </div>                                        
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