<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
    
      <li class="nav-item nav-category">Main Menu</li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
          <i class="menu-icon typcn typcn-document-text"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

       <li class="nav-item"> 
        <a class="nav-link" href="{{ route('category.index') }}">
          <i class="menu-icon typcn typcn-document-text"></i>
          <span class="menu-title">Category</span>
        </a>
      </li>
       <li class="nav-item"> 
        <a class="nav-link" href="{{ route('brand.index') }}">
          <i class="menu-icon typcn typcn-document-text"></i>
          <span class="menu-title">Brand</span>
        </a>
      </li> 
      <li class="nav-item"> 
        <a class="nav-link" href="{{ route('color.index') }}">
          <i class="menu-icon typcn typcn-document-text"></i>
          <span class="menu-title">Colors</span>
        </a>
      </li>
      <li class="nav-item"> 
        <a class="nav-link" href="{{ route('product.index') }}">
          <i class="menu-icon typcn typcn-document-text"></i>
          <span class="menu-title">Products</span>
        </a>
      </li>
    </ul>
  </nav>