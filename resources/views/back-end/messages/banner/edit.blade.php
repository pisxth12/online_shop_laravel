<div class="modal fade" id="modalUpdateBanner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mx-auto d-flex" style="max-width:40%; min-width: 300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Banner</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" class="formUpdateBanner" id="formUpdateBanner" enctype="multipart/form-data">

                    @csrf
                   <div class="form-group mb-3">
                    <input type="hidden" name="banner_id" id="banner_id">
                                <label class="form-label fw-medium">Image</label>
                                <div class=" align-items-center gap-2 position-relative">
                                <div class="d-flex justify-between image">
                                    <input type="file" name="image" class="image form-control ">
                                    <button type="button" onclick="UploadImage('.formUpdateBanner')"
                                    class="btn btn-success btn_upload">Upload</button>
                                </div>
                                <p class=" "></p>
                                </div>
                            </div>
                               <div class="banner_preview show-image-banner_edit" id="banner_preview">
                        </div>

                     <div class="form-group mb-3">
                        <label for="">Banner</label>
                        <input type="text" name="title" class="title_edit form-control" placeholder="Enter Banner title">
                        <p></p>
                    </div>

                    <!-- Status -->
                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <select name="status" class="status_edit form-control">
                            <option value="1">Active</option>
                            <option value="0">Block</option>
                        </select>
                        <p class="text-danger flex-grow-1 mt-2"></p>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="UpdateBanner('.formUpdateBanner')" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>