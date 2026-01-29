<aside id="sidebar" class="sidebar">

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
      <a class="nav-link" data-module="emparchives"
        href="/lakan/views/employeearchive_module.php?module=emparchives">
        <i class="bi bi-person-lines-fill"></i>
        <span>Members (Expired)</span>
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

    <li class="nav-item">
      <a class="nav-link" data-module="position"
        href="/lakan/views/position_module.php?module=position">
        <i class="bi bi-person-badge"></i>
        <span>Position</span>
      </a>
    </li>
    <!-- End Profile Page Nav -->

    <li class="nav-heading">My Settings</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/lakan/views/admin/admin_profile.php">
        <i class="bi bi-person"></i>
        <span>Profile</span>
      </a>
    </li>
    <!-- End Profile Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="pages-faq.html">
        <i class="bi bi-gear"></i>
        <span>Settings</span>
      </a>
    </li>
    <!-- End Settings Page Nav -->

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