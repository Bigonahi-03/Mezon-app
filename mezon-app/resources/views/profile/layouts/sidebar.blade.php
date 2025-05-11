<div class="col-md-4 col-lg-3 me-lg-3">
    <!-- نمایش در دسکتاپ -->
    <div class="d-none d-md-block">
        <x-profile-menu/>
    </div>

    <!-- نمایش در موبایل -->
    <div class="d-md-none">
        <button class="rounded-circle p-3 shadow-sm position-fixed bottom-0 start-0 m-4" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"
            style="background-color: #6c757d; z-index: 1000;">
            <i class="bi bi-list fs-4 text-white"></i>
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">منوی کاربری</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <x-profile-menu/>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'آیا میخواهید خارج شوید؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله، خارج شو ',
            cancelButtonText: 'لغو'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('profile.logout') }}"; // تغییر مسیر به صفحه خروج
            }
        });
    }
</script>


@endsection
