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
      <a class="nav-link" data-module="employees"
        href="/lakan/views/employeelist_module.php?module=employees">
        <i class="bi bi-person-lines-fill"></i>
        <span>Employee List</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-module="emparchives"
        href="/lakan/views/employeearchive_module.php?module=emparchives">
        <i class="bi bi-person-lines-fill"></i>
        <span>Employee Archives</span>
      </a>
    </li>

    <li class="nav-item" <?php if ($_SESSION['user_type_id'] != 1) echo 'style="display: none;"'; ?>>
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>For Signing</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="forms-elements.html">
            <i class="bi bi-journal-text"></i><span>Memo</span>
          </a>
        </li>
        <li>
          <a href="forms-layouts.html">
            <i class="bi bi-journal-text"></i><span>Change Shift</span>
          </a>
        </li>
        <li>
          <a href="forms-editors.html">
            <i class="bi bi-journal-text"></i><span>Leaves</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Overtime</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Damaged</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Issued Items</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Clearance</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Incident Report</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Receiving</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Forms Nav -->

    <li class="nav-item" <?php if ($_SESSION['user_type_id'] != 1) echo 'style="display: none;"'; ?>>
      <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gear"></i><span>Adminitrator Tools</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="tables-general.html">
            <i class="bi bi-journal-text"></i><span>General Memo</span>
          </a>
        </li>
        <li>
          <a href="tables-data.html">
            <i class="bi bi-journal-text"></i><span>Test</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End Tables Nav -->

    <li class="nav-item" <?php if ($_SESSION['user_type_id'] == 1) echo 'style="display: none;"'; ?>>
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Employee Form</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="forms-elements.html">
            <i class="bi bi-journal-text"></i><span>Memo</span>
          </a>
        </li>
        <li>
          <a href="forms-layouts.html">
            <i class="bi bi-journal-text"></i><span>Change Shift</span>
          </a>
        </li>
        <li>
          <a href="forms-editors.html">
            <i class="bi bi-journal-text"></i><span>Leaves</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Overtime</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Damaged</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Issued Items</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Clearance</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Incident Report</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-journal-text"></i><span>Receiving</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-heading">Admin Panel</li>

    <li class="nav-item">
      <a class="nav-link" data-module="department"
        href="/lakan/views/department_module.php?module=department">
        <i class="bi bi-building"></i>
        <span>Department</span>
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