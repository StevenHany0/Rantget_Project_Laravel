@if(auth()->check() && !request()->is('auth') && !request()->is('login') && !request()->is('register'))
    <div class="sidebar">
        <h4 class="sidebar-title">
            <i class="fas fa-chart-bar"></i> Dashboard
        </h4>
        <ul class="sidebar-menu">

            @if(auth()->user()->role === 'landlord')
                <li>
                    <a href="{{ route('landlord.dashboard') }}">
                        <i class="fas fa-home"></i> Home
                    </a>

                </li>
                <li>
                    <a href="{{ route('contracts.index') }}">
                        <i class="fas fa-users"></i> Renters
                    </a>
                </li>
                <li>
                    <a href="{{ route('histories.index') }}">
                        <i class="fas fa-history"></i> History
                    </a>
                </li>

                @if(optional(auth()->user()->contracts()->first())->id)
                    <li>
                        <a href="{{ route('payments.months', ['contractId' => auth()->user()->contracts()->first()->id]) }}">
                            <i class="fas fa-money-bill-wave"></i> Payments
                        </a>
                    </li>
                @endif

            @elseif(auth()->user()->role === 'tenant') {{-- تأكد من أن role هو "tenant" في قاعدة البيانات --}}
                <li>
                    <a href="{{ route('renter.dashboard') }}">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>

            @endif

            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="#"><i class="fas fa-phone"></i> Contact</a></li>
            <li><a href="#"><i class="fas fa-info-circle"></i> About</a></li>

            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
@endif
