@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12"> 
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Attribute Values<a href="{{route('add_attribute_values')}}" class="btn btn-inverse-success ms-3"> Add new value </a></h4>
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
                        <th>Attribute Id</th>
                        <th>Attribute</th> 
                        <th>Value</th>
                        <th>Verified</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach($attribute_value as $value)
                    <?php $i+=1; ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$value->attribute_id}}</td>
                        <td>{{getAttribute($value->attribute_id)->name}} of {{getCategory(getAttribute($value->attribute_id)->category_id)->name}}</td>
                        <td>
                          {{$value->value}}
                        </td>
                        <td>

                          @if($value->is_verified == 1)
                          <label class="badge badge-success">
                            {{'Verified'}}
                          </label>
                          @else
                          <label class="badge badge-danger">
                            {{'Not Verified'}}
                          </label> 
                          @endif

                        </td>
                        <td>

                          @if($value->status == 1)
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
                          <a href="{{route('add_attribute_values',$value->id)}}" class="btn btn-light">
                            <i class="ti-eye text-primary"></i>Edit
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