@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12">  
      <div class="card"> 
        <div class="card-body">
          <h4 class="card-title">{{$is_edit ? 'Edit Ad Banner' : 'Add New Ad Banner'}}</h4>
          <div class="row">
            <div class="col-12">

              @include('inc.session-message')
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <form class="cmxform" id="add-product-form" method="post" action="{{ route('add_ad_banner',$is_edit) }}" enctype="multipart/form-data">
                    @csrf
                    <fieldset> 
                    @if($is_edit)
                      <input type="hidden" name="edit_id" value="{{$banner->id}}"> 
                    @else  

                    @endif  


                      <div class="form-group">
                        <label for="title">Banner Title</label>
                        <textarea id="title" class="form-control ckeditor @error('title') is-invalid @enderror" name="title">{{ $is_edit ? $banner->title : '' }}</textarea>
                        @include('admin.inc.error_message',['name'=>'title']) 
                      </div>

                      <div class="form-group">
                        <label for="type">Banner Type</label>
                        <select class="form-control form-control-lg py-3 @error('type') is-invalid @enderror" id="type" name="type">
                          <option value="Primary" @if(@$banner->type == 'Primary') {{'selected'}}@endif>Primary</option>
                          <option value="Secondary" @if(@$banner->type == 'Secondary'){{'selected'}}@endif>Secondary</option>
                        </select>
                        @include('admin.inc.error_message',['name'=>'status'])
                      </div>

                      <div class="form-group">
                        <label for="link">Banner Subtitle</label>
                        <textarea id="subtitle" class="form-control ckeditor @error('subtitle') is-invalid @enderror" name="subtitle">{{ $is_edit ? $banner->subtitle : '' }}</textarea>
                        @include('admin.inc.error_message',['name'=>'subtitle']) 
                      </div>

                      <div class="form-group">
                        <label for="tagline">Banner Tagline</label>
                        <textarea id="tagline" class="form-control ckeditor @error('tagline') is-invalid @enderror" name="tagline">{{ $is_edit ? $banner->tagline : '' }}</textarea>
                        @include('admin.inc.error_message',['name'=>'tagline']) 
                      </div>

                      <div class="form-group">
                        <label for="button_title">Button Title</label>
                        <input id="button_title" class="form-control @error('button_title') is-invalid @enderror" name="button_title" type="text" value="{{ $is_edit ? $banner->button_title : '' }}" >
                        @include('admin.inc.error_message',['name'=>'button_title']) 
                      </div>

                      <div class="form-group">
                        <label for="link">Button Link</label>
                        <input id="link" class="form-control @error('link') is-invalid @enderror" name="link" type="text" value="{{ $is_edit ? $banner->link : '' }}" >
                        @include('admin.inc.error_message',['name'=>'link']) 
                      </div>


                      <div class="form-group">
                        <label for="image">Upload Image</label>
                        <input id="image" class="form-control @error('image') is-invalid @enderror" name="image" type="file">
                        @include('admin.inc.error_message',['name'=>'image'])
                      </div> 


                      <div>
                        @if ($is_edit)
                            <img src="{{ asset('/banner_images/'.$banner->image) }}" style="width:300px;height:200px ">
                        @endif                                        
                      </div>    
<!--                  <div class="form-group">
                        <label for="email">Product Image</label>
                        <div id="fileuploader">Upload</div>
                      </div> -->
                      <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control form-control-lg py-3 @error('status') is-invalid @enderror" id="status" name="status">
                          <option selected disabled="">Select Status</option>
                          <option value="1" @if(@$banner->status == '1') {{'selected'}}@endif>Active</option>
                          <option value="0" @if(@$banner->status == '0'){{'selected'}}@endif>Inactive</option>
                        </select>
                        @include('admin.inc.error_message',['name'=>'status'])
                      </div>

                      <input class="btn btn-primary" type="submit" value="{{$is_edit ? 'Update Banner' : 'Add Banner'}}">
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
@push('styles')
  <style type="text/css">
    .select2-container--default .select2-selection--multiple{
      height: 50px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
      padding: 13px;
      padding-left: 25px;
      font-size: 13px;
      font-weight: 600;
      color:#fff;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
      height:100%;
      color:#fff;
    }
    .select2-container {
      margin-top: 20px;
      width:100%!important;
    }
    .cke_contents{
      height: 80px!important;
    }

  </style>
  
@endpush
@push('scripts')
  <script src="{{asset('admin_assets/js/jquery.min.js')}}"></script>
  <script src="//cdn.ckeditor.com/4.16.2/basic/ckeditor.js"></script>
  <script type="text/javascript">
      jQuery(document).ready(function ($) {
          jQuery('.ckeditor').ckeditor();
      
        jQuery(".js-example-tokenizer").select2({
          tags: true,
          tokenSeparators: [',', ' ']
        });
      });
  </script>
@endpush
