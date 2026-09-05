<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PointPesertaController;
use App\Http\Controllers\Admin\PointPesertaSertifikasiController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Livewire\Auth\Login as LivewireLogin;
use App\Livewire\Auth\Register as LivewireRegister;

// Admin
use App\Http\Controllers\Admin\{
    DashboardController      as AdminDashboard,
    PelatihanController,
    SertifikasiController,
    JadwalPelatihanController,
    JadwalSertifikasiController,
    MateriPelatihanController,
    MateriSertifikasiController,
    KegiatanController        as AdminKegiatan,
    BiayaController,
    PembayaranController,
    PresensiController,
    ArsipController           as AdminArsip,
    InformasiController,
    RekeningController,
    SertifikatController      as AdminSertifikat,
    KategoriController,
    ProfileController         as AdminProfile,
    NilaiController,
    LaporanController,
    UserManagementController,
    AdminManagementController,
    CetakController,
    ExportController,
    ChartController,
    QrController              as AdminQr,
    MitraController,
    KontakController,
    PesanController           as AdminPesan,
    TestimoniController,
    TandaTanganController,
};

// Peserta
use App\Http\Controllers\Peserta\{
    DashboardController     as PesertaDashboard,
    JelajahiController,
    PendaftaranController,
    PembayaranController    as PesertaBayar,
    SertifikatController    as PesertaSertifikat,
    ProfileController       as PesertaProfile,
    QrController            as PesertaQr,
    TestimoniController     as PesertaTestimoni,
};

/* ── LANDING ─────────────────────────────────────────────────── */
Route::get('/',              [LandingController::class,'index'])->name('landing.index');
Route::get('/profil',        [LandingController::class,'profil'])->name('landing.profil');
Route::get('/kegiatan',      [LandingController::class,'kegiatan'])->name('landing.kegiatan');
Route::get('/kegiatan/{kegiatan}', [LandingController::class,'show'])->name('landing.show');
Route::get('/pendaftaran',   [LandingController::class,'pendaftaran'])->name('landing.pendaftaran');
Route::get('/arsip',         [LandingController::class,'arsip'])->name('landing.arsip');
Route::get('/arsip/{arsip}', [LandingController::class,'arsipShow'])->name('landing.arsip.show');
Route::get('/arsip/{arsip}/pdf', [LandingController::class,'arsipPdf'])->name('landing.arsip.pdf');
Route::get('/arsip/{arsip}/download-pdf', [LandingController::class,'downloadDomPdf'])->name('landing.arsip.download-pdf');
Route::get('/arsip/{arsip}/unduh-lampiran', [LandingController::class,'downloadBeritaAcara'])->name('landing.arsip.download');
Route::get('/hubungi-kami',  [LandingController::class,'kontak'])->name('landing.kontak');
Route::post('/hubungi-kami', [LandingController::class,'kontakPost'])->name('landing.kontak.post');

// Search API (AJAX)
Route::get('/api/search',    [LandingController::class,'search'])->name('landing.search');

