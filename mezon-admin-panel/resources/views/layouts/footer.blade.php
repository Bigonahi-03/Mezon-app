<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    iconColor: 'white',
    customClass: {
        popup: 'colored-toast',
        timerProgressBar: 'swal2-timer-progress-bar',
    },
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
        // تایمر را متوقف یا دوباره شروع کنید
        toast.addEventListener('mouseenter', () => Swal.stopTimer());
        toast.addEventListener('mouseleave', () => Swal.resumeTimer());
    },
});


    @if (session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
        })
    @elseif (session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}',
        })
    @elseif (session('warning'))
        Toast.fire({
            icon: 'warning',
            title: '{{ session('warning') }}',
        })
    @endif

    function confirmDelete(formId) {
    Swal.fire({
        title: 'آیا مطمئن هستید؟',
        text: 'این عملیات قابل بازگشت نیست!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله، حذف کن',
        cancelButtonText: 'لغو'
    }).then((result) => {
        if (result.isConfirmed) {
            // ارسال فرم با استفاده از شناسه پویا
            document.getElementById(formId).submit();
        }
    });
}
</script>

<script>
 document.addEventListener('DOMContentLoaded', function () {
    const popoverTrigger = document.getElementById('icon-input');
    new bootstrap.Popover(popoverTrigger);
});

</script>

<script>
    function openBootstrapIcons() {
        window.open("https://icons.getbootstrap.com/", "_blank");
    }
</script>

@yield('script')

</body>

</html>
