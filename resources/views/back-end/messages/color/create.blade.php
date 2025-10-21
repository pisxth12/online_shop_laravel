<div class="modal fade" id="modalCreateColor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mx-auto d-flex " style="max-width:40%; min-width: 300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Creating Color</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" class="formCreateColor" enctype="multipart/form-data">

                    <!-- Color Name -->
                    <div class="form-group mb-3">
                        <label for="">Color Name</label>
                        <input type="text" name="name" class="name form-control" placeholder="Enter Color name">
                        <p></p>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Color</label>
                        <input type="color" name="color" class="name form-control" placeholder="Enter Color name">
                        <p></p>
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
                <button type="button" onclick="ColorStore('.formCreateColor')" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>