/* ── AUTH ────────────────────────────────────────────────────── */
Route::middleware('guest.fcc')->group(function () {
    Route::get('/masuk',          [LoginController::class,'showLogin'])->name('auth.login');
    Route::post('/masuk',         [LoginController::class,'login'])->middleware('throttle:10,1')->name('auth.login.post');

    Route::get('/daftar',         [RegisterController::class,'showRegister'])->name('auth.register');
    Route::post('/daftar',        [RegisterController::class,'register'])->middleware('throttle:10,1')->name('auth.register.post');
    Route::post('/daftar/verify', [RegisterController::class,'verifyOtp'])->middleware('throttle:10,1')->name('auth.register.verify');

    // Google OAuth Routes
    Route::get('/auth/google',          [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

    Route::get('/lupa-password',  [LoginController::class,'showForgot'])->name('auth.forgot');
    Route::post('/lupa-password', [LoginController::class,'sendReset'])->middleware('throttle:10,1')->name('auth.forgot.post');
    Route::post('/lupa-password/verify', [LoginController::class,'verifyResetOtp'])->middleware('throttle:10,1')->name('auth.forgot.verify');
});
Route::post('/keluar', [LoginController::class,'logout'])->name('auth.logout');

// QR presensi publik (signed URL, tanpa login)
Route::get('/qr/scan/{token}', [AdminQr::class,'scan'])->name('qr.scan');

/* ── ADMIN ───────────────────────────────────────────────────── */
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminDashboard::class,'index'])->name('dashboard');

    /* CHART API (AJAX) */
    Route::prefix('api')->name('api.')->group(function() {
        Route::get('chart/pendapatan', [ChartController::class,'pendapatan'])->name('chart.pendapatan');
        Route::get('chart/pendaftaran',[ChartController::class,'pendaftaran'])->name('chart.pendaftaran');
        Route::get('chart/kegiatan',         [ChartController::class,'kegiatan'])->name('chart.kegiatan');
        Route::get('chart/status-pendaftar', [ChartController::class,'statusPendaftar'])->name('chart.status-pendaftar');
        Route::get('chart/stats',            [ChartController::class,'stats'])->name('chart.stats');
        Route::get('calendar',               [ChartController::class,'calendarData'])->name('calendar');
    });

    /* PROGRAM */
    Route::prefix('pelatihan/point')->name('pelatihan.point.')->group(function () {
        Route::get('/',                                  [PointPesertaController::class, 'index'])->name('index');
        Route::get('/{jadwal}',                          [PointPesertaController::class, 'show'])->name('show');
        Route::post('/{jadwal}/pendaftaran/{pendaftaran}', [PointPesertaController::class, 'update'])->name('update');
    });

    Route::prefix('sertifikasi/point')->name('sertifikasi.point.')->group(function () {
        Route::get('/',                                  [PointPesertaSertifikasiController::class, 'index'])->name('index');
        Route::get('/{jadwal}',                          [PointPesertaSertifikasiController::class, 'show'])->name('show');
        Route::post('/{jadwal}/pendaftaran/{pendaftaran}', [PointPesertaSertifikasiController::class, 'update'])->name('update');
    });

    Route::resource('pelatihan',   PelatihanController::class);
    Route::resource('sertifikasi', SertifikasiController::class);

    Route::prefix('jadwal-pelatihan')->name('jadwal-pelatihan.')->group(function () {
        Route::get('/',                      [JadwalPelatihanController::class,'index'])->name('index');
        Route::get('/tambah/{pelatihan}',    [JadwalPelatihanController::class,'create'])->name('create');
        Route::post('/tambah/{pelatihan}',   [JadwalPelatihanController::class,'store'])->name('store');
        Route::get('/{jadwal}/edit',         [JadwalPelatihanController::class,'edit'])->name('edit');
        Route::put('/{jadwal}',              [JadwalPelatihanController::class,'update'])->name('update');
        Route::delete('/{jadwal}',           [JadwalPelatihanController::class,'destroy'])->name('destroy');
        Route::post('/{jadwal}/status',      [JadwalPelatihanController::class,'updateStatus'])->name('status');
        Route::post('/{jadwal}/aktifkan',    [JadwalPelatihanController::class,'aktifkan'])->name('aktifkan');
        Route::post('/{jadwal}/nonaktifkan', [JadwalPelatihanController::class,'nonaktifkan'])->name('nonaktifkan');
    });

    Route::prefix('jadwal-sertifikasi')->name('jadwal-sertifikasi.')->group(function () {
        Route::get('/',                      [JadwalSertifikasiController::class,'index'])->name('index');
        Route::get('/tambah/{sertifikasi}',  [JadwalSertifikasiController::class,'create'])->name('create');
        Route::post('/tambah/{sertifikasi}', [JadwalSertifikasiController::class,'store'])->name('store');
        Route::get('/{jadwal}/edit',         [JadwalSertifikasiController::class,'edit'])->name('edit');
        Route::put('/{jadwal}',              [JadwalSertifikasiController::class,'update'])->name('update');
        Route::delete('/{jadwal}',           [JadwalSertifikasiController::class,'destroy'])->name('destroy');
        Route::post('/{jadwal}/status',      [JadwalSertifikasiController::class,'updateStatus'])->name('status');
        Route::post('/{jadwal}/aktifkan',    [JadwalSertifikasiController::class,'aktifkan'])->name('aktifkan');
        Route::post('/{jadwal}/nonaktifkan', [JadwalSertifikasiController::class,'nonaktifkan'])->name('nonaktifkan');
    });
    Route::get('materi', [MateriPelatihanController::class, 'index'])->name('materi.index');
    Route::get('sertifikasi-materi', [MateriSertifikasiController::class, 'index'])->name('sertifikasi.materi.index');

    Route::prefix('pelatihan/{pelatihan}/materi')->name('materi-pelatihan.')->group(function () {
        Route::get('/tambah',       [MateriPelatihanController::class,'create'])->name('create');
        Route::post('/',            [MateriPelatihanController::class,'store'])->name('store');
        Route::get('/{materi}/edit',[MateriPelatihanController::class,'edit'])->name('edit');
        Route::put('/{materi}',     [MateriPelatihanController::class,'update'])->name('update');
        Route::delete('/{materi}',  [MateriPelatihanController::class,'destroy'])->name('destroy');
        Route::post('/reorder',     [MateriPelatihanController::class,'reorder'])->name('reorder');
    });

    Route::prefix('sertifikasi/{sertifikasi}/materi')->name('materi-sertifikasi.')->group(function () {
        Route::get('/tambah',       [MateriSertifikasiController::class,'create'])->name('create');
        Route::post('/',            [MateriSertifikasiController::class,'store'])->name('store');
        Route::get('/{materi}/edit',[MateriSertifikasiController::class,'edit'])->name('edit');
        Route::put('/{materi}',     [MateriSertifikasiController::class,'update'])->name('update');
        Route::delete('/{materi}',  [MateriSertifikasiController::class,'destroy'])->name('destroy');
    });

    /* KEGIATAN */
    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/',                         [AdminKegiatan::class,'index'])->name('index');
        Route::get('/{kegiatan}',               [AdminKegiatan::class,'show'])->name('show');
        Route::get('/{kegiatan}/edit',          [AdminKegiatan::class,'edit'])->name('edit');
        Route::put('/{kegiatan}',               [AdminKegiatan::class,'update'])->name('update');
        Route::delete('/{kegiatan}',            [AdminKegiatan::class,'destroy'])->name('destroy');
        Route::post('/{kegiatan}/toggle-biaya', [AdminKegiatan::class,'toggleBiaya'])->name('toggle-biaya');
        Route::post('/{kegiatan}/arsipkan',    [AdminKegiatan::class,'arsipkan'])->name('arsipkan');
    });
    Route::resource('biaya', BiayaController::class);
    Route::post('arsip/upload-foto', [AdminArsip::class, 'uploadFoto'])->name('arsip.upload-foto');
    Route::resource('arsip', AdminArsip::class)->except(['create', 'store']);

    /* QR PRESENSI */
    Route::prefix('qr')->name('qr.')->group(function() {
        Route::get('/{kegiatan}',           [AdminQr::class,'index'])->name('index');
        Route::get('/{kegiatan}/cetak',     [AdminQr::class,'cetakSheet'])->name('cetak-sheet');
        Route::get('/pendaftaran/{pd}/qr',  [AdminQr::class,'showQr'])->name('show');
        Route::post('/{kegiatan}/regenerate',[AdminQr::class,'regenerate'])->name('regenerate');
    });

    /* TRANSAKSI */
    Route::get('pesan',                               [AdminPesan::class,'index'])->name('pesan.index');
    Route::get('pesan/{pesan}',                       [AdminPesan::class,'show'])->name('pesan.show');
    Route::post('pesan/{pesan}/read',                 [AdminPesan::class,'markAsRead'])->name('pesan.read');
    Route::delete('pesan/{pesan}',                    [AdminPesan::class,'destroy'])->name('pesan.destroy');
    Route::get('pembayaran',                          [PembayaranController::class,'index'])->name('pembayaran.index');
    Route::get('pembayaran/{pembayaran}',             [PembayaranController::class,'show'])->name('pembayaran.show');
    Route::post('pembayaran/{pembayaran}/verifikasi', [PembayaranController::class,'verifikasi'])->name('pembayaran.verifikasi');
    Route::post('pembayaran/{pembayaran}/tolak',      [PembayaranController::class,'tolak'])->name('pembayaran.tolak');
    Route::post('pembayaran/{pembayaran}/perpanjang',         [PembayaranController::class,'perpanjang'])->name('pembayaran.perpanjang');
    Route::post('pembayaran/{pembayaran}/approve-perpanjangan',[PembayaranController::class,'approvePerpanjangan'])->name('pembayaran.approve-perpanjangan');
    Route::post('pembayaran/{pembayaran}/tolak-perpanjangan',  [PembayaranController::class,'tolakPerpanjangan'])->name('pembayaran.tolak-perpanjangan');

    Route::get('presensi',                            [PresensiController::class,'index'])->name('presensi.index');
    Route::get('presensi/{kegiatan}',                 [PresensiController::class,'show'])->name('presensi.show');
    Route::post('presensi/{pendaftaran}/hadir',       [PresensiController::class,'markHadir'])->name('presensi.hadir');
    Route::get('presensi/{kegiatan}/export',          [PresensiController::class,'export'])->name('presensi.export');

    Route::get('nilai',                               [NilaiController::class,'index'])->name('nilai.index');
    Route::get('nilai/{pendaftaran}',                 [NilaiController::class,'show'])->name('nilai.show');
    Route::post('nilai/{pendaftaran}',                [NilaiController::class,'store'])->name('nilai.store');
    Route::put('nilai/{nilai}',                       [NilaiController::class,'update'])->name('nilai.update');

    Route::get('sertifikat',                          [AdminSertifikat::class,'index'])->name('sertifikat.index');
    Route::get('sertifikat/{kegiatan}/peserta',       [AdminSertifikat::class,'peserta'])->name('sertifikat.peserta');
    Route::get('sertifikat/{kegiatan}/preview-sample', [AdminSertifikat::class,'previewSamplePdf'])->name('sertifikat.preview-sample');
    Route::get('sertifikat/{kegiatan}/layout-editor', [AdminSertifikat::class,'layoutEditor'])->name('sertifikat.layout-editor');
    Route::post('sertifikat/{kegiatan}/save-layout',  [AdminSertifikat::class,'saveLayout'])->name('sertifikat.save-layout');
    Route::post('sertifikat/upload-latar',            [AdminSertifikat::class,'uploadLatar'])->name('sertifikat.upload-latar');
    Route::post('sertifikat/{pendaftaran}/terbitkan', [AdminSertifikat::class,'terbitkan'])->name('sertifikat.terbitkan');
    Route::post('sertifikat/terbitkan-semua/{kegiatan}', [AdminSertifikat::class,'terbitkanSemua'])->name('sertifikat.terbitkan-semua');

    /* CETAK PDF */
    Route::prefix('cetak')->name('cetak.')->group(function() {
        Route::get('/sertifikat/{sertifikat}',  [CetakController::class,'sertifikat'])->name('sertifikat');
        Route::get('/invoice/{pembayaran}',     [CetakController::class,'invoice'])->name('invoice');
        Route::get('/bukti/{pembayaran}',       [CetakController::class,'buktiPembayaran'])->name('bukti');
        Route::get('/presensi/{kegiatan}',      [CetakController::class,'presensi'])->name('presensi');
    });

    /* EXPORT EXCEL */
    Route::prefix('export')->name('export.')->group(function() {
        Route::get('/peserta',          [ExportController::class,'peserta'])->name('peserta');
        Route::get('/presensi/{kegiatan}',[ExportController::class,'presensi'])->name('presensi');
        Route::get('/pendaftaran',      [ExportController::class,'pendaftaran'])->name('pendaftaran');
        Route::get('/nilai/{kegiatan}', [ExportController::class,'nilai'])->name('nilai');
        Route::get('/pembayaran',       [ExportController::class,'pembayaran'])->name('pembayaran');
    });

    /* MASTER DATA */
    Route::resource('kategori',   KategoriController::class);

    /* MANAJEMEN PENGGUNA */
    Route::prefix('pengguna')->name('pengguna.')->group(function() {
        Route::get('/',                               [UserManagementController::class,'index'])->name('index');
        Route::get('/peserta',                        [UserManagementController::class,'peserta'])->name('peserta');
        Route::get('/peserta/{peserta}',              [UserManagementController::class,'detailPeserta'])->name('peserta.detail');
        Route::post('/peserta/{peserta}/toggle',      [UserManagementController::class,'toggleStatusPeserta'])->name('peserta.toggle');
        Route::delete('/peserta/{peserta}',           [UserManagementController::class,'hapusPeserta'])->name('peserta.hapus');
        Route::post('/peserta/{peserta}/reset-password',[UserManagementController::class,'resetPassword'])->name('peserta.reset-password');

        /* Kelola Admin & Super Admin */
        Route::get('/admin',                          [AdminManagementController::class,'index'])->name('admin.index');
        Route::post('/admin',                         [AdminManagementController::class,'store'])->name('admin.store');
        Route::put('/admin/{admin}',                  [AdminManagementController::class,'update'])->name('admin.update');
        Route::delete('/admin/{admin}',               [AdminManagementController::class,'destroy'])->name('admin.destroy');
    });

    /* KONTEN */
    Route::resource('informasi', InformasiController::class);
    Route::resource('mitra', MitraController::class);
    Route::resource('testimoni', TestimoniController::class)->except(['create', 'show', 'edit']);
    Route::post('testimoni/{testimoni}/toggle-status', [TestimoniController::class, 'toggleStatus'])->name('testimoni.toggle-status');
    Route::get('kontak', [KontakController::class, 'edit'])->name('kontak.edit');
    Route::put('kontak', [KontakController::class, 'update'])->name('kontak.update');
    Route::resource('rekening',  RekeningController::class);
    Route::post('rekening/{rekening}/aktifkan', [RekeningController::class,'aktifkan'])->name('rekening.aktifkan');
    Route::get('tanda-tangan',                  [TandaTanganController::class, 'index'])->name('tanda-tangan.index');
    Route::post('tanda-tangan',                 [TandaTanganController::class, 'update'])->name('tanda-tangan.update');
    Route::delete('tanda-tangan/{type}',        [TandaTanganController::class, 'destroy'])->name('tanda-tangan.destroy');

    /* LAPORAN */
    Route::get('laporan',                        [LaporanController::class,'index'])->name('laporan.index');
    Route::get('laporan/export-csv',             [LaporanController::class,'exportCsv'])->name('laporan.export-csv');
    Route::get('laporan/export-kegiatan-excel',  [LaporanController::class,'exportKegiatanExcel'])->name('laporan.export-kegiatan-excel');

    /* PROFIL */
    Route::get('/profil',  [AdminProfile::class,'edit'])->name('profile');
    Route::put('/profil',  [AdminProfile::class,'update'])->name('profile.update');
});

