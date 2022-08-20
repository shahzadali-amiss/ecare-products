
<!-- Content-->

  <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
    <!-- Title-->
    <div class="d-sm-flex flex-wrap justify-content-between align-items-center pb-2">
      <h2 class="h3 py-2 me-2 text-center text-sm-start">Add New Product</h2>
    </div>
    @include('inc.session-message')
    <form action="{{ route($route_name) }}" method="post">
      @csrf
      <div class="row py-5 justify-content-center">
        <div class="col-lg-10 mb-5">
          <label for="grand_category" class="mb-2 fw-bold">Select Grand Category</label>
          <select class="form-select me-2" id="grand_category" name="grand_category">
            <option value="">Select grand category</option>
            @foreach($grands as $grand)
              <option value="{{ $grand->id }}">{{ ucwords($grand->name) }}</option>
            @endforeach
          </select>
        </div>
       {{--  <div class="col-lg-10 mb-5 d-none" id="parent_cont">
          <label for="parent_category" class="mb-2 fw-bold">Select Parent Category</label>
          <select class="form-select me-2 text-capitalize" id="parent_category" name="parent_category">
            <option value="">Select Parent Category</option>
          </select>
        </div>
        <div class="col-lg-10 mb-5 d-none" id="child_cont">
          <label for="child_category" class="mb-2 fw-bold">Select Child Category</label>
          <select class="form-select me-2 text-capitalize" id="child_category" name="child_category">
            <option value="">Select Child Category</option>
          </select>
        </div> --}}
        <button class="btn btn-primary d-block m-auto w-50" type="submit" id="submit">Next</button>
      </div>
    </form>
  </div>

