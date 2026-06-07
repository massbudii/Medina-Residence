 @php
     $topbarNotifications = auth()->user()->appNotifications()
         ->latest()
         ->take(5)
         ->get();

     $unreadNotificationCount = auth()->user()->appNotifications()
         ->whereNull('read_at')
         ->count();
 @endphp

 <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                        <li>
                            <button class="button-toggle-menu nav-link">
                                <i data-feather="menu" class="noti-icon"></i>
                            </button>
                        </li>
                        {{-- <li class="d-none d-lg-block">
                            <h5 class="mb-0">, Alex</h5>
                        </li> --}}
                    </ul>

                    <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                        <li class="d-none d-lg-block">
                            {{-- <form class="app-search d-none d-md-block me-auto">
                                <div class="position-relative topbar-search">
                                    <input type="text" class="form-control ps-4" placeholder="Search..." />
                                    <i
                                        class="mdi mdi-magnify fs-16 position-absolute text-muted top-50 translate-middle-y ms-2"></i>
                                </div>
                            </form> --}}
                        </li>

                        {{-- <!-- Button Trigger Customizer Offcanvas -->
                        <li class="d-none d-sm-flex">
                            <button type="button" class="btn nav-link" data-toggle="fullscreen">
                                <i data-feather="maximize" class="align-middle fullscreen noti-icon"></i>
                            </button>
                        </li> --}}

                        <!-- Light/Dark Mode Button Themes -->
                        <li class="d-none d-sm-flex">
                            <button type="button" class="btn nav-link" id="light-dark-mode">
                                <i data-feather="moon" class="align-middle dark-mode"></i>
                                <i data-feather="sun" class="align-middle light-mode"></i>
                            </button>
                        </li>

                        <!-- Notifications -->
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle position-relative" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-bell-outline fs-22"></i>
                                @if ($unreadNotificationCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $unreadNotificationCount > 9 ? '9+' : $unreadNotificationCount }}
                                    </span>
                                @endif
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" style="min-width: 340px;">
                                <div class="dropdown-header noti-title d-flex justify-content-between align-items-center">
                                    <h6 class="text-overflow m-0">Notifikasi</h6>
                                    @if ($unreadNotificationCount > 0)
                                        <span class="badge bg-danger">{{ $unreadNotificationCount }} baru</span>
                                    @endif
                                </div>

                                @forelse ($topbarNotifications as $notification)
                                    <a href="{{ route('notification.read', $notification->id) }}"
                                        class="dropdown-item notify-item {{ $notification->read_at ? '' : 'bg-light' }}">
                                        <div class="d-flex gap-2">
                                            <div>
                                                <i class="mdi mdi-file-document-outline fs-18 text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold text-dark">{{ $notification->title }}</div>
                                                <div class="text-muted small text-wrap">{{ $notification->message }}</div>
                                                <div class="text-muted small mt-1">
                                                    {{ $notification->created_at->translatedFormat('d F Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="dropdown-item text-center text-muted py-3">
                                        Belum ada notifikasi
                                    </div>
                                @endforelse
                            </div>
                        </li>


                        <!-- User Dropdown -->
                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('assets/images/users/user-13.jpg') }}" alt="user-image" class="rounded-circle" />
                                <span class="pro-user-name ms-1">{{ auth()->user()->nama }}<i class="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="pages-profile.html" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                {{-- <a href="auth-lock-screen.html" class="dropdown-item notify-item">
                                    <i class="mdi mdi-lock-outline fs-16 align-middle"></i>
                                    <span>Lock Screen</span>
                                </a> --}}

                                <div class="dropdown-divider"></div>

                                <!-- item-->
                                <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
