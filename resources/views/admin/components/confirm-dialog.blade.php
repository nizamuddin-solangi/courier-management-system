<!-- Confirmation Dialog Component (shared across admin pages that need delete actions) -->
<div class="modal-backdrop-custom" id="confirmBackdrop"></div>
<div class="confirm-dialog" id="confirmDialog">
  <div class="confirm-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
  <h4 class="confirm-title">Are you sure?</h4>
  <p class="confirm-message">This action cannot be undone.</p>
  <div class="confirm-actions">
    <button class="btn-outline-custom" onclick="handleConfirm(false)">Cancel</button>
    <button class="btn-danger-custom" onclick="handleConfirm(true)" style="padding:10px 22px;font-size:14px;"><i class="bi bi-trash3"></i> Delete</button>
  </div>
</div>
