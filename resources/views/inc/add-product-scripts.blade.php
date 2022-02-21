
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/easySelectStyle.css') }}">
<style type="text/css">
  .add-value{
    font-size: 10px!important;
    padding: 5px 10px!important;
  }
  .easySelect{
    height:44px;
  }

  .styledSelect{
    padding:.625rem 1rem;
  }

  .styledSelect:after{
    top:19px;
  }

  .clearSelectfromDiv{
    top:5px;
  }

  .single-input{
    position: relative;
  }

  .single-input span{
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-weight: bold;
    z-index: 99999;
    cursor: pointer;
  }

</style>
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('js/easySelect.js') }}"></script>
  <script type="text/javascript">
    var loadFile = function(event, bindId) {
      var image = document.getElementById(bindId);
      image.src = URL.createObjectURL(event.target.files[0]);
    };
    function deleteProductImage(imageId){
      alert(imageId);
      var url = '/api/delete-product-image/'+(imageId);
      $.get(url, function(data, status){
        console.log(data);  
      });
    }

    jQuery(document).ready(function($){
      <?php foreach ( $attributes as $attribute) { ?>
             
        $("#<?php echo 'multi-'.strtolower($attribute->name);  ?>").easySelect({
            showEachItem:true,
        });
      <?php } ?>

      
    });
    function deleteValueField(span,fieldName){

      span.parentNode.remove();
      var element=querySelectorAll('.single-input');
      var len=element.length;
      for (var i = 0; i < len; i++) {
        element[i].querySelector('input').setAttribute('name',fieldName+'['+parseInt(i+1)+']');
      }
    }
    
    function addValueField(ele, fieldName){
      var element=ele.parentNode.querySelectorAll('.single-input');
      var len=element.length;
      for (var i = 0; i < len; i++) {
        element[i].querySelector('input').setAttribute('name',fieldName+'['+parseInt(i+1)+']');
      }
      // var input='<input type="text" name="'+fieldName+parseInt(len+1)+'" class="form-control mt-2 attr-field">';
      var box=document.createElement('div');
      box.setAttribute('class','single-input');
      var input=document.createElement('input');
      input.setAttribute('type','text');
      input.setAttribute('name',fieldName+'['+parseInt(len+1)+']');
      input.setAttribute('class','form-control mt-2');
      box.append(input);
      var cut=document.createElement('span');
      cut.innerHTML='x';
      cut.setAttribute('onclick',"deleteValueField(this,'"+fieldName+"')");
      box.append(cut);
      ele.parentNode.querySelector('.input-cont').append(box);
      // ele.parentNode.append('<input type="text" name="'+fieldName+parseInt(len+1)+'" class="form-control mt-2 attr-field">'); 
    }


  </script>
@endpush