@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Customers <a href="{{route('admin-add-user')}}" class="btn btn-inverse-success ms-3"> Add new customer </a></h4>
          <div class="row grid-margin">
            <div class="col-12">
              <div class="alert alert-warning" role="alert">
                  <strong>Heads up!</strong> This alert needs your attention, but it's not super important.
              </div>
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
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>1</td>
                        <td>Testing</td>
                        <td>testing@gmail.com</td>
                        <td>
                          <label class="badge badge-success">Active</label>
                        </td>
                        <td class="text-right">
                          <a href="{{route('admin-invoice')}}" class="btn btn-light">
                            <i class="ti-eye text-primary"></i>View
                          </a>
                          <button class="btn btn-light">
                            <i class="ti-close text-danger"></i>Remove
                          </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Testing2</td>
                        <td>testing2@gmail.com</td>
                        <td>
                          <label class="badge badge-danger">Inactive</label>
                        </td>
                        <td class="text-right">
                          <a href="{{route('admin-invoice')}}" class="btn btn-light">
                            <i class="ti-eye text-primary"></i>View
                          </a>
                          <button class="btn btn-light">
                            <i class="ti-close text-danger"></i>Remove
                          </button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Testing3</td>
                        <td>testing3@gmail.com</td>
                        <td>
                          <label class="badge badge-success">Active</label>
                        </td>
                        <td class="text-right">
                          <a href="{{route('admin-invoice')}}" class="btn btn-light">
                            <i class="ti-eye text-primary"></i>View
                          </a>
                          <button class="btn btn-light">
                            <i class="ti-close text-danger"></i>Remove
                          </button>
                        </td>
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