/* ==========================================
   Rapid Route – User Auth (auth.js)
   ========================================== */

(function () {
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  const byId = (id) => document.getElementById(id);
  const showAlert = (el, msg, type = 'error') => {
    if (!el) return;
    el.style.display = '';
    el.textContent = msg;
    el.classList.remove('success', 'error');
    el.classList.add(type);
  };

  const clearErrors = () => {
    document.querySelectorAll('.field-error').forEach((e) => (e.textContent = ''));
  };

  const setFieldError = (map) => {
    if (!map || typeof map !== 'object') return;
    Object.entries(map).forEach(([k, arr]) => {
      const id = ({
        email: 'regEmailError',
        phone: 'regPhoneError',
        address: 'regAddressError',
        image: 'regImageError',
        password: 'regPasswordError',
        password_confirmation: 'regConfirmError',
        first_name: 'regFirstError',
        last_name: 'regLastError',
      })[k];
      if (!id) return;
      const el = byId(id);
      if (!el) return;
      el.textContent = Array.isArray(arr) ? arr[0] : String(arr);
    });
  };

  async function postForm(url, form) {
    const fd = new FormData(form);
    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),
      },
      body: fd,
    });
    const body = await res.json().catch(() => ({}));
    return { ok: res.ok, status: res.status, body };
  }

  // Login
  const loginForm = byId('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      clearErrors();

      const alertEl = byId('loginAlert');
      if (alertEl) alertEl.style.display = 'none';

      const { ok, body } = await postForm('/user/login_submit', loginForm);
      if (ok && body?.success) {
        window.location.href = body.redirect || '/user/index';
        return;
      }

      showAlert(alertEl, body?.message || 'Login failed. Please try again.', 'error');
    });
  }

  // Register
  const registerForm = byId('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      clearErrors();

      const alertEl = byId('registerAlert');
      if (alertEl) alertEl.style.display = 'none';

      const { ok, status, body } = await postForm('/user/register_submit', registerForm);
      if (ok && body?.success) {
        window.location.href = body.redirect || '/user/index';
        return;
      }

      if (status === 422 && body?.errors) {
        setFieldError(body.errors);
        showAlert(alertEl, 'Please fix the highlighted fields.', 'error');
        return;
      }

      showAlert(alertEl, body?.message || 'Registration failed. Please try again.', 'error');
    });
  }
})();

