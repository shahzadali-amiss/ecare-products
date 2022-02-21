@extends('layouts.admin')
@section('content')          
<div class="content-wrapper"> 
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ $is_edit ? 'Edit Category' : 'Add New Category' }}</h4>
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
                  <form class="cmxform" id="add-product-form" method="post" action="{{ route('add_category', $is_edit) }}" enctype="multipart/form-data">
                    @csrf

                    @if($is_edit)
                      <input type="hidden" value="{{ $category->id }}" name="edit_id">
                    @endif

                    <fieldset>
                      <div class="form-group">
                        <label for="name">Category Name</label>
                       
                        <input id="name" class="@error('name') is-invalid @enderror form-control" name="name" type="text" value="{{ $is_edit ? $category->name : '' }}" >
                        @include('admin.inc.error_message',['name'=>'name']) 
                      </div>
                      <div class="form-group">
                        <label for="parent">Grand Category</label>
                        <select class="@error('grand') is-invalid @enderror form-control form-control-lg py-3" id="level" name="grand">

                          <option value="" selected=""> Select Grand Categories</option>

                            @foreach($categories as $cat)

                              @if($cat->category_type == 1)

                                @if($is_edit)
                                  <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @else
                                  <option value="{{ $cat->id }}" {{ old('grand') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endif

                              @endif

                            @endforeach
                         
                        </select>
                       @include('admin.inc.error_message',['name'=>'grand']) 
                      </div>

                      <div class="form-group">
                        <label for="parent"> Parent Category</label>
                        
                        <select class="@error('parent') is-invalid @enderror form-control form-control-lg py-3" id="level" name="parent">

                        <option value=""  selected="">Select Parent category</option>

                        @foreach($categories as $cat)

                          @if($cat->category_type == 2)

                            @if($is_edit)
                              <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @else
                              <option value="{{ $cat->id }}" {{ old('parent') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endif

                          @endif

                        @endforeach

                        </select>
                       @include('admin.inc.error_message',['name'=>'parent'])  
                      </div>

                      <div class="form-group">
                        <label for="image">Upload Image</label>
                        <input class="form-control @error('image') is-invalid @enderror" name="image" type="file">
                        @include('admin.inc.error_message',['name'=>'image'])
                      </div>

                      <div class="form-group"> 
                        <label for="status">Status</label>
                        <select class="@error('status') is-invalid @enderror form-control form-control-lg py-3" id="status" name="status" value="{{ $is_edit ? $category->status : '' }}">
                          <option value="1"  @if(@$category->status == '1'){{'selected'}}@endif>Active</option>
                          <option value="0"  @if(@$category->status == '0'){{'selected'}}@endif>Inactive</option>
                        </select>
                        @include('admin.inc.error_message',['name'=>'status'])
                      </div>

                      <input class="btn btn-primary" type="submit" value="{{@$mode ? 'Update' : 'Add'}}">
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