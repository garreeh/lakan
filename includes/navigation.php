<aside id="sidebar" class="sidebar">

  <!-- Sidebar Logo -->
  <div class="sidebar-header text-center py-3">
    <a href="/lakan/index.php" class="d-flex flex-column align-items-center">
      <img src="./../assets/img/logo.jpg" alt="LAKAN Logo" class="img-fluid " style="width: 100px; height: 100px;">
    </a>
  </div>

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link" data-module="dashboard"
        href="/lakan/views/dashboard_module.php?module=dashboard">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-module="active"
        href="/lakan/views/active_members.php?module=active">
        <i class="bi bi-person-lines-fill"></i>
        <span>Members (Active)</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-module="inactive"
        href="/lakan/views/expired_members.php?module=inactive">
        <i class="bi bi-person-lines-fill"></i>
        <span>Members (Expired)</span>
      </a>
    </li>

    <li class="nav-heading">Reports</li>

    <li class="nav-item">
      <a class="nav-link" data-module="sales"
        href="/lakan/views/sales_module.php?module=sales">
        <i class="bi bi-file-bar-graph"></i>
        <span>Sales Reports</span>
      </a>
    </li>

    <li class="nav-heading">Admin Panel</li>

    <li class="nav-item">
      <a class="nav-link" data-module="type"
        href="/lakan/views/membership_type.php?module=type">
        <i class="bi bi-building"></i>
        <span>Membership Type</span>
      </a>
    </li>

    <li class="nav-heading">Users Panel</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/lakan/views/user_module.php">
        <i class="bi bi-person"></i>
        <span>User List</span>
      </a>
    </li>

    <!-- <li class="nav-item">p
      <a class="nav-link collapsed" href="pages-faq.html">
        <i class="bi bi-gear"></i>
        <span>Settings</span>
      </a>
    </li> -->

  </ul>

</aside>


<script>
  const params = new URLSearchParams(window.location.search);
  const currentModule = params.get('module') || 'dashboard';

  document.querySelectorAll('.nav-link[data-module]').forEach(link => {
    if (link.dataset.module === currentModule) {
      link.classList.remove('collapsed');
      link.classList.add('active');
    } else {
      link.classList.add('collapsed');
      link.classList.remove('active');
    }
  });
</script>