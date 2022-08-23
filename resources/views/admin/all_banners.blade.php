@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12"> 
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">All Banners <a href="{{ route('add_ad_banner') }}" class="btn btn-primary ms-3"> Add New Banner </a></h4>
          <div class="row">
            <div class="col-12">
              <div class="col-12">
               @include('admin.inc.session-message')
              </div>
              <div class="table-responsive">
                <table id="order-listing" class="table">
                  <thead>
                    <tr class="bg-primary text-white">
                        <th>#</th>
                        <th>Image</th> 
                        <th>Title</th> 
                        <th>Sub Title</th>
                        <th>Tagline</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($banners as $key => $banner)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><img src='{{ asset("banner_images/$banner->image") }}'></td>
                        <td>{{ ucwords($banner->title) }} </td>
                        <td>{{ ucwords($banner->subtitle) }} </td>
                        <td>{{ ucwords($banner->tagline) }} </td>
                        <td>
                          @if($banner->status == 1)
                          <label class="badge badge-success">
                            {{'Active'}}
                          </label>
                          @else
                          <label class="badge badge-danger">
                            {{'Inactive'}}
                          </label> 
                          @endif                         
                        </td>
                        <td class="text-right">
                          <a href="{{ route('add_ad_banner', $banner->id) }}" class="btn btn-light">
                            <i class="ti-pencil-alt text-warning"></i>Edit
                          </a>
                          <a onclick="return confirm('Are you sure?')" href="{{route('admin-remove', ['type'=>'b', 'id'=>$banner->id])}}" class="btn btn-light">
                              <i class="ti-close text-danger"></i>Remove
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tr>
                  </tbody>
                </table>
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
  /**/
</style>
@endpush