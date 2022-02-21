@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">All Products <a href="{{route('showProductCategories')}}" class="btn btn-inverse-success ms-3"> Add new product </a></h4>
          <div class="row">
            <div class="col-12">
            <div class="col-12">
              @include('admin.inc.session-message')
            </div>
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
                            Id
                          </th>
                          <th>
                            Image
                          </th>
                          <th>
                            Product name
                          </th>
                          <th>
                            Price
                          </th>
                          <th>
                            Discounted Price
                          </th>
                          <th>
                            Category
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

                        <?php $counter = 0; ?>
                        @foreach($products as $pd)
                        <?php $counter +=1; ?>
                        <tr>
                          <td>{{$counter}}</td>
                          <td class="py-1">
                            <img src="{{asset('product_images/'.$pd->image)}}" alt="image"/>
                          </td>
                          <td>
                            {{ucwords($pd->name)}}
                          </td>
                          <td>
                            &#8377;
                            {{$pd->mrp}}
                          </td>
                          <td>
                            &#8377;
                            {{$pd->offer_price}}
                          </td>
                          <td>
                            @foreach($categories as $ct)
                              @if($ct->id == $pd->category_id)
                                {{ucwords($ct->name)}}
                              @endif 
                            @endforeach  
                          </td>
                          <td>
                                @if($pd->status == 1)
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
                            <a href="{{route('admin-invoice')}}" class="btn btn-light">
                              <i class="ti-eye text-primary"></i>View
                            </a>
                            <a href="{{route('edit_product', $pd->id)}}" class="btn btn-light">
                              <i class="ti-pencil-alt text-warning"></i>Edit
                            </a>
                            <a onclick="return confirm('Are you sure?')" href="{{route('delete_product', $pd->id)}}" class="btn btn-light">
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