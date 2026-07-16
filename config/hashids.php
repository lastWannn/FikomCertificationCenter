<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FCC Hashids Configuration
    |--------------------------------------------------------------------------
    |
    | Hashids digunakan untuk menyembunyikan ID numerik di URL publik.
    |
    | HASHID_SALT  : Diambil dari APP_KEY — ubah akan membuat semua
    |                URL lama tidak valid (tangani dengan redirect).
    |
    | HASHID_LENGTH: Panjang minimum hash yang dihasilkan.
    |                Minimal 8 untuk terlihat profesional.
    |
    | HASHID_ALPHA : Alfabet kustom — hapus karakter ambigu (0,1,I,l,O).
    */

    'salt'      => env('HASHID_SALT', env('APP_KEY', 'fcc-default-salt')),
    'min_length'=> (int) env('HASHID_MIN_LENGTH', 8),
    'alphabet'  => env('HASHID_ALPHABET', 'abcdefghjkmnpqrstuvwxyz23456789'),

    /*
    |--------------------------------------------------------------------------
    | Per-Model Salt Suffix
    |--------------------------------------------------------------------------
    | Menambahkan suffix unik per model sehingga hashid(1) untuk model A
    | TIDAK sama dengan hashid(1) untuk model B.
    | Ini mencegah enumerasi ID lintas resource.
    |
    | Key  = class basename Model
    | Value = string suffix (bebas, cukup unik per model)
    */
    'suffixes' => [
        'Kegiatan'           => 'keg',
        'Pelatihan'          => 'pel',
        'Sertifikasi'        => 'srt',
        'JadwalPelatihan'    => 'jpel',
        'JadwalSertifikasi'  => 'jsrt',
        'Pendaftaran'        => 'dft',
        'Pembayaran'         => 'byr',
        'Sertifikat'         => 'srtf',
        'Peserta'            => 'pst',
        'Instruktur'         => 'ins',
        'ArsipKegiatan'      => 'ars',
        'BiayaKegiatan'      => 'bia',
        'Informasi'          => 'inf',
        'Rekening'           => 'rek',
        'Nilai'              => 'nil',
        'MateriPelatihan'    => 'mp',
        'MateriSertifikasi'  => 'ms',
        'KategoriPelatihan'  => 'kp',
        'KategoriSertifikasi'=> 'ks',
    ],

];
