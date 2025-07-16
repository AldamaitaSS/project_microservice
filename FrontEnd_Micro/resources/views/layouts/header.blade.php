<style>
  .main-header {
      background: linear-gradient(to right, #ffffff, #f9f9f9);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      border-bottom: none;
      padding: 10px 20px;
      position: sticky;
      top: 0;
      z-index: 999;
  }

  .main-header .navbar-nav {
      display: flex;
      align-items: center;
  }

  .main-header .nav-item {
      margin-left: 10px;
      margin-right: 10px;
  }

  .main-header .nav-link {
      color: #555;
      font-weight: 500;
      transition: all 0.3s ease;
  }

  .main-header .nav-link:hover {
      color: #5c2f0b;
      transform: scale(1.05);
  }

  .main-header .btn-link {
      background: #ffffff;
      border-radius: 8px;
      padding: 8px 12px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .main-header .btn-link:hover {
      background-color: #ffe6e6;
      box-shadow: 0 3px 10px rgba(255, 0, 0, 0.15);
      color: #5c2f0b!important;
  }

  .main-header .btn-link i {
      font-size: 16px;
  }

  /* Divider line */
  .nav-item.divider {
      border-left: 1px solid rgba(0, 0, 0, 0.1);
      height: 25px;
  }

  .fa-sign-out-alt {
    color:#5c2f0b
  }

</style>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav ml-auto align-items-center">

    <!-- Garis Pemisah -->
    <li class="nav-item divider mx-2"></li>

    <!-- Tombol Logout -->
    <li class="nav-item">
      <form action="{{ url('/logout') }}" method="GET">
        @csrf
        <button type="submit" class="btn btn-link nav-link text-danger" title="Keluar">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </form>
    </li>

  </ul>
</nav>
