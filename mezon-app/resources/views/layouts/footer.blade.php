    <!-- footer section -->
    <footer class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-col">
                    <div class="footer_contact">
                        <h4>
                            تماس با ما
                        </h4>
                        <div class="contact_link_box">
                            <a href="">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>
                                    آدرس
                                </span>
                            </a>
                            <a href="">
                                <div class="d-flex justify-content-center">
                                    <i class="bi bi-telephone-fill" aria-hidden="true"></i>
                                    <p class="my-0" style="direction: ltr;">
                                        0910 000 0000
                                    </p>
                                </div>
                            </a>
                            <a href="">
                                <i class="bi bi-envelope-fill"></i>
                                <span>
                                    demo@gmail.com
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <div class="footer_detail">
                        <a href="" class="footer-logo">
                            mezon
                        </a>
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                        </p>
                        <div class="footer_social">
                            <a href="">
                                <i class="bi bi-telegram"></i>
                            </a>
                            <a href="">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <a href="">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <h4>
                        ساعت کاری
                    </h4>
                    <p>
                        هر روز
                    </p>
                    <p>
                        10.00 صبح تا 12.00 شب
                    </p>
                </div>
            </div>
            <div class="footer-info">
                <p>
                    لورم ایپسوم متن ساختگی با تولید سادگی
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

{{-- script sweetalert2 --}}
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

    // مدیریت منو و مدال لاگین
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        const navbarCollapse = document.getElementById('navbarSupportedContent');
        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {toggle: false});
        
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    bsCollapse.hide();
                }
            });
        });

        const loginBtn = document.getElementById('loginBtn');
        const loginModal = document.getElementById('loginModal');
        
        if (loginBtn && loginModal) {
            loginBtn.addEventListener('click', function() {
                const modal = new bootstrap.Modal(loginModal);
                modal.show();
                history.pushState(null, '', '/login');
            });
        }

        if (window.location.pathname === '/login') {
            const modal = new bootstrap.Modal(loginModal);
            modal.show();
        }

        loginModal.addEventListener('hidden.bs.modal', function() {
            history.pushState(null, '', '/');
        });
    });
</script>

    @yield('script')

</body>
</html>
