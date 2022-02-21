@extends('layouts.user')
@section('content')
<!-- Content  -->
    <section class="col-lg-8">
        <!-- Toolbar-->
        <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
          <h6 class="fs-base text-light mb-0">Primary payment method is used by default</h6><a class="btn btn-primary btn-sm" href="{{ route('logout') }}"><i class="ci-sign-out me-2"></i>Sign out</a>
        </div>
        <!-- Payment methods list-->
        <div class="table-responsive fs-md mb-4">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th>Your credit / debit cards</th>
                <th>Name on card</th>
                <th>Expires on</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="py-3 align-middle">
                  <div class="d-flex align-items-center"><img src="{{asset('img/card-visa.png')}}" width="39" alt="Visa">
                    <div class="ps-2"><span class="fw-medium text-heading me-1">Visa</span>ending in 4999<span class="align-middle badge bg-info ms-2">Primary</span></div>
                  </div>
                </td>
                <td class="py-3 align-middle">Susan Gardner</td>
                <td class="py-3 align-middle">08 / 2019</td>
                <td class="py-3 align-middle"><a class="nav-link-style me-2" href="#" data-bs-toggle="tooltip" title="Edit"><i class="ci-edit"></i></a><a class="nav-link-style text-danger" href="#" data-bs-toggle="tooltip" title="Remove">
                    <div class="ci-trash"></div></a></td>
              </tr>
              <tr>
                <td class="py-3 align-middle">
                  <div class="d-flex align-items-center"><img src="{{asset('img/card-master.png')}}" width="39" alt="MesterCard">
                    <div class="ps-2"><span class="fw-medium text-heading me-1">MasterCard</span>ending in 0015</div>
                  </div>
                </td>
                <td class="py-3 align-middle">Susan Gardner</td>
                <td class="py-3 align-middle">11 / 2021</td>
                <td class="py-3 align-middle"><a class="nav-link-style me-2" href="#" data-bs-toggle="tooltip" title="Edit"><i class="ci-edit"></i></a><a class="nav-link-style text-danger" href="#" data-bs-toggle="tooltip" title="Remove">
                    <div class="ci-trash"></div></a></td>
              </tr>
              <tr>
                <td class="py-3 align-middle">
                  <div class="d-flex align-items-center"><img src="{{asset('img/card-paypal.png')}}" width="39" alt="PayPal">
                    <div class="ps-2"><span class="fw-medium text-heading me-1">PayPal</span>s.gardner@example.com</div>
                  </div>
                </td>
                <td class="py-3 align-middle">&mdash;</td>
                <td class="py-3 align-middle">&mdash;</td>
                <td class="py-3 align-middle"><a class="nav-link-style me-2" href="#" data-bs-toggle="tooltip" title="Edit"><i class="ci-edit"></i></a><a class="nav-link-style text-danger" href="#" data-bs-toggle="tooltip" title="Remove">
                    <div class="ci-trash"></div></a></td>
              </tr>
              <tr>
                <td class="py-3 align-middle">
                  <div class="d-flex align-items-center"><img src="{{asset('img/card-visa.png')}}" width="39" alt="Visa">
                    <div class="ps-2"><span class="fw-medium text-heading me-1">Visa</span>ending in 6073</div>
                  </div>
                </td>
                <td class="py-3 align-middle">Susan Gardner</td>
                <td class="py-3 align-middle">09 / 2021</td>
                <td class="py-3 align-middle"><a class="nav-link-style me-2" href="#" data-bs-toggle="tooltip" title="Edit"><i class="ci-edit"></i></a><a class="nav-link-style text-danger" href="#" data-bs-toggle="tooltip" title="Remove">
                    <div class="ci-trash"></div></a></td>
              </tr>
              <tr>
                <td class="py-3 align-middle">
                  <div class="d-flex align-items-center"><img src="{{asset('img/card-visa.png')}}" width="39" alt="Visa">
                    <div class="ps-2"><span class="fw-medium text-heading me-1">Visa</span>ending in 9791</div>
                  </div>
                </td>
                <td class="py-3 align-middle">Susan Gardner</td>
                <td class="py-3 align-middle">05 / 2021</td>
                <td class="py-3 align-middle"><a class="nav-link-style me-2" href="#" data-bs-toggle="tooltip" title="Edit"><i class="ci-edit"></i></a><a class="nav-link-style text-danger" href="#" data-bs-toggle="tooltip" title="Remove">
                    <div class="ci-trash"></div></a></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="text-sm-end"><a class="btn btn-primary" href="#add-payment" data-bs-toggle="modal">Add payment method</a></div>
      </section>
    </div>
  </div>
</main>
@endsection