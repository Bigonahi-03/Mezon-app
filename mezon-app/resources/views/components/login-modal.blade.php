<!-- الرت در سطح بالاتر -->
<div id="successAlert" class="alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; display: none;" role="alert">
    <span id="alertMessage"></span>
</div>

<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" x-data="loginForm">
        <div class="modal-content">
            <div class="modal-header px-3">
                <h5 class="modal-title" id="loginModalLabel">ورود به حساب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
            </div>
            <div class="modal-body p-4">
                {{-- checkOtpForm نمایش فرم ورود در صورت غلط بودن شرط --}}
                <template x-if="!checkOtpForm">
                    {{-- فرم ورود  --}}
                    <div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">شماره موبایل</label>
                            <input type="text" x-model="cellphone" class="form-control" name="phone"
                                placeholder="شماره موبایل خود را وارد کنید ..." id="phone" required>
                            <span x-text="error" class="text-danger"></span>
                        </div>
                        <button type="submit" @click="login()" class="btn btn-primary">ورود
                            <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </template>

                {{-- checkOtpForm نمایش فرم ارسال کد ورود در صورت صحیح بودن شرط --}}
                <template x-if="checkOtpForm">
                    <div>
                        <div class="mb-3">
                            <label for="otp" class="form-label">کد تایید</label>
                            <div class="alert alert-info" x-show="message" x-text="message"></div>
                            <input type="text" x-model="otp" class="form-control" name="otp"
                                placeholder=" کد تایید را وارد کنید ..." id="otp" required>
                            <span x-text="error" class="text-danger"></span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" @click="checkOtp()" class="btn btn-primary">ورود
                                <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                            </button>

                            <template x-if="seconds > 0 || minutes > 0">
                                <div class="mt-2 me-3 text-center">
                                    <span x-text="seconds < 10 ? '0' + seconds : seconds"></span> :
                                    <span x-text="minutes < 10 ? '0' + minutes : minutes"></span>
                                </div>
                            </template>

                            <template x-if="seconds === 0 && minutes === 0">
                                <button type="submit" @click="resendOtp()" class="btn btn-dark">ارسال مجدد
                                    <span x-show="loading" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
    // تابع نمایش الرت
    function showSuccessAlert(message) {
        const alert = document.getElementById('successAlert');
        const alertMessage = document.getElementById('alertMessage');
        alertMessage.textContent = message;
        alert.style.display = 'block';
        
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const loginBtn = document.getElementById('loginBtn');
        const loginModal = document.getElementById('loginModal');

        if (loginBtn) {
            loginBtn.addEventListener('click', function() {
                const modal = new bootstrap.Modal(loginModal);
                modal.show();
            });
        }

        if (loginModal) {
            loginModal.addEventListener('hidden.bs.modal', function() {
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';

                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });
        }
    });

    document.addEventListener('alpine:init', () => {
        Alpine.data('loginForm', () => {
            return {
                otp: '',
                cellphone: '',
                error: '',
                loginToken: '',
                loading: false,
                resendLoading: false,
                checkOtpForm: false,
                message: '',

                seconds: 5,
                minutes: 0,

                async login() {
                    this.loading = true;
                    const res = await fetch('{{ route('auth.login') }}', {
                        method: 'POST',
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            '_token': '{{ csrf_token() }}',
                            'cellphone': this.cellphone
                        })
                    });
                    const data = await res.json();
                    this.loading = false;
                    if (res.ok) {
                        this.error = '';
                        this.loginToken = data.login_token;
                        this.message = data.message;
                        this.checkOtpForm = true;
                        this.timer();
                    } else {
                        this.error = data.message;
                    }
                },

                async checkOtp() {
                    this.loading = true;
                    const res = await fetch('{{ route('auth.checkOtp') }}', {
                        method: 'POST',
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            '_token': '{{ csrf_token() }}',
                            'otp': this.otp,
                            'login_token': this.loginToken
                        })
                    });
                    const data = await res.json();
                    this.loading = false;
                    if (res.ok) {
                        this.message = data.message;
                        if (data.closeModal) {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                            modal.hide();
                            
                            // استفاده از Toast تعریف شده در footer
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                        }
                    } else {
                        this.error = data.message;
                    }
                },

                async resendOtp() {
                    this.resendLoading = true;
                    const res = await fetch('{{ route('auth.resendOtp') }}', {
                        method: 'POST',
                        headers: {
                            'Content-type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            '_token': '{{ csrf_token() }}',
                            'otp': this.otp,
                            'login_token': this.loginToken
                        })
                    });
                    const data = await res.json();
                    this.resendLoading = false;
                    if (res.ok) {
                        this.loginToken = data.login_token;
                        this.seconds = 5;
                        this.minutes = 0;
                        this.timer();
                        this.message = data.message;
                        this.error = '';
                    } else {
                        this.error = data.message;
                    }
                },

                timer() {
                    const interval = setInterval(() => {
                        if (this.seconds > 0) {
                            this.seconds--;
                        }

                        if (this.seconds === 0) {
                            if (this.minutes === 0) {
                                clearInterval(interval);
                            } else {
                                this.seconds = 59;
                                this.minutes--;
                            }
                        }
                    }, 1000);
                }
            }
        });
    });
</script>
