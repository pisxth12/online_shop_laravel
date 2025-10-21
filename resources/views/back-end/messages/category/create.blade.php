<div class="modal fade" id="modalCreateCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog mx-auto d-flex" style="max-width:40%; min-width: 300px;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Creating Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form method="POST" class="formCreateCategory" enctype="multipart/form-data">
          @csrf

          <!-- Category Name -->
          <div class="form-group mb-3">

            <label for="">Category Name</label>
            <input type="text" name="name" class="name form-control" placeholder="Enter category name">
            <p></p>
          </div>

          <!-- Image Upload -->
          <div class="form-group mb-3">
            <label class="form-label fw-medium">Image</label>
            <div class=" align-items-center gap-2 position-relative">
              <div class="d-flex justify-between image">
                <input type="file" name="image" class="image form-control ">
                <button type="button" onclick="UploadImage('.formCreateCategory')"
                  class="btn btn-success btn_upload">Upload</button>
              </div>
              <p class=" "></p>


            </div>

          </div>
          <div class="show-image-category">

          </div>


          <!-- Image Preview -->
          <div class="image_upload text-center mb-3">
            <img id="preview" src="" alt="" style="max-width: 100%; display:none; border-radius:8px;">
          </div>

          <!-- Status -->
          <div class="form-group mb-3">
            <label for="">Status</label>
            <select name="status" class="status form-control">
              <option value="1">Active</option>
              <option value="0">Block</option>
            </select>
            <p class="text-danger flex-grow-1 mt-2"></p>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="StoreCatecory('.formCreateCategory')" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>