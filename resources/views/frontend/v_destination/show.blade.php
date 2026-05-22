<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ $destination->destination_name }} - TravelTime</title>
  <meta name="description" content="{{ Str::limit(strip_tags($destination->description), 160) }}">

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

  <style>
    .destination-hero {
      position: relative;
      height: 480px;
      overflow: hidden;
    }
    .destination-hero img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .destination-hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);
      display: flex;
      align-items: flex-end;
    }
    .destination-hero-content {
      padding: 2.5rem;
      color: #fff;
    }
    .destination-hero-content h1 {
      font-size: 2.6rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    .destination-hero-content .meta-badges .badge {
      font-size: 0.85rem;
      padding: 0.45em 0.9em;
      border-radius: 50px;
      margin-right: 0.4rem;
    }
    .badge-type { background: #e8a838; color: #fff; }
    .badge-status-available { background: #28a745; color: #fff; }
    .badge-status-full { background: #dc3545; color: #fff; }

    .info-card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08);
      padding: 2rem;
      margin-bottom: 1.5rem;
    }
    .info-card h4 {
      font-size: 1.1rem;
      font-weight: 700;
      color: #1a1a2e;
      border-bottom: 2px solid #e8a838;
      padding-bottom: 0.6rem;
      margin-bottom: 1.2rem;
    }
    .detail-row {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.55rem 0;
      border-bottom: 1px solid #f0f0f0;
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-row i { color: #e8a838; font-size: 1.1rem; width: 22px; flex-shrink: 0; }
    .detail-row .label { color: #6c757d; font-size: 0.85rem; min-width: 90px; }
    .detail-row .value { font-weight: 600; color: #1a1a2e; }

    .quota-bar-wrap { margin-top: 0.5rem; }
    .quota-label { display: flex; justify-content: space-between; font-size: 0.82rem; color: #6c757d; margin-bottom: 4px; }
    .quota-bar { background: #e9ecef; border-radius: 50px; height: 8px; overflow: hidden; }
    .quota-bar-fill { height: 100%; border-radius: 50px; background: linear-gradient(90deg, #e8a838, #f0c060); }

    .package-card {
      border: none;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 2px 16px rgba(0,0,0,0.07);
      transition: transform 0.2s, box-shadow 0.2s;
      height: 100%;
    }
    .package-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(0,0,0,0.13); }
    .package-card .card-img-top { height: 180px; object-fit: cover; }
    .package-card .card-body { padding: 1.2rem; }
    .package-card .price-tag {
      font-size: 1.2rem;
      font-weight: 700;
      color: #e8a838;
    }
    .package-card .package-meta span {
      font-size: 0.8rem;
      color: #6c757d;
      margin-right: 0.8rem;
    }
    .package-card .package-meta i { color: #e8a838; margin-right: 3px; }

    .hotel-card {
      border: none;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 2px 16px rgba(0,0,0,0.07);
      transition: transform 0.2s;
      height: 100%;
    }
    .hotel-card:hover { transform: translateY(-4px); }
    .hotel-card .card-img-top { height: 170px; object-fit: cover; }

    .btn-book {
      background: linear-gradient(135deg, #e8a838, #d4911f);
      border: none;
      color: #fff;
      border-radius: 50px;
      padding: 0.55rem 1.6rem;
      font-weight: 600;
      font-size: 0.9rem;
      transition: opacity 0.2s;
    }
    .btn-book:hover { opacity: 0.9; color: #fff; }
    .btn-back {
      background: transparent;
      border: 2px solid #e8a838;
      color: #e8a838;
      border-radius: 50px;
      padding: 0.5rem 1.4rem;
      font-weight: 600;
      font-size: 0.9rem;
      transition: all 0.2s;
      text-decoration: none;
    }
    .btn-back:hover { background: #e8a838; color: #fff; }

    .section-heading {
      font-size: 1.4rem;
      font-weight: 700;
      color: #1a1a2e;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .section-heading i { color: #e8a838; }

    .empty-state {
      text-align: center;
      padding: 2.5rem 1rem;
      color: #aaa;
    }
    .empty-state i { font-size: 2.5rem; display: block; margin-bottom: 0.7rem; }
  </style>
</head>

<body class="destination-details-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ route('v1.frontend.beranda') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">TravelTime</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('v1.frontend.beranda') }}">Home</a></li>
          <li><a href="{{ route('v1.frontend.about') }}">About</a></li>
          <li><a href="{{ route('v1.frontend.destinasi') }}" class="active">Destinations</a></li>
          <li><a href="{{ route('v1.frontend.tours') }}">Tours</a></li>
          <li><a href="{{ route('v1.frontend.gallery') }}">Gallery</a></li>
          <li><a href="{{ route('v1.frontend.blog') }}">Blog</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <a class="btn-getstarted" href="{{ route('v1.frontend.login.login') }}">Login</a>
    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url({{ $destination->foto ? asset('storage/img-destination/' . $destination->foto) : asset('frontend/img/travel/showcase-11.webp') }});">
      <div class="container position-relative">
        <h1>{{ $destination->destination_name }}</h1>
        <p>{{ $destination->city }}, {{ $destination->country }}</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('v1.frontend.beranda') }}">Home</a></li>
            <li><a href="{{ route('v1.frontend.destinasi') }}">Destinations</a></li>
            <li class="current">{{ $destination->destination_name }}</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Destination Detail Section -->
    <section class="section py-5">
      <div class="container">

        <div class="row g-4">

          <!-- LEFT: Main Content -->
          <div class="col-lg-8">

            <!-- Hero Image -->
            <div class="destination-hero rounded-4 mb-4">
              @if($destination->foto)
                <img src="{{ asset('storage/img-destination/' . $destination->foto) }}" alt="{{ $destination->destination_name }}">
              @else
                <img src="{{ asset('frontend/img/travel/destination-1.webp') }}" alt="{{ $destination->destination_name }}">
              @endif
              <div class="destination-hero-overlay">
                <div class="destination-hero-content">
                  <div class="meta-badges mb-2">
                    <span class="badge badge-type">{{ $destination->destination_type }}</span>
                    @if($destination->status === 'Available')
                      <span class="badge badge-status-available"><i class="bi bi-check-circle me-1"></i>Available</span>
                    @else
                      <span class="badge badge-status-full"><i class="bi bi-x-circle me-1"></i>Full Booked</span>
                    @endif
                  </div>
                  <h1>{{ $destination->destination_name }}</h1>
                  <p class="mb-0"><i class="bi bi-geo-alt-fill me-1"></i>{{ $destination->city }}, {{ $destination->country }}</p>
                </div>
              </div>
            </div>

            <!-- About This Destination -->
            <div class="info-card">
              <h4><i class="bi bi-info-circle me-2"></i>About This Destination</h4>
              <div style="line-height: 1.8; color: #444;">
                {!! nl2br(e($destination->description)) !!}
              </div>
            </div>

            <!-- Availability Info -->
            <div class="info-card">
              <h4><i class="bi bi-people me-2"></i>Availability</h4>
              @php
                $booked = $destination->booked ?? 0;
                $quota  = $destination->quota;
                $avail  = max(0, $quota - $booked);
                $pct    = $quota > 0 ? min(100, round(($booked / $quota) * 100)) : 0;
              @endphp
              <div class="quota-bar-wrap">
                <div class="quota-label">
                  <span>{{ $booked }} booked</span>
                  <span>{{ $avail }} spots left of {{ $quota }}</span>
                </div>
                <div class="quota-bar">
                  <div class="quota-bar-fill" style="width: {{ $pct }}%"></div>
                </div>
              </div>
            </div>

            <!-- Available Packages -->
            <div class="mt-4">
              <h3 class="section-heading"><i class="bi bi-suitcase-lg"></i> Available Tour Packages</h3>

              @if(isset($packages) && $packages->count() > 0)
                <div class="row g-3">
                  @foreach($packages as $pkg)
                    <div class="col-md-6">
                      <div class="package-card card h-100">
                        @if($pkg->foto)
                          <img src="{{ asset('storage/img-packages/' . $pkg->foto) }}" class="card-img-top" alt="{{ $pkg->packages_name }}">
                        @else
                          <img src="{{ asset('frontend/img/travel/showcase-' . (($loop->index % 12) + 1) . '.webp') }}" class="card-img-top" alt="{{ $pkg->packages_name }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                          <div class="mb-1">
                            <span class="badge" style="background:#e8a838;color:#fff;border-radius:50px;font-size:0.75rem;">{{ $pkg->package_type }}</span>
                          </div>
                          <h5 class="card-title fw-bold mb-1">{{ $pkg->packages_name }}</h5>
                          <p class="card-text text-muted small mb-2">{{ Str::limit($pkg->description, 80) }}</p>

                          <div class="package-meta mb-2">
                            <span><i class="bi bi-calendar3"></i>{{ $pkg->duration_days ?? '-' }} days</span>
                            <span><i class="bi bi-people"></i>Max {{ $pkg->max_persons ?? $pkg->quota }}</span>
                          </div>

                          <div class="d-flex align-items-center justify-content-between mt-auto">
                            <div class="price-tag">Rp {{ number_format($pkg->price_packages, 0, ',', '.') }}</div>
                            <a href="{{ route('v1.frontend.tours.show', $pkg->id) }}" class="btn btn-book">View Details</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              @else
                <div class="info-card">
                  <div class="empty-state">
                    <i class="bi bi-suitcase"></i>
                    <p>No tour packages available for this destination at the moment.</p>
                    <a href="{{ route('v1.frontend.tours') }}" class="btn btn-book">Browse All Tours</a>
                  </div>
                </div>
              @endif
            </div>

            <!-- Available Hotels -->
            @if(isset($hotels) && $hotels->count() > 0)
            <div class="mt-5">
              <h3 class="section-heading"><i class="bi bi-building"></i> Available Hotels</h3>
              <div class="row g-3">
                @foreach($hotels as $hotel)
                  <div class="col-md-6">
                    <div class="hotel-card card h-100">
                      @if($hotel->foto)
                        <img src="{{ asset('storage/img-hotel/' . $hotel->foto) }}" class="card-img-top" alt="{{ $hotel->hotel_name }}">
                      @else
                        <img src="{{ asset('frontend/img/travel/misc-' . (($loop->index % 15) + 1) . '.webp') }}" class="card-img-top" alt="{{ $hotel->hotel_name }}">
                      @endif
                      <div class="card-body">
                        <h5 class="fw-bold mb-1">{{ $hotel->hotel_name }}</h5>
                        <p class="text-muted small mb-1"><i class="bi bi-geo-alt text-warning me-1"></i>{{ $hotel->city ?? $destination->city }}</p>
                        <p class="text-muted small mb-2">{{ Str::limit($hotel->description ?? '', 70) }}</p>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="fw-bold" style="color:#e8a838;">Rp {{ number_format($hotel->price_per_night ?? 0, 0, ',', '.') }}<small class="text-muted fw-normal">/night</small></span>
                          <a href="{{ route('v1.frontend.hotel.show', $hotel->id) }}" class="btn btn-book btn-sm">Details</a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            @endif

          </div><!-- End Left Column -->

          <!-- RIGHT: Sidebar -->
          <div class="col-lg-4">

            <!-- Quick Info Card -->
            <div class="info-card sticky-top" style="top: 90px;">
              <h4><i class="bi bi-pin-map me-2"></i>Destination Info</h4>

              <div class="detail-row">
                <i class="bi bi-geo-alt-fill"></i>
                <span class="label">Location</span>
                <span class="value">{{ $destination->city }}, {{ $destination->country }}</span>
              </div>
              <div class="detail-row">
                <i class="bi bi-globe2"></i>
                <span class="label">Type</span>
                <span class="value">{{ $destination->destination_type }}</span>
              </div>
              <div class="detail-row">
                <i class="bi bi-people-fill"></i>
                <span class="label">Total Quota</span>
                <span class="value">{{ number_format($destination->quota) }} pax</span>
              </div>
              <div class="detail-row">
                <i class="bi bi-check2-circle"></i>
                <span class="label">Status</span>
                <span class="value">
                  @if($destination->status === 'Available')
                    <span style="color:#28a745;">● Available</span>
                  @else
                    <span style="color:#dc3545;">● Full Booked</span>
                  @endif
                </span>
              </div>

              <div class="mt-4 d-grid gap-2">
                @if($destination->status === 'Available')
                  <a href="{{ route('v1.frontend.tours') }}?destination={{ $destination->id }}" class="btn btn-book">
                    <i class="bi bi-suitcase-lg me-2"></i>Book a Tour
                  </a>
                @else
                  <button class="btn btn-book" disabled style="opacity:0.6;cursor:not-allowed;">
                    <i class="bi bi-x-circle me-2"></i>Currently Full
                  </button>
                @endif
                <a href="{{ route('v1.frontend.destinasi') }}" class="btn-back text-center d-block">
                  <i class="bi bi-arrow-left me-1"></i>All Destinations
                </a>
              </div>
            </div><!-- End Sidebar -->

          </div><!-- End Right Column -->

        </div><!-- End Row -->

      </div>
    </section>

  </main>

  <footer id="footer" class="footer position-relative dark-background">
    <div class="container">
      <div class="row gy-5">
        <div class="col-lg-4">
          <div class="footer-content">
            <a href="{{ route('v1.frontend.beranda') }}" class="logo d-flex align-items-center mb-4">
              <span class="sitename">TravelTime</span>
            </a>
            <p class="mb-4">Discover amazing destinations and create unforgettable travel memories with TravelTime.</p>
            <div class="social-links">
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-twitter-x"></i></a>
              <a href="#"><i class="bi bi-instagram"></i></a>
              <a href="#"><i class="bi bi-youtube"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-6">
          <div class="footer-links">
            <h4>Explore</h4>
            <ul>
              <li><a href="{{ route('v1.frontend.beranda') }}"><i class="bi bi-chevron-right"></i> Home</a></li>
              <li><a href="{{ route('v1.frontend.about') }}"><i class="bi bi-chevron-right"></i> About</a></li>
              <li><a href="{{ route('v1.frontend.destinasi') }}"><i class="bi bi-chevron-right"></i> Destinations</a></li>
              <li><a href="{{ route('v1.frontend.tours') }}"><i class="bi bi-chevron-right"></i> Tours</a></li>
              <li><a href="{{ route('v1.frontend.gallery') }}"><i class="bi bi-chevron-right"></i> Gallery</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="footer-contact">
            <h4>Get in Touch</h4>
            <div class="contact-item">
              <div class="contact-icon"><i class="bi bi-telephone"></i></div>
              <div class="contact-info"><p>+1 (555) 987-6543</p></div>
            </div>
            <div class="contact-item">
              <div class="contact-icon"><i class="bi bi-envelope"></i></div>
              <div class="contact-info"><p>contact@traveltime.com</p></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">TravelTime</strong> <span>All Rights Reserved</span></p>
          </div>
          <div class="col-lg-6">
            <div class="credits">Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a></div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('frontend/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('frontend/js/main.js') }}"></script>

</body>
</html>