@if(session('message') || session('status') || session('error') || session('warning') || session('info') || session('success'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;"></div>

<script>
   $(document).ready(function() {
      console.log('Toast script loaded');

      // Check each session type and show toast
      @if(session('status'))
      console.log('Status session found');
      showToast(@json(session('status')), 'success');
      @endif

      @if(session('message'))
      console.log('Message session found');
      showToast(@json(session('message')), 'success');
      @endif

      @if(session('error'))
      console.log('Error session found');
      showToast(@json(session('error')), 'danger');
      @endif

      @if(session('warning'))
      console.log('Warning session found');
      showToast(@json(session('warning')), 'warning');
      @endif

      @if(session('info'))
      console.log('Info session found');
      showToast(@json(session('info')), 'info');
      @endif
   });

   function showToast(message, type) {
      var bgClass, iconClass, closeBtn;

      switch (type) {
         case 'success':
            bgClass = 'bg-success text-white';
            iconClass = 'fas fa-check-circle';
            closeBtn = 'btn-close-white';
            break;
         case 'danger':
         case 'error':
            bgClass = 'bg-danger text-white';
            iconClass = 'fas fa-exclamation-triangle';
            closeBtn = 'btn-close-white';
            break;
         case 'warning':
            bgClass = 'bg-warning text-dark';
            iconClass = 'fas fa-exclamation-circle';
            closeBtn = 'btn-close';
            break;
         case 'info':
            bgClass = 'bg-info text-white';
            iconClass = 'fas fa-info-circle';
            closeBtn = 'btn-close-white';
            break;
         default:
            bgClass = 'bg-primary text-white';
            iconClass = 'fas fa-bell';
            closeBtn = 'btn-close-white';
      }

      var toastHtml = `
        <div class="toast ${bgClass} border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true" 
             data-bs-autohide="true" data-bs-delay="1000" style="min-width: 350px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            <div class="d-flex align-items-center p-3">
                <div class="me-3">
                    <i class="${iconClass}" style="font-size: 1.5rem;"></i>
                </div>
                <div class="toast-body flex-grow-1" style="font-size: 1rem; font-weight: 500;">
                    ${message}
                </div>
                <button type="button" class="btn-close ${closeBtn} ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

      $('.toast-container').append(toastHtml);
      var $toast = $('.toast-container .toast:last');

      if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
         var bsToast = new bootstrap.Toast($toast[0], {
            autohide: true,
            delay: 3000
         });
         bsToast.show();
      } else {
         $toast.show().delay(3000).fadeOut();
      }
   }
</script>

<style>
   .toast-container .toast {
      animation: slideInRight 0.3s ease-out;
   }

   @keyframes slideInRight {
      from {
         transform: translateX(100%);
         opacity: 0;
      }

      to {
         transform: translateX(0);
         opacity: 1;
      }
   }

   .toast .btn-close {
      filter: none !important;
   }
</style>
@endif