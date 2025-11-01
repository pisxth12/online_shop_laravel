<div class="modal fade" id="modalEditCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mx-auto d-flex" style="max-width:40%; min-width: 300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" class="formUpdateCategory" id="formUpdateCategory" enctype="multipart/form-data">
                    @csrf

                    <!-- Category Name -->
                    <div class="form-group mb-3">
                        <input type="hidden" value="category_id" id="category_id" name="category_id" >
                        <label for="">Category Name</label>
                        <input type="text" name="name"  class="name_edit form-control" placeholder="Enter category name">
                        <p></p>
                    </div>


                    <div class="form-group mb-3">
                        <label for="">Category title</label>
                        <input type="text" name="title" class="title_edit form-control" placeholder="Enter category title">
                        <p></p>
                    </div>


                    <!-- Image Upload -->
                    <div class="form-group mb-3">
                        <label class="form-label fw-medium">Image</label>
                        <div class=" align-items-center gap-2 position-relative">
                            <div class="d-flex justify-between image">
                                <input type="file" name="image" class="image form-control ">
                                <button type="button" onclick="UploadImage('.formUpdateCategory')"
                                    class="btn btn-success btn_upload">Upload</button>
                            </div>
                            <p class=" "></p>
                        </div>
                    </div>

                    {{-- preview image --}}
                    <div class="show-image-category_edit show-image-category ">
                        
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
                <button type="button" onclick="UpdateCategory('.formUpdateCategory')" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>