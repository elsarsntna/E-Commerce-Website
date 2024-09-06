<div class="card" style="background-color: #F28123; border-radius: 15px;">
    <div class="card-body">
        <h3 class="text-white">Main Menu</h3>
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('customer.dashboard') }}" class="text-white">
                    <i class="fas fa-home"></i>
                    <span class="ml-2">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('customer.orders') }}" class="text-white">
                    <i class="fas fa-list"></i>
                    <span class="ml-2">Orders</span>
                </a>
            </li>
            <li>
                <a href="{{ route('customer.settingForm') }}" class="text-white">
                    <i class="fas fa-cog"></i>
                    <span class="ml-2">Setting</span>
                </a>
            </li>
        </ul>
    </div>
</div>
