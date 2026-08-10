<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<title>Invoice Pembayaran - {{ $pembayaran->kode_pembayaran }}</title>
<style>
  @page {
    margin: 0px;
    size: A4 portrait;
  }
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  body {
    font-family: 'Helvetica', 'Arial', sans-serif;
    font-size: 9.5pt;
    color: #1E293B;
    background: #FFFFFF;
    line-height: 1.5;
    padding: 45px 50px 45px 50px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }

  /* BRAND HEADER */
  .brand-table {
    width: 100%;
    margin-bottom: 6px;
  }
  .brand-title {
    font-size: 15pt;
    font-weight: bold;
    color: #131218;
    letter-spacing: 0.5px;
    text-transform: uppercase;
  }
  .brand-sub {
    font-size: 8pt;
    color: #64748B;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-top: 2px;
  }

  /* INVOICE BIG TITLE RIGHT */
  .inv-big-title {
    font-size: 24pt;
    font-weight: bold;
    color: #131218;
    letter-spacing: 2px;
    text-transform: uppercase;
    text-align: right;
    line-height: 1;
  }
  .yellow-accent-box {
    display: inline-block;
    width: 16px;
    height: 22px;
    background: #FFC81A;
    margin-left: 6px;
    vertical-align: middle;
  }

  /* YELLOW STRIP BAR */
  .yellow-header-bar {
    width: 100%;
    height: 10px;
    background: #FFC81A;
    margin-top: 12px;
    margin-bottom: 26px;
    border-radius: 2px;
  }

  /* META TWO COLUMN SECTION */
  .meta-container {
    width: 100%;
    margin-bottom: 26px;
  }
  .meta-container td {
    vertical-align: top;
  }

  .meta-label-heading {
    font-size: 9.5pt;
    font-weight: bold;
    color: #131218;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
  }
  .client-name {
    font-size: 13pt;
    font-weight: bold;
    color: #131218;
    margin-bottom: 4px;
  }
  .client-detail {
    font-size: 9pt;
    color: #475569;
    line-height: 1.5;
  }

  .meta-info-table {
    width: 100%;
  }
  .meta-info-table td {
    padding: 3px 0;
    font-size: 9pt;
  }
  .meta-info-lbl {
    color: #475569;
    font-weight: bold;
    text-align: left;
    width: 38%;
  }
  .meta-info-val {
    color: #131218;
    font-weight: bold;
    text-align: right;
  }

  /* ITEMS TABLE */
  .items-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 22px;
    border: 1px solid #CBD5E1;
  }
  .items-table th {
    background: #1E1D26;
    color: #FFFFFF;
    font-size: 9pt;
    font-weight: bold;
    padding: 10px 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
  }
  .items-table td {
    padding: 11px 12px;
    font-size: 9pt;
    color: #334155;
    border-bottom: 1px solid #E2E8F0;
  }
  .items-table tr:nth-child(even) td {
    background: #F8FAFC;
  }
  .text-center { text-align: center; }
  .text-right { text-align: right; }
  .text-bold { font-weight: bold; color: #131218; }

  /* SUMMARY BREAKDOWN */
  .summary-table {
    width: 48%;
    margin-left: auto;
    margin-bottom: 28px;
  }
  .summary-table td {
    padding: 6px 10px;
    font-size: 9pt;
  }
  .summary-lbl {
    color: #475569;
    font-weight: bold;
    text-align: left;
  }
  .summary-val {
    color: #131218;
    font-weight: bold;
    text-align: right;
  }
  
  /* YELLOW TOTAL ROW */
  .total-yellow-row td {
    background: #FFC81A !important;
    color: #131218 !important;
    font-size: 11.5pt !important;
    font-weight: bold !important;
    padding: 10px 12px !important;
  }

  /* BOTTOM SECTION */
  .bottom-grid {
    width: 100%;
    margin-top: 10px;
  }
  .bottom-grid td {
    vertical-align: top;
  }

  .section-title {
    font-size: 9.5pt;
    font-weight: bold;
    color: #131218;
    margin-bottom: 4px;
  }
  .section-desc {
    font-size: 8.5pt;
    color: #64748B;
    line-height: 1.5;
  }

  .payment-box {
    margin-top: 14px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    padding: 10px 12px;
  }
  .payment-box-title {
    font-size: 9pt;
    font-weight: bold;
    color: #131218;
    margin-bottom: 6px;
    text-transform: uppercase;
  }
  .payment-detail-row {
    font-size: 8.5pt;
    color: #334155;
    margin-bottom: 3px;
  }
  .payment-detail-lbl {
    color: #64748B;
    display: inline-block;
    width: 95px;
    font-weight: bold;
  }

  .signature-area {
    text-align: center;
    padding-top: 10px;
  }
  .signature-line {
    width: 150px;
    border-top: 1.5px solid #131218;
    margin: 50px auto 6px;
  }
  .signature-label {
    font-size: 9pt;
    font-weight: bold;
    color: #131218;
  }

  /* FOOTER BAR WITH ACCENT LINE */
  .bottom-footer-bar {
    margin-top: 36px;
    border-top: 2.5px solid #FFC81A;
    padding-top: 12px;
    text-align: center;
    font-size: 8pt;
    color: #64748B;
    font-weight: bold;
  }
</style>
</head>
<body>

<!-- Header Top Table -->
<table class="brand-table">
  <tr>
    <td style="vertical-align: middle;">
      <table style="width: auto; border: none;">
        <tr>
          <td style="padding: 0; border: none; vertical-align: middle;">
            <img src="{{ public_path('images/logo.png') }}" style="height: 38px; width: auto; margin-right: 12px; vertical-align: middle;">
          </td>
          <td style="padding: 0; border: none; vertical-align: middle;">
            <div class="brand-title">FIKOM CERTIFICATION CENTER</div>
            <div class="brand-sub">FAKULTAS ILMU KOMPUTER &bull; UMI MAKASSAR</div>
          </td>
        </tr>
      </table>
    </td>
    <td style="text-align: right; vertical-align: middle;">
      <div class="inv-big-title">INVOICE <span class="yellow-accent-box"></span></div>
    </td>
  </tr>
</table>

<!-- Yellow Bar Separator -->
<div class="yellow-header-bar"></div>

<!-- Two-Column Meta Container -->
<table class="meta-container">
  <tr>
    {{-- Left: Invoice To --}}
    <td style="width: 52%; padding-right: 20px;">
      <div class="meta-label-heading">Invoice to:</div>
      <div class="client-name">{{ $pembayaran->pendaftaran->peserta->nama }}</div>
      <div class="client-detail">
        Email: {{ $pembayaran->pendaftaran->peserta->email }}<br/>
        No. HP: {{ $pembayaran->pendaftaran->peserta->no_hp }}<br/>
        @if($pembayaran->pendaftaran->peserta->instansi)
          Instansi: {{ $pembayaran->pendaftaran->peserta->instansi }}
        @endif
      </div>
    </td>

    {{-- Right: Invoice Meta Info --}}
    <td style="width: 48%;">
      <table class="meta-info-table">
        <tr>
          <td class="meta-info-lbl">Invoice#</td>
          <td class="meta-info-val" style="font-size: 8.5pt;">{{ $pembayaran->kode_pembayaran }}</td>
        </tr>
        <tr>
          <td class="meta-info-lbl">Date</td>
          <td class="meta-info-val">{{ $pembayaran->created_at->format('d / m / Y') }}</td>
        </tr>
        <tr>
          <td class="meta-info-lbl">Due Date</td>
          <td class="meta-info-val" style="color: #DC2626;">{{ $pembayaran->tgl_kadaluarsa?->format('d / m / Y H:i') ?? '-' }} WITA</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- Main Items Table -->
<table class="items-table">
  <thead>
    <tr>
      <th style="width: 8%; text-align: center;">SL.</th>
      <th style="width: 52%;">Item Description</th>
      <th style="width: 15%; text-align: right;">Price</th>
      <th style="width: 10%; text-align: center;">Qty.</th>
      <th style="width: 15%; text-align: right;">Total</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="text-center text-bold">1</td>
      <td>
        <div class="text-bold">{{ $pembayaran->pendaftaran->kegiatan->judul }}</div>
        <div style="font-size: 8pt; color: #64748B; margin-top: 3px;">
          Kategori: {{ $pembayaran->pendaftaran->biaya?->nama_jenis ?? 'Pendaftaran Standar' }} &bull; Jenis: {{ ucfirst($pembayaran->pendaftaran->kegiatan->jenis_kegiatan) }}
        </div>
      </td>
      <td class="text-right text-bold">Rp {{ number_format($pembayaran->pendaftaran->biaya?->nominal ?? $pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
      <td class="text-center text-bold">1</td>
      <td class="text-right text-bold">Rp {{ number_format($pembayaran->pendaftaran->biaya?->nominal ?? $pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
    </tr>
    @if($pembayaran->kode_unik)
    <tr>
      <td class="text-center text-bold">2</td>
      <td>
        <div class="text-bold" style="color: #D97706;">Kode Unik Verifikasi Sistem</div>
        <div style="font-size: 8pt; color: #64748B; margin-top: 3px;">
          3 Digit unik untuk otomatisasi verifikasi transfer
        </div>
      </td>
      <td class="text-right text-bold" style="color: #D97706;">Rp {{ number_format($pembayaran->kode_unik, 0, ',', '.') }}</td>
      <td class="text-center text-bold">1</td>
      <td class="text-right text-bold" style="color: #D97706;">Rp {{ number_format($pembayaran->kode_unik, 0, ',', '.') }}</td>
    </tr>
    @endif
  </tbody>
</table>

<!-- Summary Calculation Right -->
<table class="summary-table">
  <tr>
    <td class="summary-lbl">Sub Total:</td>
    <td class="summary-val">Rp {{ number_format($pembayaran->pendaftaran->biaya?->nominal ?? $pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
  </tr>
  @if($pembayaran->kode_unik)
  <tr>
    <td class="summary-lbl">Kode Unik:</td>
    <td class="summary-val" style="color: #D97706;">Rp {{ number_format($pembayaran->kode_unik, 0, ',', '.') }}</td>
  </tr>
  @endif
  <tr class="total-yellow-row">
    <td class="summary-lbl" style="color:#131218 !important;">Total:</td>
    <td class="summary-val" style="color:#131218 !important;">{{ $pembayaran->nominal_transfer_format }}</td>
  </tr>
</table>

<!-- Bottom Section Grid -->
<table class="bottom-grid">
  <tr>
    {{-- Left: Terms & Payment Info --}}
    <td style="width: 58%; padding-right: 20px;">
      <div class="section-title">Terms &amp; Conditions</div>
      <div class="section-desc">
        Harap melakukan transfer persis sesuai nominal Total di atas (termasuk kode unik) sebelum batas waktu kadaluarsa. Simpan invoice ini sebagai bukti pendaftaran resmi.
      </div>

      @if($rekening)
      <div class="payment-box">
        <div class="payment-box-title">Payment Info:</div>
        <div class="payment-detail-row">
          <span class="payment-detail-lbl">Account #:</span>
          <strong style="color:#131218; font-size:9pt;">{{ $rekening->no_rekening }}</strong>
        </div>
        <div class="payment-detail-row">
          <span class="payment-detail-lbl">A/C Name:</span>
          <strong>{{ $rekening->nama_pemilik }}</strong>
        </div>
        <div class="payment-detail-row">
          <span class="payment-detail-lbl">Bank Details:</span>
          <strong>Bank {{ $rekening->bank }}</strong>
        </div>
      </div>
      @endif
    </td>

    {{-- Right: Authorised Sign --}}
    <td style="width: 42%;">
      <div class="signature-area">
        <div style="font-size: 8.5pt; color: #64748B;">Makassar, {{ $pembayaran->created_at->format('d M Y') }}</div>
        <div class="signature-line"></div>
        <div class="signature-label">Authorised Sign</div>
        <div style="font-size: 8pt; color: #64748B; margin-top: 2px;">Sekretariat FCC FIKOM UMI</div>
      </div>
    </td>
  </tr>
</table>

<!-- Bottom Footer Contact Bar -->
<div class="bottom-footer-bar">
  Phone #: (0411) 455 855 &nbsp;&bull;&nbsp; Address: Gedung FIKOM UMI, Jl. Urip Sumoharjo KM 5, Makassar &nbsp;&bull;&nbsp; Website: fcc.fikom.umi.ac.id
</div>

</body>
</html>
