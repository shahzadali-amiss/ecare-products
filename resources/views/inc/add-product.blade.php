<div class="pt-2 px-4 ps-lg-0 pe-xl-5">
    <!-- Title-->
    <div class="d-sm-flex flex-wrap justify-content-between align-items-center pb-2">
      <h2 class="h3 py-2 me-2 text-center text-sm-start">Add New Product</h2>
      <div class="py-2 text-center">


        <span class="text-capitalize small">{{ $is_edit ? ucwords(getCategory($product->grand_category_id)->name):ucwords(getCategory(Session::get('grand_category'))->name) }} > {{ $is_edit ? ucwords(getCategory($product->parent_category_id)->name):ucwords(getCategory(Session::get('parent_category'))->name) }} > {{ $is_edit ? ucwords(getCategory($product->category_id)->name):ucwords(getCategory(Session::get('child_category'))->name) }}</span>
      </div>
    </div>
    @include('inc.session-message')
    <form action="{{ route($route_name) }}" method="post" enctype="multipart/form-data">
      @csrf
      
      @if($is_edit)
      <!-- Tabs-->
      <ul class="nav nav-tabs nav-justified" role="tablist">
        <li class="nav-item">
          <a class="nav-link px-0 active" href="#product-details" data-bs-toggle="tab" role="tab">
            <div class="d-none d-lg-block">
              <i class="ci-user opacity-60 me-2"></i>Product Details
            </div>
            <div class="d-lg-none text-center">
              <i class="ci-user opacity-60 d-block fs-xl mb-2"></i>
              <span class="fs-ms">Product Details</span>
            </div>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-0" href="#product-images" data-bs-toggle="tab" role="tab">
            <div class="d-none d-lg-block">
              <i class="ci-image opacity-60 me-2"></i>More Product Images
            </div>
            <div class="d-lg-none text-center">
              <i class="ci-image opacity-60 d-block fs-xl mb-2"></i>
              <span class="fs-ms">More Product Images</span>
            </div>
          </a>
        </li>
      </ul>
      <!-- Tab content-->
      <div class="tab-content">
      @endif
        <!-----Product Details----->
        <div class="tab-pane fade show active" id="product-details" role="tabpanel">

          <h4 class="text-center">Product Details</h4>
          <div class="bg-secondary rounded-3 p-4 mb-4">
            <input type="hidden" name="grand_category" value="{{ $is_edit ? $product->grand_category_id:Session::get('grand_category') }}">
        
            <input type="hidden" name="edit_id" value="{{ $is_edit ? $product->id:'' }}">
            
            <input type="hidden" name="parent_category" value="{{ $is_edit ? $product->parent_category_id:Session::get('parent_category') }}">
            <input type="hidden" name="child_category" value="{{ $is_edit ? $product->category_id:Session::get('child_category') }}">
            
            <div class="mb-3 pb-2">
              <label class="form-label" for="unp-product-name">Product name</label>
              <input class="form-control" type="text" id="unp-product-name" name="name" value="{{ $is_edit ? $product->name:'' }}">
              <div class="form-text"></div>
            </div>
            <div class="row mb-4 px-3">
              <div class="col-md-12 file-drop-area mb-3">
                @if($is_edit)
                <img src="{{asset('/product_images/'.$product->image)}}" class="product-image-edit-view mb-3" style="height: 250px;">
                @endif
                <div class="file-drop-icon ci-cloud-upload"></div>
                <span class="file-drop-message">{{ $is_edit ? 'Drag and drop here to update main product image':'Drag and drop here to upload main product image' }}</span>
                <input class="file-drop-input" type="file" name="file" id="file">
                <button class="file-drop-btn btn btn-primary btn-sm mb-2" type="button">Or select file</button>
                <div class="form-text">1000 x 800px ideal size for hi-res displays</div>

              </div>
            </div>
            <div class="row mb-4">
              <div class="col-sm-6 mb-3">
                <label class="form-label" for="unp-standard-price">MRP Price</label>
                <div class="input-group"><span class="input-group-text"><i class="ci-rupee"></i></span>
                  <input class="form-control" type="text" id="unp-standard-price" name="price" value="{{ $is_edit ? $product->mrp:'' }}">
                </div>
                <div class="form-text">Average marketplace price for this product</div>
              </div>
              <div class="col-sm-6 mb-3">
                <label class="form-label" for="unp-extended-price">Discounted Price</label>
                <div class="input-group"><span class="input-group-text"><i class="ci-rupee"></i></span>
                  <input class="form-control" type="text" id="unp-extended-price" name="dis_price" value="{{ $is_edit ? $product->offer_price:'' }}"> 
                </div>
                <div class="form-text">Discounted price for this product</div>
              </div>


              <!--Attributes and values----------->
              @foreach( $attributes as $attribute )
              <div class="col-sm-6 mb-3">
                
                <label for="{{ strtolower($attribute->name) }}" class="form-label mb-2">{{$attribute->name}}</label>

                
                <select id="multi-{{ strtolower($attribute->name) }}" name="{{strtolower($attribute->name)}}s[]" multiple="multiple">
                  @foreach($attribute->getAttributeValues as $value)
                    <option value="{{$value->id}}">{{$value->value}}</option>
                  @endforeach
                </select>
                <div class="input-cont">
                  
                </div>
                <button type="button" class="btn btn-primary mt-2 add-value" onclick="addValueField(this,'<?php echo strtolower($attribute->name); ?>')">Add Other Color</button>

              </div>
              @endforeach
              <!------>


            </div>
            <div class="mb-4 py-2">
              <label class="form-label" for="unp-product-description">Product description</label>
              <textarea class="form-control" rows="6" id="unp-product-description" name="desc">{{ $is_edit ? $product->description:'' }}</textarea>
              <div class="bg-secondary p-3 fs-ms rounded-bottom"><span class="d-inline-block fw-medium me-2 my-1">Markdown supported:</span><em class="d-inline-block border-end pe-2 me-2 my-1">*Italic*</em><strong class="d-inline-block border-end pe-2 me-2 my-1">**Bold**</strong><span class="d-inline-block border-end pe-2 me-2 my-1">- List item</span><span class="d-inline-block border-end pe-2 me-2 my-1">##Heading##</span><span class="d-inline-block">--- Horizontal rule</span></div>
            </div>
            <div class="mb-4 py-2">
              <label for="grand_category" class="form-label mb-2">Status</label>
              <select class="form-select me-2" name="status">
                  <option value="1" {{ $is_edit && $product->status==true ? 'selected':'' }}>Active</option>
                  <option value="0" {{ $is_edit && $product->status==false ? 'selected':'' }}>Inactive</option>
              </select>
            </div>      
          </div>
        </div>
        @if($is_edit)
        <div class="tab-pane fade" id="product-images" role="tabpanel">
          <h4 class="text-center">More Product Images</h4>
          <div class="bg-secondary rounded-3 p-4 mb-4">

            <div class="table-responsive">
              <table cellpadding="10">
                <thead>
                  <tr>
                    <th width="10%">#</th>
                    <th width="30%" class="text-center">Image</th>
                    <th width="30%">Choose File</th>
                    <th width="30%" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="bg-light">
                    <td>1</td>
                    <td>
                      <img id="output2" style="min-width:100px; width:100px;" src="{{ $image2 ? asset('product_images').'/'.$image2->image : '' }}" />
                    </td>
                    <td>
                      <input type="file" onchange="loadFile(event,'output2')" name="file2">
                    </td>
                    <td>
                      @if($image2)
                      <button type="button" class="form-control" onclick="deleteProductImage(<?php echo $image2->id; ?>)">Delete</button>
                      @else
                      <button type="button" class="form-control" onclick="jQuery(this).parent().parent().find('input[type=file]').val(''); jQuery(this).parent().parent().find('img').attr('src',null);">Reset</button>
                      @endif
                    </td>
                  </tr>
                  <tr class="bg-light">
                    <td>2</td>
                    <td>
                      <img id="output3" style="min-width:100px; width:100px;" src="{{ $image3 ? asset('product_images').'/'.$image3->image : '' }}"/>
                    </td>
                    <td>
                      <input type="file" onchange="loadFile(event,'output3')" name="file3">
                    </td> 
                    <td>
                      @if($image3)
                      <button type="button" class="form-control" onclick="deleteProductImage(<?php echo $image3->id; ?>)">Delete</button>
                      @else
                      <button type="button" class="form-control" onclick="jQuery(this).parent().parent().find('input[type=file]').val(''); jQuery(this).parent().parent().find('img').attr('src',null);">Reset</button>
                      @endif
                    </td>
                  </tr>
                  <tr class="bg-light">
                    <td>3</td>
                    <td>
                      <img id="output4" style="min-width:100px; width:100px;" src="{{ $image4 ? asset('product_images').'/'.$image4->image : '' }}"/>
                    </td>
                    <td>
                      <input type="file" onchange="loadFile(event,'output4')" name="file4">
                    </td>
                    <td>
                      @if($image4)
                      <button type="button" class="form-control" onclick="deleteProductImage(<?php echo $image4->id; ?>)">Delete</button>
                      @else
                      <button type="button" class="form-control" onclick="jQuery(this).parent().parent().find('input[type=file]').val(''); jQuery(this).parent().parent().find('img').attr('src',null);">Reset</button>
                      @endif
                    </td>
                  </tr>
                  <tr class="bg-light">
                    <td>4</td>
                    <td>
                      <img id="output5" style="min-width:100px; width:100px;" src="{{ $image5 ? asset('product_images').'/'.$image5->image : '' }}"/>
                    </td>
                    <td>
                      <input type="file" onchange="loadFile(event, 'output5')" name="file5">
                    </td>
                    <td>
                      @if($image5)
                      <button type="button" class="form-control" onclick="deleteProductImage(<?php echo $image5->id; ?>)">Delete</button>
                      @else
                      <button type="button" class="form-control" onclick="jQuery(this).parent().parent().find('input[type=file]').val(''); jQuery(this).parent().parent().find('img').attr('src',null);">Reset</button>
                      @endif
                    </td>
                  </tr> 
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @endif
      <button class="btn btn-primary d-block w-100" type="submit">
        <i class="ci-cloud-upload fs-lg me-2"></i>{{ $is_edit ? 'Update':'Upload' }} Product
      </button> 
    </form>
  </div>