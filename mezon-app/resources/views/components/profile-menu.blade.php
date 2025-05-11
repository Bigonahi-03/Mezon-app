<ul class="list-group">
    <li class="list-group-item {{ request()->is('profile') ? 'active' : '' }}">
        <a href="{{ route('profile.index') }}">
            <i class="bi bi-person-circle"></i> اطلاعات کاربر
        </a>
    </li>
    <li class="list-group-item {{ request()->is('*/address') ? 'active' : '' }}">
        <a href="{{ route('profile.address') }}">
            <i class="bi bi-geo-alt"></i> آدرس‌ها
        </a>
    </li>
    <li class="list-group-item">
        <a href="./orders.html">
            <i class="bi bi-bag-check"></i> سفارشات
        </a>
    </li>
    <li class="list-group-item">
        <a href="./transactions.html">
            <i class="bi bi-credit-card"></i> تراکنش‌ها
        </a>
    </li>
    <li class="list-group-item {{ request()->is('*/wishlist') ? 'active' : '' }}">
        <a href="{{ route('profile.wishlist') }}">
            <i class="bi bi-heart"></i> لیست علاقه‌مندی‌ها
        </a>
    </li>
    <li class="list-group-item">
        <a href="javascript:void(0);" onclick="confirmDelete()" class="btn btn-dark text-danger">
            <i class="bi bi-box-arrow-right"></i> خروج
        </a>
    </li>
</ul>
