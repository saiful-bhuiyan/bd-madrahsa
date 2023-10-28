@if (session('success'))
<!-- Toast with Placements -->
<div
class="bs-toast toast @if(session('success'))show @else hide @endif bg-success toast-placement-ex m-2 top-0 end-0"
role="alert"
aria-live="assertive"
aria-atomic="true"
data-delay="2000"
>
<div class="toast-header">
  <i class="bx bx-bell me-2"></i>
  <div class="me-auto fw-semibold">@lang('common.success')</div>
  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">{{ session('success') }}</div>
</div>
@endif

@if (session('warning'))
<!-- Toast with Placements -->
<div
class="bs-toast toast @if(session('warning'))show @else hide @endif bg-warning toast-placement-ex m-2 top-0 end-0"
role="alert"
aria-live="assertive"
aria-atomic="true"
data-delay="2000"
>
<div class="toast-header">
  <i class="bx bx-bell me-2"></i>
  <div class="me-auto fw-semibold">Warning</div>
  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">{{ session('warning') }}</div>
</div>
@endif


@if (session('info'))
<!-- Toast with Placements -->
<div
class="bs-toast toast @if(session('info'))show @else hide @endif bg-info toast-placement-ex m-2 top-0 end-0"
role="alert"
aria-live="assertive"
aria-atomic="true"
data-delay="2000"
>
<div class="toast-header">
  <i class="bx bx-bell me-2"></i>
  <div class="me-auto fw-semibold">Info</div>
  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">{{ session('info') }}</div>
</div>
@endif
@if (session('error'))
<!-- Toast with Placements -->
<div
class="bs-toast toast @if(session('error'))show @else hide @endif bg-danger toast-placement-ex m-2 top-0 end-0"
role="alert"
aria-live="assertive"
aria-atomic="true"
data-delay="2000"
>
<div class="toast-header">
  <i class="bx bx-bell me-2"></i>
  <div class="me-auto fw-semibold">Error</div>
  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
<div class="toast-body">{{ session('error') }}</div>
</div>
@endif
