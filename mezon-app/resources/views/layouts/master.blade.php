@include('layouts.header')

@yield('content')

@include('layouts.footer')

@if(request()->get('show_modal') == 'login')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
        myModal.show();
    });
</script>                                                                                                                                                                                                                                                                                                                                                                                                                                                       
@endif

@yield('script')

