<?php
  if(!function_exists("escape")){
    function escape($value){
      return htmlentities($value,ENT_QUOTES,'UTF-8');
    }
  }
?>
<div id="video-modal" class="modal fade"><!-- video modal fade Starts -->
  <div class="modal-dialog"><!-- modal-dialog Starts -->
    <div class="modal-content"><!-- modal-content Starts -->
      <div class="modal-header"><!-- modal-header Starts -->
        <h5 class="modal-title"> Add Video In Proposal </h5> 
        <button class="close" data-dismiss="modal"> <span> &times; </span> </button>
      </div><!-- modal-header Ends -->
      <div class="modal-body"><!-- modal-body Starts -->
        <div class="row">
          <div class="col-4">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="computer-tab" data-toggle="pill" href="#computer" role="tab">From Computer</a>
              <a class="nav-link" id="embed-tab" data-toggle="pill" href="#embed" role="tab">Embed</a>
            </div>
          </div>
          <div class="col-8">
            <form action="" id="video-form" enctype="multipart/form-data">
              <input type="hidden" name="proposal_id" value="<?= escape($proposal_id); ?>">
              <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="computer" role="tabpanel">
                  Select Video File From Computer
                  <input type="file" name="proposal_file" id="v_file" class="form-control mt-2" accept="video/mp4,video/x-m4v,video/*"/>
                </div>
                <div class="tab-pane fade" id="embed" role="tabpanel">
                  Paste Your Video Embed Code (Vimeo & YouTube)
                  <textarea name="proposal_video" class="form-control mt-2" rows="7"></textarea>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div><!-- modal-body Ends -->
      <div class="modal-footer p-2">
        <button type="submit" form="video-form" class="float-right btn btn-success">Save Changes</button>
      </div>
    </div><!-- modal-content Ends -->
  </div><!-- modal-dialog Ends -->
</div><!-- video modal fade Ends -->