<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <!-- /Search -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
          <span class="avatar-initial" style="border-radius: 50%; background-color: #f0f0f0; padding: 5px; display: inline-flex; justify-content: center; align-items: center; width: 40px; height: 40px;">
            <i class="bx bxs-user" style="font-size: 20px;"></i>
          </span>
          <span class="ms-2 d-none d-md-inline">User</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="{{url('register')}}">
              <i class="mdi mdi-account-plus me-1 mdi-20px"></i>
              <span class="align-middle">Register</span>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#logoutModal">
              <i class="mdi mdi-logout me-1 mdi-20px"></i>
              <span class="align-middle">Log Out</span>
            </a>
          </li>
        </ul>
      </li>
      <!--/ User -->
    </ul>
  </div>
</nav>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-5">
        <div>
          <img src="/images/group.svg" alt="Konfirmasi Logout" style="width: 150px; border-radius: 50%; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        </div>
        <div class="mt-3">
          <i class="fas fa-exclamation-circle fa-5x text-warning"></i>
        </div>
        <h5 class="mt-4"><b>ANDA YAKIN INGIN KELUAR?</b></h5>
      </div>
      <div class="modal-footer d-flex justify-content-center border-0">
        <button type="button" class="btn btn-outline-danger px-5" data-bs-dismiss="modal">TIDAK</button>
        <button type="button" class="btn btn-danger px-5" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">YA</button>
        <form action="{{ route('logout') }}" method="post" id="logout-form">
          @csrf
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Custom Styles -->
<style>
  .navbar {
    border-bottom: 1px solid #ddd;
    padding: 0.5rem 1.25rem;
  }
  .navbar-toggler {
    border: none;
  }
  .navbar-light .navbar-toggler-icon {
    background-color: #333;
  }
  .navbar-nav .nav-link {
    font-size: 1rem;
    color: #333;
    transition: color 0.3s ease;
  }
  .navbar-nav .nav-link:hover {
    color: #007bff;
  }

  /* User dropdown styling */
  .avatar-initial {
    background-color: #007bff;
    color: white;
    font-size: 20px;
  }
  .dropdown-menu {
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  .dropdown-item {
    transition: background-color 0.3s ease;
  }
  .dropdown-item:hover {
    background-color: #f8f9fa;
  }

  /* Modal Styling */
  .modal-content {
    border-radius: 12px;
    border: 1px solid #e2e2e2;
  }
  .btn-danger {
    background-color: #e74c3c;
    border: none;
    transition: background-color 0.3s ease;
  }
  .btn-danger:hover {
    background-color: #c0392b;
  }
  .btn-outline-danger {
    border-color: #e74c3c;
    color: #e74c3c;
    transition: border-color 0.3s, color 0.3s;
  }
  .btn-outline-danger:hover {
    border-color: #c0392b;
    color: #c0392b;
  }
</style>
