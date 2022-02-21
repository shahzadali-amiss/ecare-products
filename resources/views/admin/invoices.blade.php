@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Invoices</h4>
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
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Ship to</th>
                        <th>Purchased Price</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>WD-61</td>
                        <td>Edinburgh</td>
                        <td>New York</td>
                        <td>$3200</td>
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
                        <td>WD-62</td>
                        <td>Doe</td>
                        <td>Brazil</td>
                        <td>$7500</td>
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
                        <td>WD-63</td>
                        <td>Sam</td>
                        <td>Tokyo</td>
                        <td>$6300</td>
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