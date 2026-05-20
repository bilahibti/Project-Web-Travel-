<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>My Bookings - TravelTime</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('frontend/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('frontend/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
</head>

<body class="booking-page">

  <!-- ======================================================
       HEADER / NAV — sama dengan halaman tours
  ====================================================== -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('v1.frontend.dashboard') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">TravelTime</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('v1.frontend.dashboard') }}">Home</a></li>
          <li><a href="{{ route('v1.frontend.about') }}">About</a></li>
          <li><a href="{{ route('v1.frontend.destination') }}">Destinations</a></li>
          <li><a href="{{ route('v1.frontend.tours') }}">Tours</a></li>
          <li><a href="{{ route('v1.frontend.gallery') }}">Gallery</a></li>
          <li><a href="{{ route('v1.frontend.blog') }}">Blog</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="d-flex align-items-center gap-2">
        @auth
          <span class="text-white fw-semibold d-none d-md-inline" style="font-size:0.9rem;">
            Hi, {{ auth()->user()->name }}
          </span>
          <a class="btn-getstarted" href="{{ route('v1.booking.index') }}" style="background:#0d6efd;">
            <i class="bi bi-journal-bookmark-fill me-1"></i> My Bookings
          </a>
          <form method="POST" action="{{ route('v1.frontend.login.logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger ms-1">Logout</button>
          </form>
        @else
          <a class="btn-getstarted" href="{{ route('v1.frontend.login.login') }}">Login</a>
        @endauth
      </div>

    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url({{ asset('frontend/img/travel/showcase-3.webp') }});">
      <div class="container position-relative">
        <h1>My Bookings</h1>
        <p>Kelola semua pemesanan perjalanan Anda di satu tempat.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('v1.frontend.dashboard') }}">Home</a></li>
            <li class="current">My Bookings</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Bookings Section -->
    <section class="section" style="padding: 60px 0;">
      <div class="container">

        <!-- Flash Messages -->
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <!-- Summary Stats -->
        <div class="row g-3 mb-5">
          <div class="col-6 col-md-3">
            <div class="text-center p-4 rounded-3" style="background:#e0f2fe;">
              <div style="font-size:2rem;font-weight:700;color:#0369a1;">{{ $bookings->total() }}</div>
              <div style="font-size:0.82rem;color:#0369a1;font-weight:600;">Total Booking</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="text-center p-4 rounded-3" style="background:#d1e7dd;">
              <div style="font-size:2rem;font-weight:700;color:#0f5132;">
                {{ $bookings->where('status','confirmed')->count() }}
              </div>
              <div style="font-size:0.82rem;color:#0f5132;font-weight:600;">Confirmed</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="text-center p-4 rounded-3" style="background:#fff3cd;">
              <div style="font-size:2rem;font-weight:700;color:#856404;">
                {{ $bookings->where('status','pending')->count() }}
              </div>
              <div style="font-size:0.82rem;color:#856404;font-weight:600;">Pending</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="text-center p-4 rounded-3" style="background:#d3d3d3;">
              <div style="font-size:2rem;font-weight:700;color:#333;">
                {{ $bookings->where('status','completed')->count() }}
              </div>
              <div style="font-size:0.82rem;color:#333;font-weight:600;">Completed</div>
            </div>
          </div>
        </div>

        <!-- Header Row -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
          <h4 class="fw-bold mb-0" style="color:#1a1a2e;">
            <i class="bi bi-journal-bookmark me-2 text-primary"></i>Riwayat Pemesanan
          </h4>
          <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('v1.frontend.tours') }}" class="btn btn-primary btn-sm rounded-pill">
              <i class="bi bi-plus-circle me-1"></i> Pesan Baru
            </a>
          </div>
        </div>

        @if($bookings->count() > 0)

          <div class="row g-4">
            @foreach($bookings as $booking)
            <div class="col-12">
              <div class="booking-card card">
                <div class="card-body p-0">
                  <div class="row g-0">

                    <!-- Left Stripe (type color) -->
                    <div class="col-auto d-none d-md-block">
                      <div class="h-100 d-flex align-items-center justify-content-center px-3"
                        style="
                          min-width:60px;
                          border-radius:16px 0 0 16px;
                          @if($booking->type == 'package') background:#0369a1;
                          @elseif($booking->type == 'hotel') background:#7e22ce;
                          @else background:#854d0e; @endif
                        ">
                        @if($booking->type == 'package')
                          <i class="bi bi-map text-white" style="font-size:1.5rem;"></i>
                        @elseif($booking->type == 'hotel')
                          <i class="bi bi-building text-white" style="font-size:1.5rem;"></i>
                        @else
                          <i class="bi bi-truck text-white" style="font-size:1.5rem;"></i>
                        @endif
                      </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col p-4">
                      <div class="row align-items-center">

                        <!-- Info Kiri -->
                        <div class="col-md-7">
                          <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <!-- Tipe -->
                            <span class="booking-type-badge type-{{ $booking->type }}">
                              @if($booking->type == 'package') <i class="bi bi-map-fill me-1"></i>Tour Package
                              @elseif($booking->type == 'hotel') <i class="bi bi-building-fill me-1"></i>Hotel
                              @else <i class="bi bi-truck me-1"></i>Transportation
                              @endif
                            </span>
                            <!-- Status -->
                            <span class="status-badge status-{{ $booking->status }}">
                              {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                          </div>

                          <!-- Kode Booking -->
                          <div class="booking-code mb-2">
                            <i class="bi bi-hash me-1"></i>{{ $booking->booking_code }}
                          </div>

                          <!-- Nama Layanan -->
                          <h5 class="fw-bold mb-2" style="color:#1a1a2e;">
                            @if($booking->type == 'package' && $booking->packages->isNotEmpty())
                              {{ $booking->packages->first()->travelPackage->package_name ?? 'Travel Package' }}
                            @elseif($booking->type == 'hotel' && $booking->hotels->isNotEmpty())
                              {{ $booking->hotels->first()->hotel->hotel_name ?? 'Hotel Booking' }}
                              <small class="text-muted fw-normal">— {{ $booking->hotels->first()->room->room_type ?? '' }}</small>
                            @elseif($booking->type == 'transport' && $booking->transports->isNotEmpty())
                              {{ $booking->transports->first()->transportation->vehicle_name ?? 'Transportation' }}
                            @else
                              Booking #{{ $booking->id }}
                            @endif
                          </h5>

                          <!-- Meta Info -->
                          <div class="d-flex flex-wrap gap-3 booking-meta">
                            <span><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}</span>
                            @if($booking->return_date)
                              <span><i class="bi bi-calendar-check"></i> s/d {{ \Carbon\Carbon::parse($booking->return_date)->format('d M Y') }}</span>
                            @endif
                            @if($booking->total_persons)
                              <span><i class="bi bi-people"></i> {{ $booking->total_persons }}
                                {{ $booking->type == 'hotel' ? 'Kamar' : ($booking->type == 'transport' ? 'Unit' : 'Orang') }}
                              </span>
                            @endif
                            <span><i class="bi bi-clock-history"></i> {{ $booking->created_at->format('d M Y') }}</span>
                          </div>
                        </div>

                        <!-- Info Kanan -->
                        <div class="col-md-5 mt-3 mt-md-0">
                          <div class="text-md-end">
                            <!-- Harga -->
                            <div class="price-highlight mb-1">
                              Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </div>
                            <div class="booking-meta mb-3">
                              Subtotal: Rp {{ number_format($booking->subtotal, 0, ',', '.') }}
                              + Pajak: Rp {{ number_format($booking->tax, 0, ',', '.') }}
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="d-flex flex-wrap justify-content-md-end gap-2">
                              <!-- Detail -->
                              <a href="{{ route('v1.booking.show', $booking->id) }}"
                                 class="btn btn-outline-primary btn-sm rounded-pill">
                                <i class="bi bi-eye me-1"></i> Detail
                              </a>

                              <!-- Bayar (kalau pending dan belum bayar) -->
                              @if($booking->status == 'pending' && !$booking->isPaid())
                                <a href="{{ route('v1.payment.show', $booking->id) }}"
                                   class="btn btn-success btn-sm rounded-pill">
                                  <i class="bi bi-credit-card me-1"></i> Bayar Sekarang
                                </a>
                              @endif

                              <!-- Cancel -->
                              @if(in_array($booking->status, ['pending', 'confirmed']))
                                <form method="POST"
                                      action="{{ route('v1.booking.cancel', $booking->id) }}"
                                      onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                  @csrf
                                  @method('PUT')
                                  <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                  </button>
                                </form>
                              @endif
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>

          <!-- Pagination -->
          <div class="d-flex justify-content-center mt-5">
            {{ $bookings->links('pagination::bootstrap-5') }}
          </div>

        @else
          <!-- Empty State -->
          <div class="empty-state">
            <i class="bi bi-journal-x"></i>
            <h4>Belum Ada Booking</h4>
            <p class="text-muted mb-4">Anda belum melakukan pemesanan apapun. Mulai jelajahi destinasi impian Anda!</p>
            <a href="{{ route('v1.frontend.tours') }}" class="btn btn-primary rounded-pill px-5">
              <i class="bi bi-compass me-2"></i>Jelajahi Paket Tour
            </a>
          </div>
        @endif

      </div>
    </section>

  </main>

  <!-- ======================================================
       FOOTER
  ====================================================== -->
  <footer id="footer" class="footer dark-background">
    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="{{ route('v1.frontend.dashboard') }}" class="logo d-flex align-items-center">
              <span class="sitename">TravelTime</span>
            </a>
            <div class="footer-contact pt-3">
              <p>Jl. Sudirman No. 1, Jakarta</p>
              <p class="mt-3"><strong>Phone:</strong> <span>+62 21 1234 5678</span></p>
              <p><strong>Email:</strong> <span>info@traveltime.id</span></p>
            </div>
            <div class="social-links d-flex mt-4">
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-twitter-x"></i></a>
              <a href="#"><i class="bi bi-instagram"></i></a>
              <a href="#"><i class="bi bi-youtube"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <div class="copyright">
          <p>© <span>Copyright</span> <strong class="px-1 sitename">TravelTime</strong> <span>All Rights Reserved</span></p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/vendor/glightbox/js/glightbox.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('frontend/js/main.js') }}"></script>

</body>

</html>