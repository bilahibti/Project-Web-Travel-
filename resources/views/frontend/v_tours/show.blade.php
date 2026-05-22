<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ $package->packages_name }} - TravelTime</title>
  <meta name="description" content="{{ Str::limit(strip_tags($package->description), 160) }}">

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
    .tour-hero {
      position: relative;
      height: 500px;
      overflow: hidden;
    }
    .tour-hero img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .tour-hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(0,0,0,0.80) 0%, rgba(0,0,0,0.25) 60%, transparent 100%);
      display: flex;
      align-items: flex-end;
    }
    .tour-hero-content {
      padding: 2.5rem;
      color: #fff;
    }
    .tour-hero-content h1 {
      font-size: 2.4rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    .hero-meta span {
      margin-right: 1.2rem;
      font-size: 0.9rem;
      opacity: 0.9;
    }
    .hero-meta i { margin-right: 4px; color: #e8a838; }

    .badge-type   { background: #e8a838; color: #fff; border-radius: 50px; }
    .badge-avail  { background: #28a745; color: #fff; border-radius: 50px; }
    .badge-full   { background: #dc3545; color: #fff; border-radius: 50px; }
    .badge-dom    { background: #0d6efd; color: #fff; border-radius: 50px; }
    .badge-intl   { background: #6610f2; color: #fff; border-radius: 50px; }

    .info-card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.08);
      padding: 1.8rem;
      margin-bottom: 1.5rem;
    }
    .info-card h4 {
      font-size: 1.05rem;
      font-weight: 700;
      color: #1a1a2e;
      border-bottom: 2px solid #e8a838;
      padding-bottom: 0.6rem;
      margin-bottom: 1.2rem;
    }

    .include-exclude .col {
      background: #f8f9fa;
      border-radius: 12px;
      padding: 1rem 1.2rem;
    }
    .include-list li, .exclude-list li {
      padding: 0.3rem 0;
      font-size: 0.92rem;
    }
    .include-list li::before { content: "✔ "; color: #28a745; font-weight: 700; }
    .exclude-list li::before { content: "✖ "; color: #dc3545; font-weight: 700; }
    .include-list, .exclude-list { list-style: none; padding-left: 0; }

    .detail-row {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.6rem 0;
      border-bottom: 1px solid #f0f0f0;
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-row i { color: #e8a838; font-size: 1.1rem; width: 22px; }
    .detail-row .label { color: #6c757d; font-size: 0.85rem; min-width: 110px; }
    .detail-row .value { font-weight: 600; color: #1a1a2e; }

    .price-box {
      background: linear-gradient(135deg, #1a1a2e, #2d2d4e);
      color: #fff;
      border-radius: 16px;
      padding: 1.8rem;
      text-align: center;
      margin-bottom: 1.5rem;
    }
    .price-box .price-label { font-size: 0.85rem; opacity: 0.7; margin-bottom: 0.2rem; }
    .price-box .price-amount { font-size: 2rem; font-weight: 800; color: #e8a838; line-height: 1; }
    .price-box .price-per { font-size: 0.8rem; opacity: 0.6; }

    .quota-bar-wrap { margin-top: 0.8rem; }
    .quota-label { display: flex; justify-content: space-between; font-size: 0.82rem; color: #6c757d; margin-bottom: 4px; }
    .quota-bar { background: #e9ecef; border-radius: 50px; height: 8px; overflow: hidden; }
    .quota-bar-fill { height: 100%; border-radius: 50px; background: linear-gradient(90deg, #e8a838, #f0c060); }

    .btn-book-main {
      background: linear-gradient(135deg, #e8a838, #d4911f);
      border: none;
      color: #fff;
      border-radius: 50px;
      padding: 0.75rem 1.8rem;
      font-weight: 700;
      font-size: 1rem;
      width: 100%;
      transition: opacity 0.2s;
    }
    .btn-book-main:hover { opacity: 0.9; color: #fff; }
    .btn-back {
      background: transparent;
      border: 2px solid #e8a838;
      color: #e8a838;
      border-radius: 50px;
      padding: 0.55rem 1.4rem;
      font-weight: 600;
      font-size: 0.9rem;
      transition: all 0.2s;
      text-decoration: none;
      width: 100%;
      display: block;
      text-align: center;
    }
    .btn-back:hover { background: #e8a838; color: #fff; }

    .related-card {
      border: none;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 2px 16px rgba(0,0,0,0.07);
      transition: transform 0.2s;
    }
    .related-card:hover { transform: translateY(-4px); }
    .related-card img { height: 160px; object-fit: cover; }

    .icon-feature {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      padding: 0.6rem 1rem;
      background: #f8f9fa;
      border-radius: 10px;
      font-size: 0.88rem;
      font-weight: 500;
    }
    .icon-feature i { color: #e8a838; font-size: 1.1rem; }
  </style>
</head>

<body class="tour-details-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ route('v1.frontend.beranda') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">TravelTime</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('v1.frontend.beranda') }}">Home</a></li>
          <li><a href="{{ route('v1.frontend.about') }}">About</a></li>
          <li><a href="{{ route('v1.frontend.destinasi') }}">Destinations</a></li>
          <li><a href="{{ route('v1.frontend.tours') }}" class="active">Tours</a></li>
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
    <div class="page-title dark-background" style="background-image: url({{ $package->foto ? asset('storage/img-packages/' . $package->foto) : asset('frontend/img/travel/showcase-8.webp') }});">
      <div class="container position-relative">
        <h1>{{ $package->packages_name }}</h1>
        <p>
          @if($package->destination)
            {{ $package->destination->city ?? '' }}, {{ $package->destination->country ?? '' }}
          @endif
        </p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('v1.frontend.beranda') }}">Home</a></li>
            <li><a href="{{ route('v1.frontend.tours') }}">Tours</a></li>
            <li class="current">{{ $package->packages_name }}</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Tour Detail Section -->
    <section class="section py-5">
      <div class="container">

        <div class="row g-4">

          <!-- LEFT: Main Content -->
          <div class="col-lg-8">

            <!-- Hero Image -->
            <div class="tour-hero rounded-4 mb-4">
              @if($package->foto)
                <img src="{{ asset('storage/img-packages/' . $package->foto) }}" alt="{{ $package->packages_name }}">
              @else
                <img src="{{ asset('frontend/img/travel/showcase-8.webp') }}" alt="{{ $package->packages_name }}">
              @endif
              <div class="tour-hero-overlay">
                <div class="tour-hero-content">
                  <div class="mb-2 d-flex flex-wrap gap-2">
                    <span class="badge badge-type px-3 py-2">{{ $package->package_type }}</span>
                    @if($package->status === 'Available')
                      <span class="badge badge-avail px-3 py-2"><i class="bi bi-check-circle me-1"></i>Available</span>
                    @else
                      <span class="badge badge-full px-3 py-2"><i class="bi bi-x-circle me-1"></i>Full Booked</span>
                    @endif
                  </div>
                  <h1>{{ $package->packages_name }}</h1>
                  <div class="hero-meta">
                    @if($package->destination)
                      <span><i class="bi bi-geo-alt-fill"></i>{{ $package->destination->destination_name }}</span>
                    @endif
                    <span><i class="bi bi-calendar3"></i>{{ $package->duration_days ?? '-' }} Days</span>
                    <span><i class="bi bi-people-fill"></i>Max {{ $package->max_persons ?? $package->quota }} Persons</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Quick Feature Icons -->
            <div class="row g-2 mb-4">
              <div class="col-6 col-md-3">
                <div class="icon-feature">
                  <i class="bi bi-calendar3"></i>
                  <div>
                    <div style="font-size:0.75rem;color:#aaa;">Duration</div>
                    <strong>{{ $package->duration_days ?? '-' }} Days</strong>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="icon-feature">
                  <i class="bi bi-people"></i>
                  <div>
                    <div style="font-size:0.75rem;color:#aaa;">Group Size</div>
                    <strong>Max {{ $package->max_persons ?? $package->quota }}</strong>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="icon-feature">
                  <i class="bi bi-globe2"></i>
                  <div>
                    <div style="font-size:0.75rem;color:#aaa;">Tour Type</div>
                    <strong>{{ $package->package_type }}</strong>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="icon-feature">
                  <i class="bi bi-check2-circle"></i>
                  <div>
                    <div style="font-size:0.75rem;color:#aaa;">Status</div>
                    <strong style="color:{{ $package->status === 'Available' ? '#28a745' : '#dc3545' }}">{{ $package->status }}</strong>
                  </div>
                </div>
              </div>
            </div>

            <!-- Description -->
            <div class="info-card">
              <h4><i class="bi bi-info-circle me-2"></i>Tour Description</h4>
              <div style="line-height:1.85;color:#444;">
                {!! nl2br(e($package->description)) !!}
              </div>
            </div>

            <!-- Include & Exclude -->
            <div class="info-card">
              <h4><i class="bi bi-list-check me-2"></i>What's Included & Excluded</h4>
              <div class="row g-3 include-exclude">
                <div class="col-md-6">
                  <div class="col h-100">
                    <h6 class="fw-bold text-success mb-3"><i class="bi bi-check-circle-fill me-1"></i>Included</h6>
                    <ul class="include-list mb-0">
                      @foreach(explode(',', $package->include) as $item)
                        @if(trim($item))
                          <li>{{ trim($item) }}</li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="col h-100">
                    <h6 class="fw-bold text-danger mb-3"><i class="bi bi-x-circle-fill me-1"></i>Not Included</h6>
                    <ul class="exclude-list mb-0">
                      @foreach(explode(',', $package->exclude) as $item)
                        @if(trim($item))
                          <li>{{ trim($item) }}</li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Hotel & Transportation Info -->
            <div class="row g-3">
              @if($package->hotel)
              <div class="col-md-6">
                <div class="info-card h-100" style="margin-bottom:0;">
                  <h4><i class="bi bi-building me-2"></i>Accommodation</h4>
                  <div class="d-flex align-items-start gap-3">
                    @if($package->hotel->foto)
                      <img src="{{ asset('storage/img-hotel/' . $package->hotel->foto) }}" alt="{{ $package->hotel->hotel_name }}" class="rounded-3" style="width:70px;height:70px;object-fit:cover;">
                    @else
                      <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:70px;height:70px;background:#f0f0f0;">
                        <i class="bi bi-building" style="font-size:1.6rem;color:#ccc;"></i>
                      </div>
                    @endif
                    <div>
                      <div class="fw-bold">{{ $package->hotel->hotel_name }}</div>
                      <div class="text-muted small">{{ $package->hotel->city ?? '' }}</div>
                      @if($package->hotel->star_rating ?? false)
                        <div>
                          @for($i=0; $i < ($package->hotel->star_rating ?? 3); $i++)
                            <i class="bi bi-star-fill text-warning" style="font-size:0.75rem;"></i>
                          @endfor
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              @endif

              @if($package->transportation)
              <div class="col-md-6">
                <div class="info-card h-100" style="margin-bottom:0;">
                  <h4><i class="bi bi-truck me-2"></i>Transportation</h4>
                  <div class="d-flex align-items-start gap-3">
                    @if($package->transportation->foto)
                      <img src="{{ asset('storage/img-transportation/' . $package->transportation->foto) }}" alt="{{ $package->transportation->transportation_name }}" class="rounded-3" style="width:70px;height:70px;object-fit:cover;">
                    @else
                      <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:70px;height:70px;background:#f0f0f0;">
                        <i class="bi bi-bus-front" style="font-size:1.6rem;color:#ccc;"></i>
                      </div>
                    @endif
                    <div>
                      <div class="fw-bold">{{ $package->transportation->transportation_name }}</div>
                      <div class="text-muted small">{{ $package->transportation->transportation_type ?? '' }}</div>
                      @if($package->transportation->capacity ?? false)
                        <div class="text-muted small">Capacity: {{ $package->transportation->capacity }}</div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              @endif
            </div>

            <!-- Destination Info (if any) -->
            @if($package->destination)
            <div class="info-card mt-3">
              <h4><i class="bi bi-map me-2"></i>Destination</h4>
              <div class="d-flex align-items-start gap-3">
                @if($package->destination->foto)
                  <img src="{{ asset('storage/img-destination/' . $package->destination->foto) }}" alt="{{ $package->destination->destination_name }}" class="rounded-3" style="width:80px;height:80px;object-fit:cover;">
                @endif
                <div>
                  <div class="fw-bold fs-5">{{ $package->destination->destination_name }}</div>
                  <div class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $package->destination->city }}, {{ $package->destination->country }}</div>
                  <p class="mt-2 mb-0 small text-muted">{{ Str::limit($package->destination->description ?? '', 150) }}</p>
                  <a href="{{ route('v1.frontend.destination.show', $package->destination->id) }}" class="small" style="color:#e8a838;">View destination &rarr;</a>
                </div>
              </div>
            </div>
            @endif

          </div><!-- End Left Column -->

          <!-- RIGHT: Booking Sidebar -->
          <div class="col-lg-4">

            <!-- Price Box -->
            <div class="price-box">
              <div class="price-label">Price per person</div>
              <div class="price-amount">Rp {{ number_format($package->price_packages, 0, ',', '.') }}</div>
              <div class="price-per">per person / package</div>
            </div>

            <!-- Booking Card -->
            <div class="info-card">
              <h4><i class="bi bi-calendar-check me-2"></i>Book This Tour</h4>

              <!-- Quota Progress -->
              @php
                $booked  = $package->booked ?? 0;
                $quota   = $package->quota;
                $avail   = max(0, $quota - $booked);
                $pct     = $quota > 0 ? min(100, round(($booked / $quota) * 100)) : 0;
              @endphp
              <div class="quota-bar-wrap mb-3">
                <div class="quota-label">
                  <span>{{ $booked }} booked</span>
                  <span>{{ $avail }} spots left</span>
                </div>
                <div class="quota-bar">
                  <div class="quota-bar-fill" style="width: {{ $pct }}%"></div>
                </div>
              </div>

              @auth
                @if($package->status === 'Available' && $avail > 0)
                  <form action="{{ route('v1.booking.package') }}" method="POST">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">

                    <div class="mb-3">
                      <label class="form-label fw-semibold" style="font-size:0.9rem;">Travel Date</label>
                      <input type="date" name="travel_date" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label fw-semibold" style="font-size:0.9rem;">Number of Persons</label>
                      <select name="persons" class="form-select">
                        @for($i = 1; $i <= min($avail, $package->max_persons ?? 10); $i++)
                          <option value="{{ $i }}">{{ $i }} Person{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                      </select>
                    </div>

                    <button type="submit" class="btn btn-book-main">
                      <i class="bi bi-bag-check me-2"></i>Book Now
                    </button>
                  </form>
                @elseif($package->status === 'Full Booked' || $avail <= 0)
                  <div class="alert alert-danger text-center py-3" style="border-radius:12px;">
                    <i class="bi bi-exclamation-circle d-block mb-1" style="font-size:1.5rem;"></i>
                    <strong>Sorry, this tour is fully booked.</strong>
                    <p class="mb-0 small mt-1">Please check other available tours.</p>
                  </div>
                  <a href="{{ route('v1.frontend.tours') }}" class="btn-back mt-2">Browse Other Tours</a>
                @endif
              @else
                <div class="alert alert-info text-center py-3" style="border-radius:12px;">
                  <i class="bi bi-person-lock d-block mb-1" style="font-size:1.5rem;"></i>
                  <strong>Login to Book</strong>
                  <p class="small mb-0 mt-1">You need to login to book this tour.</p>
                </div>
                <a href="{{ route('v1.frontend.login.login') }}" class="btn btn-book-main d-block text-center text-decoration-none" style="line-height:2.2;">
                  <i class="bi bi-box-arrow-in-right me-2"></i>Login to Book
                </a>
              @endauth

              <a href="{{ route('v1.frontend.tours') }}" class="btn-back mt-3">
                <i class="bi bi-arrow-left me-1"></i>Back to Tours
              </a>
            </div>

            <!-- Tour Summary Card -->
            <div class="info-card">
              <h4><i class="bi bi-card-checklist me-2"></i>Tour Summary</h4>

              <div class="detail-row">
                <i class="bi bi-calendar3"></i>
                <span class="label">Duration</span>
                <span class="value">{{ $package->duration_days ?? '-' }} Days</span>
              </div>
              <div class="detail-row">
                <i class="bi bi-people-fill"></i>
                <span class="label">Max Group</span>
                <span class="value">{{ $package->max_persons ?? $package->quota }} persons</span>
              </div>
              <div class="detail-row">
                <i class="bi bi-globe2"></i>
                <span class="label">Tour Type</span>
                <span class="value">{{ $package->package_type }}</span>
              </div>
              @if($package->destination)
              <div class="detail-row">
                <i class="bi bi-geo-alt-fill"></i>
                <span class="label">Destination</span>
                <span class="value">{{ $package->destination->city ?? '-' }}</span>
              </div>
              @endif
              @if($package->hotel)
              <div class="detail-row">
                <i class="bi bi-building"></i>
                <span class="label">Hotel</span>
                <span class="value">{{ Str::limit($package->hotel->hotel_name, 20) }}</span>
              </div>
              @endif
              @if($package->transportation)
              <div class="detail-row">
                <i class="bi bi-bus-front"></i>
                <span class="label">Transport</span>
                <span class="value">{{ Str::limit($package->transportation->transportation_name, 20) }}</span>
              </div>
              @endif
              <div class="detail-row">
                <i class="bi bi-ticket-perforated"></i>
                <span class="label">Quota Left</span>
                <span class="value" style="color:{{ $avail > 0 ? '#28a745' : '#dc3545' }}">{{ $avail }} spots</span>
              </div>
            </div>

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

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('frontend/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('frontend/js/main.js') }}"></script>

</body>
</html>