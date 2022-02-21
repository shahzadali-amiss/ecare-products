function deleteimage(ele,image){
     var url = '/api/deleteProductImage/'+(image);
      $.get(url, function(data, status){
        console.log(data);
        ele.classList.add('d-none');
        //data2=data.data;
        //bindSelect3('mydynamic', data2);
        // bindSelect('attr1', data);
        // console.log(data.length);
    }); 
}