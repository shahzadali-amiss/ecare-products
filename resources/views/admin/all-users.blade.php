@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12"> 
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">All {{$type}}s <a href="{{route('admin-add-user', strtolower($type))}}" class="btn btn-inverse-success ms-3"> Add new {{$type}} </a></h4>
          <div class="row grid-margin">
            <div class="col-12">
              @include('admin.inc.session-message')
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="order-listing" class="table">
                  <thead>
                    <tr class="bg-primary text-white">
                        <th>#</th>
                        <th>Name</th> 
                        <th>Mobile</th> 
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach($users as $user)
                    <?php $i+=1; ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{ucwords($user->name)}}</td>
                        <td>{{$user->mobile}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if($user->role == 'c')
                            {{'Customer'}}
                            @elseif($user->role == 's')
                            {{'Supplier'}} 
                            @elseif($user->role == 'a')
                            {{'Admin'}} 
                            @endif
                        </td>
                        <td>
                          @if($user->status == 1)
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
                          <a href="{{route('admin-view-user', $user->id)}}" class="btn btn-light">
                            <i class="ti-eye text-info"></i>View
                          </a>
                          <a href="{{route('admin-edit-user', [strtolower($type), $user->id])}}" class="btn btn-light">
                            <i class="ti-pencil-alt text-warning"></i>Edit
                          </a>
                          <a href="" class="btn btn-light">
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