<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Detail Booking - TravelTime</title>
  <meta name="description" content="">

  <!-- Favicons -->
  <link href="{{ asset('frontend/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('frontend/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

  <!-- Main CSS -->
  <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
</head>

<body class="booking-page">

  <!-- HEADER -->
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
          <a class="btn-getstarted" href="{{ route('v1.booking.index') }}" style="background:#0d6efd;">
            <i class="bi bi-journal-bookmark-fill me-1"></i> My Bookings
          </a>
        @else
          <a class="btn-getstarted" href="{{ route('v1.frontend.login.login') }}">Login</a>
        @endauth
      </div>
    </div>
  </header>

  <main class="main">

    <!-- Hero -->
    <div class="page-title dark-background" style="background-image: url({{ asset('frontend/img/travel/showcase-5.webp') }});">
      <div class="container position-relative">
        <h1>Detail Booking</h1>
        <p>Informasi lengkap pemesanan Anda.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('v1.frontend.dashboard') }}">Home</a></li>
            <li><a href="{{ route('v1.booking.index') }}">My Bookings</a></li>
            <li class="current">Detail</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="section" style="padding: 40px 0 80px;">
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

        <!-- Status Bar (Top Card) -->
        <div class="booking-status-bar mb-4">
          <div class="row align-items-center">
            <div class="col-md-6">
              <div class="booking-code mb-1">
                <i class="bi bi-hash"></i>{{ $booking->booking_code }}
              </div>
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="status-badge status-{{ $booking->status }}">
                  {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                </span>
                <span class="text-muted" style="font-size:0.82rem;">
                  <i class="bi bi-clock me-1"></i>Dibuat {{ $booking->created_at->format('d M Y, H:i') }}
                </span>
              </div>
            </div>
            <div class="col-md-6 mt-3 mt-md-0 text-md-end">
              <div class="d-flex flex-wrap justify-content-md-end gap-2">
                <!-- Bayar (pending & belum lunas) -->
                @if($booking->status == 'pending' && !$booking->isPaid())
                  <a href="{{ route('v1.payment.show', $booking->id) }}" class="btn btn-success action-btn">
                    <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                  </a>
                @endif

                <!-- Cancel -->
                @if(in_array($booking->status, ['pending', 'confirmed']))
                  <form method="POST"
                        action="{{ route('v1.booking.cancel', $booking->id) }}"
                        onsubmit="return confirm('Yakin ingin membatalkan booking {{ $booking->booking_code }}?')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-outline-danger action-btn">
                      <i class="bi bi-x-circle me-1"></i>Batalkan
                    </button>
                  </form>
                @endif

                <a href="{{ route('v1.booking.index') }}" class="btn btn-outline-secondary action-btn">
                  <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4">

          <!-- Kolom Kiri -->
          <div class="col-lg-8">

            <!-- ====================================================
                 1. DETAIL PAKET / HOTEL / TRANSPORT
            ==================================================== -->

            @if($booking->type == 'package' && $booking->packages->isNotEmpty())
              @foreach($booking->packages as $pkg)
              <div class="info-card mb-4">
                <div class="card-title">
                  <i class="bi bi-map-fill me-2 text-primary"></i>Paket Wisata
                </div>
                <div class="info-row">
                  <span class="info-label">Nama Paket</span>
                  <span class="info-value">{{ $pkg->travelPackage->package_name ?? '-' }}</span>
                </div>
                @if($pkg->travelPackage?->destination)
                <div class="info-row">
                  <span class="info-label">Destinasi</span>
                  <span class="info-value">
                    {{ $pkg->travelPackage->destination->destination_name ?? '-' }},
                    {{ $pkg->travelPackage->destination->country ?? '' }}
                  </span>
                </div>
                @endif
                <div class="info-row">
                  <span class="info-label">Durasi</span>
                  <span class="info-value">{{ $pkg->travelPackage->duration_days ?? '-' }} Hari</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Jumlah Orang</span>
                  <span class="info-value">{{ $pkg->persons }} Orang</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Harga per Orang</span>
                  <span class="info-value">Rp {{ number_format($pkg->unit_price, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Tanggal Berangkat</span>
                  <span class="info-value">{{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Tanggal Kembali</span>
                  <span class="info-value">{{ \Carbon\Carbon::parse($booking->return_date)->format('d M Y') }}</span>
                </div>
                @if($pkg->travelPackage?->description)
                <div class="mt-3 p-3 rounded-2" style="background:#f8f9fa;font-size:0.87rem;color:#555;">
                  <strong>Deskripsi:</strong><br>
                  {{ Str::limit($pkg->travelPackage->description, 300) }}
                </div>
                @endif
              </div>
              @endforeach

            @elseif($booking->type == 'hotel' && $booking->hotels->isNotEmpty())
              @foreach($booking->hotels as $bh)
              <div class="info-card mb-4">
                <div class="card-title">
                  <i class="bi bi-building-fill me-2" style="color:#7e22ce;"></i>Detail Hotel
                </div>
                <div class="info-row">
                  <span class="info-label">Nama Hotel</span>
                  <span class="info-value">{{ $bh->hotel->hotel_name ?? '-' }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Tipe Kamar</span>
                  <span class="info-value">{{ $bh->room->room_type ?? '-' }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Check-in</span>
                  <span class="info-value">{{ \Carbon\Carbon::parse($bh->check_in)->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Check-out</span>
                  <span class="info-value">{{ \Carbon\Carbon::parse($bh->check_out)->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Jumlah Kamar</span>
                  <span class="info-value">{{ $bh->rooms }} Kamar</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Harga per Malam</span>
                  <span class="info-value">Rp {{ number_format($bh->price_per_night, 0, ',', '.') }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Lama Menginap</span>
                  <span class="info-value">
                    {{ \Carbon\Carbon::parse($bh->check_in)->diffInDays($bh->check_out) }} Malam
                  </span>
                </div>
              </div>
              @endforeach

            @elseif($booking->type == 'transport' && $booking->transports->isNotEmpty())
              @foreach($booking->transports as $bt)
              <div class="info-card mb-4">
                <div class="card-title">
                  <i class="bi bi-truck me-2" style="color:#854d0e;"></i>Detail Transportasi
                </div>
                <div class="info-row">
                  <span class="info-label">Nama Kendaraan</span>
                  <span class="info-value">{{ $bt->transportation->vehicle_name ?? '-' }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Tipe</span>
                  <span class="info-value">{{ $bt->transportation->vehicle_type ?? '-' }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Tanggal Rental</span>
                  <span class="info-value">{{ \Carbon\Carbon::parse($bt->rental_date)->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Tanggal Kembali</span>
                  <span class="info-value">{{ \Carbon\Carbon::parse($bt->return_date)->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Jumlah Hari</span>
                  <span class="info-value">{{ $bt->days }} Hari</span>
                </div>
                <div class="info-row">
                  <span class="info-label">Harga per Hari</span>
                  <span class="info-value">Rp {{ number_format($bt->price_per_day, 0, ',', '.') }}</span>
                </div>
                @if($bt->pickup_location)
                <div class="info-row">
                  <span class="info-label">Lokasi Pickup</span>
                  <span class="info-value">{{ $bt->pickup_location }}</span>
                </div>
                @endif
                @if($bt->dropoff_location)
                <div class="info-row">
                  <span class="info-label">Lokasi Drop-off</span>
                  <span class="info-value">{{ $bt->dropoff_location }}</span>
                </div>
                @endif
                @if($bt->special_request)
                <div class="info-row">
                  <span class="info-label">Catatan Khusus</span>
                  <span class="info-value">{{ $bt->special_request }}</span>
                </div>
                @endif
              </div>
              @endforeach
            @endif

            <!-- ====================================================
                 2. INFO KONTAK PEMESAN
            ==================================================== -->
            <div class="info-card mb-4">
              <div class="card-title">
                <i class="bi bi-person-fill me-2 text-info"></i>Informasi Kontak
              </div>
              <div class="contact-card">
                <div class="row g-3">
                  <div class="col-md-4 text-center">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-2"
                         style="width:56px;height:56px;">
                      <i class="bi bi-person-fill text-white" style="font-size:1.4rem;"></i>
                    </div>
                    <div style="font-size:0.82rem;color:#6c757d;">Nama</div>
                    <div class="fw-600">{{ $booking->contact_name }}</div>
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-2"
                         style="width:56px;height:56px;">
                      <i class="bi bi-telephone-fill text-white" style="font-size:1.2rem;"></i>
                    </div>
                    <div style="font-size:0.82rem;color:#6c757d;">Telepon</div>
                    <div class="fw-600">{{ $booking->contact_phone }}</div>
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center mb-2"
                         style="width:56px;height:56px;">
                      <i class="bi bi-envelope-fill text-white" style="font-size:1.2rem;"></i>
                    </div>
                    <div style="font-size:0.82rem;color:#6c757d;">Email</div>
                    <div class="fw-600" style="word-break:break-all;font-size:0.9rem;">{{ $booking->contact_email }}</div>
                  </div>
                </div>
              </div>
              @if($booking->notes)
              <div class="mt-3 p-3 rounded-2" style="background:#fff3cd;font-size:0.87rem;">
                <i class="bi bi-sticky-fill me-2 text-warning"></i>
                <strong>Catatan:</strong> {{ $booking->notes }}
              </div>
              @endif
            </div>

            <!-- ====================================================
                 3. RIWAYAT PEMBAYARAN
            ==================================================== -->
            <div class="info-card">
              <div class="card-title">
                <i class="bi bi-receipt me-2 text-success"></i>Riwayat Pembayaran
              </div>
              @if($booking->payments && $booking->payments->isNotEmpty())
                @foreach($booking->payments as $payment)
                <div class="payment-history-item d-flex align-items-center justify-content-between">
                  <div>
                    <div class="fw-bold" style="color:#1a1a2e;">
                      Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </div>
                    <div style="font-size:0.82rem;color:#6c757d;">
                      <i class="bi bi-credit-card me-1"></i>
                      {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                      &nbsp;·&nbsp;
                      @if($payment->paid_at)
                        <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') }}
                      @endif
                    </div>
                  </div>
                  <span class="badge
                    {{ $payment->status == 'paid' ? 'bg-success' : ($payment->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}
                    rounded-pill px-3">
                    {{ ucfirst($payment->status) }}
                  </span>
                </div>
                @endforeach
              @else
                <div class="text-center py-4 text-muted">
                  <i class="bi bi-credit-card-2-back" style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:.4;"></i>
                  Belum ada pembayaran.
                  @if($booking->status == 'pending')
                    <br>
                    <a href="{{ route('v1.payment.show', $booking->id) }}" class="btn btn-success btn-sm rounded-pill mt-3">
                      <i class="bi bi-credit-card me-1"></i>Lakukan Pembayaran
                    </a>
                  @endif
                </div>
              @endif
            </div>

          </div><!-- /Kolom Kiri -->

          <!-- Kolom Kanan (Ringkasan Harga & Timeline) -->
          <div class="col-lg-4">

            <!-- Ringkasan Harga -->
            <div class="price-section mb-4">
              <div style="font-size:1rem;font-weight:700;opacity:.85;margin-bottom:16px;">
                <i class="bi bi-receipt-cutoff me-2"></i>Ringkasan Harga
              </div>
              <div class="price-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
              </div>
              @if($booking->discount && $booking->discount > 0)
              <div class="price-row">
                <span>Diskon</span>
                <span>- Rp {{ number_format($booking->discount, 0, ',', '.') }}</span>
              </div>
              @endif
              <div class="price-row">
                <span>Pajak (PPN 11%)</span>
                <span>Rp {{ number_format($booking->tax, 0, ',', '.') }}</span>
              </div>
              <div class="price-total d-flex justify-content-between">
                <span>Total</span>
                <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
              </div>
            </div>

            <!-- Status Pesanan / Timeline -->
            <div class="info-card mb-4">
              <div class="card-title">
                <i class="bi bi-list-check me-2 text-primary"></i>Status Pesanan
              </div>

              @php
                $steps = [
                  ['label' => 'Booking Dibuat',  'icon' => 'bi-journal-plus',   'done' => true],
                  ['label' => 'Menunggu Pembayaran', 'icon' => 'bi-hourglass-split', 'done' => in_array($booking->status, ['pending','confirmed','in_progress','completed'])],
                  ['label' => 'Pembayaran Dikonfirmasi', 'icon' => 'bi-credit-card-2-front', 'done' => $booking->isPaid()],
                  ['label' => 'Booking Dikonfirmasi', 'icon' => 'bi-check-circle', 'done' => in_array($booking->status, ['confirmed','in_progress','completed'])],
                  ['label' => 'Perjalanan Selesai', 'icon' => 'bi-trophy',       'done' => $booking->status == 'completed'],
                ];
              @endphp

              @foreach($steps as $step)
              <div class="timeline-step">
                <div class="step-icon {{ $step['done'] ? 'step-active' : 'step-pending' }}">
                  <i class="bi {{ $step['icon'] }}"></i>
                </div>
                <div class="pt-1">
                  <div style="font-size:0.88rem;font-weight:{{ $step['done'] ? '600' : '400' }};color:{{ $step['done'] ? '#0f5132' : '#6c757d' }};">
                    {{ $step['label'] }}
                  </div>
                </div>
              </div>
              @endforeach

              @if($booking->status == 'cancelled')
              <div class="mt-3 p-3 rounded-2" style="background:#f8d7da;">
                <i class="bi bi-x-circle-fill text-danger me-2"></i>
                <strong class="text-danger">Booking Dibatalkan</strong>
              </div>
              @endif
            </div>

            <!-- Butuh Bantuan? -->
            <div class="info-card">
              <div class="card-title">
                <i class="bi bi-headset me-2 text-warning"></i>Butuh Bantuan?
              </div>
              <p class="text-muted" style="font-size:0.87rem;">Tim kami siap membantu 24/7. Hubungi kami dengan kode booking Anda.</p>
              <div class="booking-code mb-3" style="font-size:0.9rem;">{{ $booking->booking_code }}</div>
              <a href="https://wa.me/6221123456" target="_blank" class="btn btn-success btn-sm rounded-pill w-100">
                <i class="bi bi-whatsapp me-2"></i>Chat via WhatsApp
              </a>
              <a href="mailto:support@traveltime.id" class="btn btn-outline-secondary btn-sm rounded-pill w-100 mt-2">
                <i class="bi bi-envelope me-2"></i>Kirim Email
              </a>
            </div>

          </div><!-- /Kolom Kanan -->

        </div><!-- /row -->

      </div>
    </section>

  </main>

  <!-- FOOTER -->
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

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>
  <div id="preloader"></div>

  <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('frontend/js/main.js') }}"></script>

</body>
</html>