@extends('layouts.admin')
@section('content')          
<div class="content-wrapper">
  <div class="row">
    <div class="col-12"> 
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Payments</h4>
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
                        <th>User</th> 
                        <th>Payment Id</th> 
                        <th>Transaction Id</th> 
                        <th>Payment Type</th> 
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach($payments as $payment)
                    <?php $i+=1; ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{ucwords(getUserById($payment->user_id)->name)}}({{$payment->user_id}})</td>
                        <td>{{$payment->pmt_id}}</td>
                        <td>{{$payment->txn_id}}</td>
                        <td>{{ucwords($payment->pmt_type)}}</td>
                        <td>₹{{$payment->amount}}</td>
                        <td>
                          @if($payment->status == 1)
                          <label class="badge badge-success">
                            {{'Successful'}}
                          </label>
                          @else
                            @if($payment->pmt_type=='cash')
                              <label class="badge badge-warning">
                                {{'Pending'}}
                              </label> 
                            @else
                              <label class="badge badge-danger">
                                {{'Unsuccessful'}}
                              </label> 
                            @endif
                          @endif                         
                        </td>
                        <!-- <td class="text-right">
                          <a href="" class="btn btn-light">
                            <i class="ti-close text-danger"></i>Remove
                          </a>
                        </td> -->
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
@endsection