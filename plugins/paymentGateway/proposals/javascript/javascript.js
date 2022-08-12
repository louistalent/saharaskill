$(document).ready(function(){
  $("#video-form").on('submit', function(event){
    event.preventDefault();
    var form_data = new FormData(this);
    $.ajax({
      method: "POST",
      url: "../plugins/paymentGateway/proposals/save_video",
      data: form_data,
      async: false,cache: false,contentType: false,processData: false
    }).done(function(data){
      if(data=="Your File Format Extension Is Not Supported."){
        alert(data);
      }else{
        $("#v_file").val(data);
        span = $("span.chose");
        span.removeClass('chose').html("<i class='fa fa-video-camera fa-2x mb-2'></i><br><span class='text-success font-weight-bold'>Video Added Successfully</span> <br><span class='delete-video text-danger' href='#'>Remove Video</span> <i class='fa fa-trash fa-2x delete-video'></i>");
        $('#video-form')[0].reset();
        $("#video-modal").modal("hide");
        alert("Video saved successfully.");
        $(".add-video").addClass("video-added").removeClass("add-video");
      }
    });
  });
});