/* ── PESERTA ─────────────────────────────────────────────────── */
Route::middleware('auth.peserta')->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/',                  [PesertaDashboard::class,'index'])->name('dashboard');
    Route::get('/profil',            [PesertaProfile::class,'edit'])->name('profile');
    Route::put('/profil',            [PesertaProfile::class,'update'])->name('profile.update');
    Route::post('/profil/verify-email-otp', [PesertaProfile::class,'verifyEmailOtp'])->name('profile.verify-email-otp');
    Route::post('/profil/resend-email-otp', [PesertaProfile::class,'resendEmailOtp'])->name('profile.resend-email-otp');
    Route::post('/profil/cancel-email-change', [PesertaProfile::class,'cancelEmailChange'])->name('profile.cancel-email-change');
    Route::get('/jelajahi',          [JelajahiController::class,'index'])->name('jelajahi');
    Route::post('/daftar/{kegiatan}',[PendaftaranController::class,'store'])->name('kegiatan.daftar');
    Route::get('/pendaftaran',       [PendaftaranController::class,'index'])->name('pendaftaran');
    Route::get('/pendaftaran/{pendaftaran}', [PendaftaranController::class,'show'])->name('pendaftaran.show');
    Route::get('/pembayaran',            [PesertaBayar::class,'index'])->name('pembayaran');
    Route::get('/pembayaran/{pembayaran}',       [PesertaBayar::class,'show'])->name('pembayaran.show');
    Route::get('/pembayaran/{pembayaran}/invoice', [PesertaBayar::class,'invoice'])->name('pembayaran.invoice');
    Route::post('/pembayaran/{pembayaran}/aktifkan',   [PesertaBayar::class,'aktifkan'])->name('pembayaran.aktifkan');
    Route::post('/pembayaran/{pembayaran}/konfirmasi', [PesertaBayar::class,'konfirmasi'])->name('pembayaran.konfirmasi');
    Route::post('/pembayaran/{pembayaran}/request-perpanjangan', [PesertaBayar::class,'requestPerpanjangan'])->name('pembayaran.request-perpanjangan');
    // Sertifikat Peserta
    Route::get('/sertifikat',                                     [PesertaSertifikat::class, 'index'])->name('sertifikat');
    Route::post('/sertifikat/{pendaftaran}/upload-transkrip',    [PesertaSertifikat::class, 'uploadTranskrip'])->name('sertifikat.upload-transkrip');
    Route::get('/sertifikat/{sertifikat}/download',               [PesertaSertifikat::class, 'download'])->name('sertifikat.download');
    Route::get('/sertifikat/{sertifikat}/preview',                [PesertaSertifikat::class, 'preview'])->name('sertifikat.preview');
    // QR Peserta
    Route::get('/qr/{pendaftaran}',      [PesertaQr::class,'show'])->name('qr.show');
    Route::get('/qr/{pendaftaran}/cetak',[PesertaQr::class,'cetak'])->name('qr.cetak');
    // Testimoni Peserta
    Route::get('/testimoni',             [PesertaTestimoni::class, 'index'])->name('testimoni');
    Route::post('/testimoni',            [PesertaTestimoni::class, 'store'])->name('testimoni.store');
    Route::put('/testimoni/{testimoni}', [PesertaTestimoni::class, 'update'])->name('testimoni.update');
    Route::delete('/testimoni/{testimoni}', [PesertaTestimoni::class, 'destroy'])->name('testimoni.destroy');
    // API Chart
    Route::get('/api/chart/aktivitas', [PesertaDashboard::class,'chartAktivitas'])->name('api.chart.aktivitas');
});


