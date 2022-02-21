@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  {{-- <div class="row">
    <div class="col-12">  
      <div class="card"> 
        <div class="card-body">
          <h4 class="card-title">{{$is_edit ? 'Edit Product' : 'Add New Product'}}</h4>
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
                  <form class="cmxform" id="add-product-form" method="post" action="{{ route('add_product',[$category, $is_edit]) }}" enctype="multipart/form-data">
                    @csrf
                    <fieldset> 
                    @if($is_edit)
                      <input type="hidden" name="edit_id" value="{{$product->id}}"> 
                    @else  
                      <input type="hidden" name="category" value="{{$category}}"> 
                      <input type="hidden" name="role_id" value=""> 
                    @endif  


                      <div class="form-group">
                        <label for="name">Product Name</label>
                        <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" type="text" value="{{ $is_edit ? $product->name : '' }}" >
                        @include('admin.inc.error_message',['name'=>'name']) 
                      </div>

                      @foreach($attributes as $key => $attribute)
                      <div class="form-group">
                        <div class="">
                          <div class="row">
                            <label for="{{ $attribute->name }}-attribute" id="">{{ ucwords($attribute->name) }} Attribute</label>
                            <select class="js-example-tokenizer w-100" multiple="multiple" id="{{ $attribute->name }}-attribute" name="{{ strtolower($attribute->name) }}_attribute_values[]">
                              @foreach($attribute->getAttributeValues as $data){
                                <option value="{{$data->id}}">{{ $data->value }}</option>
                              @endforeach

                            </select>
                          </div>
                        </div>
                      </div>
                      @endforeach

                      <div class="form-group">
                        <label for="price">Price</label>
                        <input id="price" class="form-control @error('price') is-invalid @enderror" name="price" type="number" min="0" value="{{ $is_edit ? $product->mrp : '' }}">
                        @include('admin.inc.error_message',['name'=>'price'])
                      </div>


                      <div class="form-group">
                        <label for="dis_price">Discounted Price</label>
                        <input id="dis_price" class="form-control @error('dis_price') is-invalid @enderror" name="dis_price" type="number" min="0" value="{{ $is_edit ? $product->offer_price : '' }}">
                        @include('admin.inc.error_message',['name'=>'dis_price'])
                      </div>


                      <div class="form-group">
                        <label for="price">Upload Image</label>
                        <input id="price" class="form-control @error('image') is-invalid @enderror" name="image" type="file" min="0" value="{{ $is_edit ? asset('/product_images/'.$product->image) : null}}">
                        @include('admin.inc.error_message',['name'=>'image'])
                      </div> 


                      <div>
                        @if ($is_edit)
                            <img src="{{ asset('/product_images/'.$product->image) }}" style="width:300px;height:200px ">
                        @endif                                        
                      </div>    
                      <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control form-control-lg py-3 @error('status') is-invalid @enderror" id="status" name="status">
                          <option selected disabled="">Select Status</option>
                          <option value="1" @if(@$product->status == '1') {{'selected'}}@endif>Active</option>
                          <option value="0" @if(@$product->status == '0'){{'selected'}}@endif>Inactive</option>
                        </select>
                        @include('admin.inc.error_message',['name'=>'status'])
                      </div>

                      <input class="btn btn-primary" type="submit" value="{{$is_edit ? 'Update' : 'Add Product'}}">
                    </fieldset>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
  @include('inc.add-product',['route_name'=>'add_product'])
</div>
@endsection
 @push('styles')
  <style type="text/css">
    /*.select2-container--default .select2-selection--multiple{
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
    }*/
    .bg-secondary{
      background-color: #f6f9fc !important;
    }
    .file-drop-area {
        position: relative;
        padding: 2rem 1rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        border: 2px dashed #dae1e7;
        background-color: #fff;
        text-align: center;
        cursor: pointer;
    }
    .file-drop-area .file-drop-icon {
    display: block;
    margin-bottom: 0.75rem;
    color: #aeb4be;
    font-size: 1.625rem;
    }
    .file-drop-area .file-drop-message {
    display: block;
    font-size: .875rem;
    margin-bottom: 1.25rem;
    }
    .file-drop-area .file-drop-input {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: transparent;
    opacity: 0;
    outline: none;
    cursor: pointer;
    z-index: 2;
    }
    .file-drop-area .btn {
        position: relative;
        z-index: 3;
    }
    .file-drop-area .file-drop-preview {
    max-width: 16rem;
    margin-right: auto;
    margin-bottom: 0.75rem;
    margin-left: auto;
    }
    .file-drop-area .file-drop-preview img{
      max-width: 100%;
    }
  </style>
  
@endpush
@push('scripts')
  <script type="text/javascript" src="{{asset('js/theme.min.js')}}"></script>
  <!-- <script type="text/javascript">
    $(document).ready(function(){
      $(".js-example-tokenizer").select2({
        tags: true,
        tokenSeparators: [',', ' ']
      });
    });
  </script> -->
@endpush


@include('inc.add-product-scripts')