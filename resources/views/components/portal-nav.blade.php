<div class="portal-nav">
  <a href="/user/index" class="portal-item {{ Request::is('user/index') || Request::is('/') ? 'active' : '' }}" data-tooltip="Switch to User Site">
    <i class="bi bi-person-badge"></i>
    <span>User site</span>
    <span class="status-dot {{ session('user_logged_in') ? 'online' : '' }}"></span>
  </a>
  <a href="/agent/dashboard" class="portal-item {{ Request::is('agent/*') ? 'active' : '' }}" data-tooltip="Agent Console">
    <i class="bi bi-headset"></i>
    <span>Agent Node</span>
    <span class="status-dot {{ session('agent_logged_in') ? 'online' : '' }}"></span>
  </a>
  <a href="/admin/dashboard" class="portal-item {{ Request::is('admin/*') ? 'active' : '' }}" data-tooltip="Admin Control">
    <i class="bi bi-shield-lock"></i>
    <span>Admin Central</span>
    <span class="status-dot {{ session('admin_logged_in') ? 'online' : '' }}"></span>
  </a>
</div>
