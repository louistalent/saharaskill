function alert_success(text,url){
  swal({
    type: 'success',
    timer : 3000,
    text: text,
    onOpen: function(){
      swal.showLoading()
    }
  }).then(function(){
    if(url != ""){
  		window.open(url,'_self');
  	}
  });
}