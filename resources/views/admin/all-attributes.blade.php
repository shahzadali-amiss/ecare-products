@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12"> 
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Attributes<a href="{{route('add_attribute')}}" class="btn btn-inverse-success ms-3"> Add new attribute </a></h4>
          <div class="row grid-margin">
            <div class="col-12">
              
              @if(Session::has('msg'))
              <div class="alert alert-success" role="alert">
                  {{Session::get('msg')}}
              </div> 
              @endif
              
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
                        <th>Values</th>
                        <th>Child Category</th>
                        <!-- <th>Status</th> -->
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach($attributes as $attribute)
                    <?php $i+=1; ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$attribute->name}}</td>
                        <td>
                          @foreach($attribute_value as $av)
                            @if($av->attribute_id == $attribute->id)
                              {{ucwords($av->value)}},
                            @endif
                          @endforeach    
                        </td>
                        <td>
                          {{$attribute->cat_name }}
<!--                         </td>
                        <td>
                          @if($attribute->Status == 1)
                          <label class="badge badge-success">
                            {{'Active'}}
                          </label>
                          @else
                          <label class="badge badge-danger">
                            {{'Inactive'}}
                          </label> 
                          @endif                          -->
                        </td>
                        <td class="text-right">
                          <a href="{{route('add_attribute',$attribute->id)}}" class="btn btn-light">
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