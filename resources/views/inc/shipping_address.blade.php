<div class="woocommerce-billing-fields__field-wrapper">
  <p class="form-row form-row-wide address-field validate-required" id="billing_address_1_field" data-priority="50">
    <label for="billing_address_1" class="">Street address&nbsp; <abbr class="required" title="required">*</abbr>
    </label>
    <span class="woocommerce-input-wrapper">
      <input type="text" class="input-text" required name="house" id="billing_address_1" placeholder="House number and street name" value="{{ $address ? $address->house : '' }}" autocomplete="address-line1" />
    </span>
  </p>
  <p class="form-row form-row-wide address-field" id="billing_address_2_field" data-priority="60">
    <label for="billing_address_2" class="screen-reader-text">Apartment, suite, unit, etc.&nbsp; <span class="optional">(optional)</span>
    </label>
    <span class="woocommerce-input-wrapper">
      <input type="text" class="input-text " name="apartment" id="billing_address_2" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ $address ? $address->apartment : '' }}" autocomplete="address-line2" />
    </span>
  </p>
  <p class="form-row form-row-wide address-field validate-required">
    <label for="billing_city" class="">State</label>
    <span class="woocommerce-input-wrapper">
      <input type="text" class="input-text" name="state" placeholder="" value="{{ $address ? $address->state : '' }}" />
    </span>
  </p>
  <p class="form-row form-row-wide address-field validate-required" id="billing_city_field" data-priority="70">
    <label for="billing_city" class="">Town / City&nbsp; <abbr class="required" title="required">*</abbr>
    </label>
    <span class="woocommerce-input-wrapper">
      <input type="text" class="input-text " name="city" id="billing_city" placeholder="" value="{{ $address ? $address->city : '' }}" required autocomplete="address-level2" />
    </span>
  </p>
  <!-- <p class="form-row form-row-wide address-field validate-state" id="billing_state_field" data-priority="80">
    <label for="billing_state" class="">County&nbsp; <span class="optional">(optional)</span>
    </label>
    <span class="woocommerce-input-wrapper">
      <input type="text" class="input-text" value="" placeholder="" name="billing_state" id="billing_state" autocomplete="address-level1" data-input-classes="" />
    </span>
  </p> -->
  <p class="form-row form-row-wide address-field validate-required validate-postcode" id="billing_postcode_field" data-priority="90">
    <label for="billing_postcode" class="">Pincode&nbsp; <abbr class="required" title="required">*</abbr>
    </label>
    <span class="woocommerce-input-wrapper">
      <input type="text" class="input-text " name="pincode" id="billing_postcode" placeholder="" value="{{ $address ? $address->pincode : '' }}" required autocomplete="postal-code" />
    </span>
  </p>
  <p class="form-row form-row-wide address-field validate-required">
    <label class="">Landmark&nbsp; <span class="optional">(optional)</span>
    </label>
    <span class="woocommerce-input-wrapper">
      <input type="text" class="input-text" name="landmark" placeholder="" value="{{ $address ? $address->landmark : '' }}" autocomplete="address-level2" />
    </span>
  </p>
  <p class="form-row form-row-wide validate-required validate-phone" id="billing_phone_field" data-priority="100">
    <label for="billing_phone" class="">Phone&nbsp; <abbr class="required" title="required">*</abbr>
    </label>
    <span class="woocommerce-input-wrapper">
      <input type="tel" class="input-text" required name="phone" id="billing_phone" placeholder="" value="{{ $address ? $address->phone : '' }}" autocomplete="tel" />
    </span>
  </p>
</div>