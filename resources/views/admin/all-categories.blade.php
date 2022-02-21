@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">All Categories <a href="{{route('add_category')}}" class="btn btn-primary ms-3"> Add new category </a></h4>
          <div class="row">
            <div class="col-12">
              @if(Session::has('msg'))
              <div class="alert alert-success" role="alert">
                  {{Session::get('msg')}}
              </div> 
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="order-listing">
                      <thead>
                        <tr>
                          <th>
                            S.N.
                          </th>
                          <th>
                            Category ID
                          </th>
                          <th>
                            Category name
                          </th>
                          <th>
                            Category Type
                          </th>
                          <th>
                            Parent ID
                          </th>                          
                          <th>
                            Status
                          </th>
                          <th>
                            Actions
                          </th>
                        </tr>
                      </thead> 
                      <tbody>   
                      @foreach($categories as $count=>$category)
                        <tr>
                          <td>{{$count+1}}</td>                          
                          <td> {{$category->id}} </td>

                          <td>
                            {{ucwords($category->name)}}
                          </td>
                          <td>
                            @if($category->category_type == 1)
                              {{'Grand'}}
                            @elseif($category->category_type == 2)
                              {{'Parent'}}
                            @elseif($category->category_type == 3)
                              {{'Child'}}
                            @endif                            
                          </td>
                          <td>
                            @foreach($categories as $ct)
                              @if($ct->id == $category->parent_id)
                                {{ucwords($ct->name)}},({{$category->parent_id}})
                              @endif
                            @endforeach       
                          </td>
                          <td>                           
                              @if($category->status == 0)
                              <label class="badge badge-danger">
                              {{'Inactive'}}
                              </label>
                              @else
                              <label class="badge badge-success">
                              {{'Active'}}
                              </label>
                              @endif                          
                          </td>
                          <td class="text-right">

                            <a href="{{route('add_category', $category->id)}}" class="btn btn-light">
                              <i class="ti-pencil-alt text-warning"></i>Edit
                            </a>
                            <a onclick="return confirm('Are you sure?')" href="{{route('admin-remove', ['type'=>'c', 'id'=>$category->id])}}" class="btn btn-light">
                              <i class="ti-close text-danger"></i>Remove
                            </a>
                          </td>
                        </tr>
                        @endforeach

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
  </div>
</div>
@endsection