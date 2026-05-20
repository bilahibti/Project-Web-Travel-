<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pembayaran - TravelTime</title>
  <meta name="description" content="">

  <!-- Favicons -->
  <link href="{{ asset('frontend/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('frontend/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

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
          <li><a href="{{ route('v1.frontend.destination') }}">Destinations</a></li>
          <li><a href="{{ route('v1.frontend.tours') }}">Tours</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div class="d-flex align-items-center gap-2">
        @auth
          <a class="btn-getstarted" href="{{ route('v1.booking.index') }}" style="background:#0d6efd;">
            <i class="bi bi-journal-bookmark-fill me-1"></i> My Bookings
          </a>
        @endauth
      </div>
    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url({{ asset('frontend/img/travel/showcase-7.webp') }});">
      <div class="container position-relative">
        <h1>Pembayaran</h1>
        <p>Selesaikan pembayaran Anda untuk mengkonfirmasi booking.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('v1.frontend.dashboard') }}">Home</a></li>
            <li><a href="{{ route('v1.booking.index') }}">My Bookings</a></li>
            <li><a href="{{ route('v1.booking.show', $booking->id) }}">Detail</a></li>
            <li class="current">Pembayaran</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="section" style="padding: 50px 0 80px;">
      <div class="container">

        <!-- Flash Messages -->
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        {{-- ========== SUDAH DIBAYAR ========== --}}
        @if($booking->isPaid())
          <div class="paid-banner mb-5">
            <i class="bi bi-check-circle-fill" style="font-size:4rem;display:block;margin-bottom:16px;"></i>
            <h3 class="fw-bold mb-2">Pembayaran Sudah Lunas!</h3>
            <p class="mb-4 opacity-75">Booking Anda telah dikonfirmasi. Silakan cek detail booking untuk informasi lebih lanjut.</p>
            <div class="booking-code text-white mb-4" style="font-size:1.2rem;letter-spacing:3px;">
              {{ $booking->booking_code }}
            </div>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
              <a href="{{ route('v1.booking.show', $booking->id) }}" class="btn btn-light rounded-pill px-5">
                <i class="bi bi-eye me-2"></i>Lihat Detail Booking
              </a>
              <a href="{{ route('v1.booking.index') }}" class="btn btn-outline-light rounded-pill px-5">
                <i class="bi bi-journal-bookmark me-2"></i>Semua Booking
              </a>
            </div>
          </div>

          {{-- Riwayat Pembayaran --}}
          <div class="payment-form-card">
            <h5 class="fw-bold mb-4" style="color:#1a1a2e;">
              <i class="bi bi-receipt me-2 text-success"></i>Riwayat Pembayaran
            </h5>
            @foreach($booking->payments as $payment)
            <div class="d-flex align-items-center justify-content-between p-4 rounded-3 mb-3" style="background:#f8f9fa;">
              <div>
                <div class="fw-bold" style="font-size:1.1rem;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                <div style="font-size:0.82rem;color:#6c757d;">
                  <i class="bi bi-credit-card me-1"></i>
                  {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                  @if($payment->paid_at)
                    &nbsp;·&nbsp;<i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') }}
                  @endif
                </div>
              </div>
              <span class="badge bg-success rounded-pill px-3 py-2">Paid</span>
            </div>
            @endforeach
          </div>

        {{-- ========== BELUM DIBAYAR ========== --}}
        @else

          <div class="row g-5">

            <!-- Form Kiri -->
            <div class="col-lg-7">

              <!-- Security Bar -->
              <div class="security-bar mb-4">
                <i class="bi bi-shield-lock-fill" style="font-size:1.3rem;"></i>
                <span>Pembayaran Anda terlindungi. Semua transaksi dienkripsi dengan SSL 256-bit.</span>
              </div>

              <!-- Info Booking Singkat -->
              <div class="payment-form-card mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <div>
                    <h6 class="fw-bold mb-1" style="color:#1a1a2e;">
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
                    </h6>
                    <div class="booking-code">{{ $booking->booking_code }}</div>
                  </div>
                  <span class="booking-status-pill status-pending">Belum Dibayar</span>
                </div>

                <div class="row g-2" style="font-size:0.83rem;color:#6c757d;">
                  <div class="col-6">
                    <i class="bi bi-calendar-event me-1"></i>
                    {{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}
                  </div>
                  <div class="col-6">
                    <i class="bi bi-people me-1"></i>
                    {{ $booking->total_persons }}
                    {{ $booking->type == 'hotel' ? 'Kamar' : ($booking->type == 'transport' ? 'Unit' : 'Orang') }}
                  </div>
                  <div class="col-6">
                    <i class="bi bi-person me-1"></i>
                    {{ $booking->contact_name }}
                  </div>
                  <div class="col-6">
                    <i class="bi bi-telephone me-1"></i>
                    {{ $booking->contact_phone }}
                  </div>
                </div>
              </div>

              <!-- Form Pembayaran -->
              <div class="payment-form-card">
                <h5 class="fw-bold mb-1" style="color:#1a1a2e;">
                  <i class="bi bi-credit-card-2-front me-2 text-primary"></i>Pilih Metode Pembayaran
                </h5>
                <p class="text-muted mb-4" style="font-size:0.87rem;">Pilih salah satu metode pembayaran di bawah ini.</p>

                <form method="POST" action="{{ route('v1.payment.store') }}" id="paymentForm">
                  @csrf
                  <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                  <!-- Grid Metode Pembayaran -->
                  <div class="method-grid mb-4">

                    <label class="method-card">
                      <input type="radio" name="method" value="bank_transfer" required>
                      <div class="method-label">
                        <span class="method-icon">🏦</span>
                        <span>Transfer Bank</span>
                      </div>
                      <div class="check-indicator"><i class="bi bi-check2"></i></div>
                    </label>

                    <label class="method-card">
                      <input type="radio" name="method" value="credit_card">
                      <div class="method-label">
                        <span class="method-icon">💳</span>
                        <span>Kartu Kredit</span>
                      </div>
                      <div class="check-indicator"><i class="bi bi-check2"></i></div>
                    </label>

                    <label class="method-card">
                      <input type="radio" name="method" value="debit_card">
                      <div class="method-label">
                        <span class="method-icon">🪙</span>
                        <span>Kartu Debit</span>
                      </div>
                      <div class="check-indicator"><i class="bi bi-check2"></i></div>
                    </label>

                    <label class="method-card">
                      <input type="radio" name="method" value="e_wallet">
                      <div class="method-label">
                        <span class="method-icon">📱</span>
                        <span>E-Wallet</span>
                      </div>
                      <div class="check-indicator"><i class="bi bi-check2"></i></div>
                    </label>

                    <label class="method-card">
                      <input type="radio" name="method" value="virtual_account">
                      <div class="method-label">
                        <span class="method-icon">🔐</span>
                        <span>Virtual Account</span>
                      </div>
                      <div class="check-indicator"><i class="bi bi-check2"></i></div>
                    </label>

                    <label class="method-card">
                      <input type="radio" name="method" value="qris">
                      <div class="method-label">
                        <span class="method-icon">📷</span>
                        <span>QRIS</span>
                      </div>
                      <div class="check-indicator"><i class="bi bi-check2"></i></div>
                    </label>

                  </div>

                  @error('method')
                    <div class="alert alert-danger py-2 mb-3" style="font-size:0.85rem;">
                      <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                  @enderror

                  <!-- Info Metode yang Dipilih -->
                  <div id="methodInfo" class="mb-4" style="display:none;">
                    <div class="p-4 rounded-3" style="background:#eef3ff;border:1px solid #b8d0fb;">
                      <div id="methodInfoContent" style="font-size:0.88rem;color:#1a1a2e;"></div>
                    </div>
                  </div>

                  <!-- Konfirmasi -->
                  <div class="mb-4 p-3 rounded-2" style="background:#fff3cd;">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="agreeCheck" required>
                      <label class="form-check-label" for="agreeCheck" style="font-size:0.86rem;color:#664d03;">
                        Saya setuju dengan <a href="#" style="color:#0d6efd;">Syarat &amp; Ketentuan</a> dan
                        <a href="#" style="color:#0d6efd;">Kebijakan Privasi</a> TravelTime.
                        Total pembayaran sebesar <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                        akan ditagihkan kepada saya.
                      </label>
                    </div>
                  </div>

                  <!-- Tombol Bayar -->
                  <button type="submit" class="btn btn-primary pay-btn" id="payBtn" disabled>
                    <i class="bi bi-lock-fill me-2"></i>
                    Bayar Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                  </button>

                  <div class="text-center mt-3">
                    <a href="{{ route('v1.booking.show', $booking->id) }}" class="text-muted" style="font-size:0.85rem;">
                      <i class="bi bi-arrow-left me-1"></i>Kembali ke Detail Booking
                    </a>
                  </div>

                </form>
              </div>

            </div><!-- /Kiri -->

            <!-- Ringkasan Kanan -->
            <div class="col-lg-5">
              <div class="summary-card">
                <h5 class="fw-bold mb-4" style="color:#1a1a2e;">
                  <i class="bi bi-receipt-cutoff me-2 text-primary"></i>Ringkasan Pembayaran
                </h5>

                <!-- Detail Item -->
                <div class="mb-3 p-3 rounded-2" style="background:#f8f9fa;">
                  <div style="font-size:0.82rem;color:#6c757d;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">
                    @if($booking->type == 'package') 📦 Paket Tour
                    @elseif($booking->type == 'hotel') 🏨 Hotel
                    @else 🚗 Transportasi @endif
                  </div>
                  <div class="fw-bold" style="color:#1a1a2e;font-size:0.95rem;">
                    @if($booking->type == 'package' && $booking->packages->isNotEmpty())
                      {{ $booking->packages->first()->travelPackage->package_name ?? '-' }}
                    @elseif($booking->type == 'hotel' && $booking->hotels->isNotEmpty())
                      {{ $booking->hotels->first()->hotel->hotel_name ?? '-' }}
                    @elseif($booking->type == 'transport' && $booking->transports->isNotEmpty())
                      {{ $booking->transports->first()->transportation->vehicle_name ?? '-' }}
                    @endif
                  </div>
                  <div style="font-size:0.82rem;color:#6c757d;margin-top:4px;">
                    <i class="bi bi-calendar me-1"></i>
                    {{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}
                    @if($booking->return_date)
                      → {{ \Carbon\Carbon::parse($booking->return_date)->format('d M Y') }}
                    @endif
                  </div>
                </div>

                <div class="summary-row">
                  <span class="summary-label">Subtotal</span>
                  <span class="summary-value">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                </div>
                @if($booking->discount && $booking->discount > 0)
                <div class="summary-row">
                  <span class="summary-label">Diskon</span>
                  <span class="summary-value text-success">- Rp {{ number_format($booking->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="summary-row">
                  <span class="summary-label">PPN (11%)</span>
                  <span class="summary-value">Rp {{ number_format($booking->tax, 0, ',', '.') }}</span>
                </div>

                <div class="summary-total">
                  <span>Total Bayar</span>
                  <span class="amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>

                <!-- Metode yang dipilih (update via JS) -->
                <div id="selectedMethodDisplay" class="mt-3 p-3 rounded-2 text-center" style="background:#f8f9fa;display:none!important;">
                  <div style="font-size:0.82rem;color:#6c757d;">Metode Dipilih</div>
                  <div id="selectedMethodName" class="fw-bold" style="color:#0d6efd;font-size:0.95rem;"></div>
                </div>

                <!-- Jaminan -->
                <div class="mt-4">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-shield-check-fill text-success" style="font-size:1.1rem;"></i>
                    <span style="font-size:0.82rem;color:#0f5132;font-weight:600;">Pembayaran Aman & Terjamin</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-arrow-counterclockwise text-primary" style="font-size:1.1rem;"></i>
                    <span style="font-size:0.82rem;color:#495057;">Kebijakan pengembalian dana 24 jam</span>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-headset text-warning" style="font-size:1.1rem;"></i>
                    <span style="font-size:0.82rem;color:#495057;">Dukungan pelanggan 24/7</span>
                  </div>
                </div>

              </div>
            </div><!-- /Kanan -->

          </div><!-- /row -->

        @endif

      </div>
    </section>

  </main>

  <!-- FOOTER -->
  <footer id="footer" class="footer dark-background">
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
  <script src="{{ asset('frontend/js/main.js') }}"></script>

  <script>
    // ---- Method Info Content ----
    const methodInfoMap = {
      bank_transfer: {
        icon: '🏦',
        name: 'Transfer Bank',
        detail: `Transfer ke rekening BCA 123-456-7890 a/n PT TravelTime Indonesia.<br>
                 Konfirmasi transfer via WhatsApp ke <strong>+62 21 1234 5678</strong> dengan bukti transfer Anda.`
      },
      credit_card: {
        icon: '💳',
        name: 'Kartu Kredit',
        detail: `Kartu Visa, Mastercard, dan JCB diterima.<br>
                 Cicilan 0% tersedia untuk kartu BCA, Mandiri, BNI, dan BRI.`
      },
      debit_card: {
        icon: '🪙',
        name: 'Kartu Debit',
        detail: `Kartu debit berlogo GPN, Visa, dan Mastercard diterima.<br>
                 Pastikan saldo mencukupi sebelum melakukan pembayaran.`
      },
      e_wallet: {
        icon: '📱',
        name: 'E-Wallet',
        detail: `Didukung: GoPay, OVO, DANA, ShopeePay, dan LinkAja.<br>
                 QR code akan dikirim ke email Anda setelah mengkonfirmasi pembayaran.`
      },
      virtual_account: {
        icon: '🔐',
        name: 'Virtual Account',
        detail: `Nomor Virtual Account akan dikirimkan ke email <strong>{{ $booking->contact_email }}</strong>.<br>
                 Berlaku selama <strong>24 jam</strong> setelah pembayaran dikonfirmasi.`
      },
      qris: {
        icon: '📷',
        name: 'QRIS',
        detail: `Scan QR Code menggunakan aplikasi mobile banking atau dompet digital Anda.<br>
                 QR Code akan tampil setelah mengkonfirmasi pembayaran.`
      },
    };

    const radios = document.querySelectorAll('input[name="method"]');
    const methodInfo = document.getElementById('methodInfo');
    const methodInfoContent = document.getElementById('methodInfoContent');
    const selectedMethodDisplay = document.getElementById('selectedMethodDisplay');
    const selectedMethodName = document.getElementById('selectedMethodName');
    const agreeCheck = document.getElementById('agreeCheck');
    const payBtn = document.getElementById('payBtn');

    let methodSelected = false;
    let agreed = false;

    function updatePayBtn() {
      if (payBtn) payBtn.disabled = !(methodSelected && agreed);
    }

    radios.forEach(radio => {
      radio.addEventListener('change', function () {
        const info = methodInfoMap[this.value];
        if (info) {
          methodInfoContent.innerHTML = `<strong>${info.icon} ${info.name}</strong><br><span style="color:#555;margin-top:6px;display:block;">${info.detail}</span>`;
          methodInfo.style.display = 'block';

          selectedMethodName.textContent = `${info.icon} ${info.name}`;
          selectedMethodDisplay.style.removeProperty('display');
          selectedMethodDisplay.style.display = 'block';
        }
        methodSelected = true;
        updatePayBtn();
      });
    });

    if (agreeCheck) {
      agreeCheck.addEventListener('change', function () {
        agreed = this.checked;
        updatePayBtn();
      });
    }
  </script>

</body>
</html>