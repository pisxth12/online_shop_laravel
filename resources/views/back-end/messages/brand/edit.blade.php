<div class="modal fade" id="modalUpdateBrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mx-auto d-flex" style="max-width:40%; min-width: 300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" class="formUpdateBrand" id="formUpdateBrand" enctype="multipart/form-data">

                    <!-- Category Name -->
                    <div class="form-group mb-3">
                        <input type="hidden" value="brand_id" id="brand_id" name="brand_id">
                        <label for="">Brand Name</label>
                        <input type="text" name="name"  class="name_brand name_edit form-control" placeholder="Enter Brand name">
                        <p></p>
                    </div>

                    
                    <div class="form-group mb-3">
                        <label for="">Category</label>
                        <select name="category" class="category form-control">
                            @foreach ($categories as $category )
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-danger flex-grow-1 mt-2"></p>
                    </div>

                            

                    <!-- Status -->
                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <select name="status" class="status_update form-control">
                            <option value="1">Active</option>
                            <option value="0">Block</option>
                        </select>
                        <p class="text-danger flex-grow-1 mt-2"></p>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="BrandUpdate('.formUpdateBrand')" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>