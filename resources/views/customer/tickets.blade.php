@extends('layouts.user')
@section('content')
<!-- Content  -->
<section class="col-lg-8">
  <!-- Toolbar-->
  <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
    <div class="d-flex align-items-center">
      <label class="d-none d-lg-block fs-sm text-light text-nowrap opacity-75 me-2" for="ticket-sort">Sort tickets:</label>
      <label class="d-lg-none fs-sm text-nowrap opacity-75 me-2" for="ticket-sort">Sort tickets:</label>
      <select class="form-select" id="ticket-sort">
        <option>All</option>
        <option>Open</option>
        <option>Closed</option>
      </select>
    </div><a class="btn btn-primary btn-sm d-none d-lg-inline-block" href="{{ route('logout') }}"><i class="ci-sign-out me-2"></i>Sign out</a>
  </div>
  <!-- Tickets list-->
  <div class="table-responsive fs-md mb-4">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Ticket Subject</th>
          <th>Date Submitted | Updated</th>
          <th>Type</th>
          <th>Priority</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="py-3"><a class="nav-link-style fw-medium" href="{{route('home',['customer','single-ticket'])}}">My new ticket</a></td>
          <td class="py-3">09/27/2019 | 09/30/2019</td>
          <td class="py-3">Website problem</td>
          <td class="py-3"><span class="badge bg-warning m-0">High</span></td>
          <td class="py-3"><span class="badge bg-success m-0">Open</span></td>
        </tr>
        <tr>
          <td class="py-3"><a class="nav-link-style fw-medium" href="{{route('home',['customer','single-ticket'])}}">Another ticket</a></td>
          <td class="py-3">08/21/2019 | 08/23/2019</td>
          <td class="py-3">Partner request</td>
          <td class="py-3"><span class="badge bg-info m-0">Medium</span></td>
          <td class="py-3"><span class="badge bg-secondary m-0">Closed</span></td>
        </tr>
        <tr>
          <td class="py-3"><a class="nav-link-style fw-medium" href="{{route('home',['customer','single-ticket'])}}">Yet another ticket</a></td>
          <td class="py-3">11/19/2018 | 11/20/2018</td>
          <td class="py-3">Complaint</td>
          <td class="py-3"><span class="badge bg-danger m-0">Urgent</span></td>
          <td class="py-3"><span class="badge bg-secondary m-0">Closed</span></td>
        </tr>
        <tr>
          <td class="py-3"><a class="nav-link-style fw-medium" href="{{route('home',['customer','single-ticket'])}}">My old ticket</a></td>
          <td class="py-3">06/19/2018 | 06/20/2018</td>
          <td class="py-3">Info inquiry</td>
          <td class="py-3"><span class="badge bg-success m-0">Low</span></td>
          <td class="py-3"><span class="badge bg-secondary m-0">Closed</span></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="text-end">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#open-ticket">Submit new ticket</button>
  </div>
</section>
@endsection