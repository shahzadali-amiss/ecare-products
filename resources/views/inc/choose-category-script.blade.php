<script type="text/javascript">
  jQuery(document).ready(function($){
    $('#grand_category').on('change', function(){
      $('#child_cont').addClass('d-none');
      if($(this).val() != ""){
        var url = '/api/get-category/'+($(this).val())+'/2';
        $.get(url, function(data, status){
          if(data.status==true){
            $('#parent_cont').removeClass('d-none');
            //console.log(data.data);
            bindParentCategory(data.data,'parent_category');
          }    
        });
      }
    });
    $('#child_category').on('change', function(){
      if($(this).val() != ""){
        $('#submit').attr('disabled', false);
      }else{
        $('#submit').attr('disabled', true);
      }
    });

    $('#parent_category').on('change', function(){
      if($(this).val() != ""){
        var url = '/api/get-category/'+($(this).val())+'/3';
        $.get(url, function(data, status){
          if(data.status==true){
            $('#child_cont').removeClass('d-none');
            // console.log(data.data);
            bindParentCategory(data.data,'child_category');
          }    
        });
      }
    });

    function bindParentCategory(data, element){  
      var sel=document.getElementById(element);
      sel.innerText = "";
      var opt = document.createElement('option');
      if(element=='parent_category'){
        opt.innerHTML = 'Select Parent Category';
      }else if(element=='child_category'){
        opt.innerHTML = 'Select Child Category';
      }else{
        opt.innerHTML = 'Select Category';
      }
      opt.value = "";
      // opt.setAttribute('data-display', 'Please Select');
      sel.appendChild(opt);

          //console.log(data.length);
      // ITERATE TO BIND OPTIONS
      for(var i = 0; i < data.length; i++) {
          var opt = document.createElement('option');
          opt.innerHTML = data[i].name;
          opt.value = data[i].id;
          sel.appendChild(opt);
      }
      console.log(sel);
    }
  });
</script>