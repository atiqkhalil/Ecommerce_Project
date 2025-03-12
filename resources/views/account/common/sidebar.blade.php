<div class="card shadow-sm">
    <div class="card-header bg-primary text-dark">
        <h3 class="h6 mb-0">Account Panel</h3>
    </div>
    <div class="card-body p-0">
        <ul id="account-panel" class="nav flex-column">
            <!-- My Profile -->
            <li class="nav-item">
                <a href="{{ route('account.profile', ['id' => Auth::id()]) }}" class="nav-link d-flex align-items-center p-3">
                    <i class="fas fa-user-alt me-3"></i>
                    <span class="font-weight-bold">My Profile</span>
                </a>
            </li>

            <!-- My Orders -->
            <li class="nav-item">
                <a href="{{ route('account.orders') }}" class="nav-link d-flex align-items-center p-3">
                    <i class="fas fa-shopping-bag me-3"></i>
                    <span class="font-weight-bold">My Orders</span>
                </a>
            </li>

            <!-- Wishlist -->
            <li class="nav-item">
                <a href="{{ route('mywishlist') }}" class="nav-link d-flex align-items-center p-3">
                    <i class="fas fa-heart me-3"></i>
                    <span class="font-weight-bold">Wishlist</span>
                </a>
            </li>

            <!-- Change Password -->
            <li class="nav-item">
                <a href="{{ route('account.changepassword') }}" class="nav-link d-flex align-items-center p-3">
                    <i class="fas fa-lock me-3"></i>
                    <span class="font-weight-bold">Change Password</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                    @csrf
                    <button type="submit" class="nav-link bg-transparent border-0 d-flex align-items-center p-3 w-100 text-start">
                        <i class="fas fa-sign-out-alt me-3"></i>
                        <span class="font-weight-bold">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>