<!-- Button trigger modal -->
<style>

.carousel-item{


}
.carousel-item img{
    height: 300px;
    width: 300px;
    object-fit: contain;
}
.modal-content{
    background-color: black !important;
}


       
</style>
<!-- Modal -->
<div class="modal  fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content text-white" >
      <div class="modal-header">
        <h5 class="modal-title text-center !text-xl" id="exampleModalLabel">Avatar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body !bg-dark">
        

        {{-- carosel --}}
         <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
          <div class="carousel-inner">
              @php
                // Sort avatars: current first
                $sortedAvatars = $avatars->sortByDesc('is_current')->values();
            @endphp

            @foreach ($sortedAvatars as $index => $avatar)
              <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ asset('uploads/user/' . $avatar->filename) }}" class="d-block w-100" alt="Avatar {{ $index + 1 }}">
              </div>
            @endforeach
          
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
      




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button  type="button"id="downloadBtn" onclick="downloadActiveImage()" class="btn btn-primary">Downlow</button>
      


      </div>
    </div>
  </div>
</div>