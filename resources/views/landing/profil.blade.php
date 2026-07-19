@extends('layouts.public')
@section('title','Profil FCC')
@section('page-content')
<div style="padding-top:68px;">
    <div style="background:#131218;padding:52px 24px 44px;text-align:center;position:relative;overflow:hidden;">
        <div style="position:absolute;inset:0;opacity:.04;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div style="position:relative;z-index:1;">
            <h1 class="fcc-gold-text" style="font-size:clamp(28px,5vw,50px);font-weight:900;margin:0 0 10px;">Profil FCC</h1>
            <p style="color:rgba(255,255,255,.55);font-size:16px;margin:0;">Mengenal FIKOM Certification Center lebih dekat</p>
        </div>
    </div>
    {{-- Tabs --}}
    <div style="background:#FFF;border-bottom:1px solid #E2E4EB;position:sticky;top:68px;z-index:50;">
        <div style="max-width:1100px;margin:0 auto;padding:0 24px;display:flex;gap:0;" id="profil-tabs">
            @foreach([['tentang','Tentang Kami'],['visi','Visi Misi & Tujuan'],['mitra','Mitra Kami']] as [$v,$l])
            <button onclick="showTab('{{ $v }}')" id="tab-{{ $v }}"
                style="padding:16px 24px;border:none;background:none;font-weight:700;font-size:14px;cursor:pointer;transition:all .2s;margin-bottom:-1px;
                       color:{{ $loop->first?'#FFC81A':'#6B7280' }};border-bottom:{{ $loop->first?'3px solid #FFC81A':'3px solid transparent' }};">
                {{ $l }}
            </button>
            @endforeach
        </div>
    </div>
    <div style="padding:52px 24px;max-width:1100px;margin:0 auto;">
        {{-- Tentang --}}
        <div id="content-tentang">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start;">
                <div>
                    <h3 style="font-size:24px;font-weight:900;color:#0F0F14;margin:0 0 16px;">Tentang <span style="color:#FFC81A;">FIKOM Certification Center</span></h3>
                    <p style="color:#6B7280;font-size:15px;line-height:1.85;margin:0 0 16px;">{{ $konten['tentang_kami']?->isi ?? 'FIKOM Certification Center (FCC) adalah unit pelaksana di bawah Fakultas Ilmu Komputer Universitas Muslim Indonesia.' }}</p>
                    <p style="color:#6B7280;font-size:15px;line-height:1.85;">FCC berdiri untuk menjawab kebutuhan industri akan tenaga kerja yang kompeten, bersertifikat, dan siap menghadapi tantangan ekonomi digital.</p>
                </div>
                <div style="background:#F7F8FA;border-radius:16px;padding:28px;">
                    @foreach([['Tahun Berdiri','2020'],['Total Peserta','342+'],['Program Aktif','25+'],['Mitra Industri','12+']] as [$l,$v])
                    <div style="display:flex;justify-content:space-between;padding:13px 0;border-bottom:1px solid #E2E4EB;">
                        <span style="color:#6B7280;font-size:14px;">{{ $l }}</span>
                        <span style="color:#FFC81A;font-weight:900;font-size:16px;">{{ $v }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- Visi Misi --}}
        <div id="content-visi" style="display:none;">
            <div style="display:grid;grid-template-columns:1fr;gap:24px;">
                <div class="fcc-card" style="padding:32px 36px;transition:all .3s ease;"
                     onmouseover="this.style.boxShadow='0 12px 32px rgba(0,0,0,0.06)';this.style.transform='translateY(-4px)';this.style.borderColor='rgba(255,200,26,.3)'"
                     onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,.04)';this.style.transform='translateY(0)';this.style.borderColor='#E2E4EB'">
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
                        <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A15;border:1.5px solid #FFC81A30;display:flex;align-items:center;justify-content:center;">
                            @include('components.icon',['name'=>'star','size'=>20,'style'=>'color:#FFC81A'])
                        </div>
                        <span style="font-size:20px;font-weight:900;color:#0F0F14;letter-spacing:-0.5px;">Visi</span>
                    </div>
                    <p style="color:#5A6275;font-size:15px;line-height:1.9;margin:0;">Menjadi unit pelatihan dan sertifikasi profesional yang mampu mencetak tenaga kerja yang berkualitas, terampil dan mandiri sesuai dengan Standar Kompetensi Nasional maupun Internasional sehingga dapat mengisi peluang kerja dan mampu menciptakan lapangan kerja.</p>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
                    <div class="fcc-card" style="padding:32px 36px;transition:all .3s ease;"
                         onmouseover="this.style.boxShadow='0 12px 32px rgba(0,0,0,0.06)';this.style.transform='translateY(-4px)';this.style.borderColor='rgba(16,185,129,.3)'"
                         onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,.04)';this.style.transform='translateY(0)';this.style.borderColor='#E2E4EB'">
                        <div style="display:flex;align-items:center;gap:14px;margin-bottom:22px;">
                            <div style="width:44px;height:44px;border-radius:12px;background:#10B98115;border:1.5px solid #10B98130;display:flex;align-items:center;justify-content:center;">
                                @include('components.icon',['name'=>'zap','size'=>20,'style'=>'color:#10B981'])
                            </div>
                            <span style="font-size:20px;font-weight:900;color:#0F0F14;letter-spacing:-0.5px;">Misi</span>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:16px;">
                            @foreach([
                                'Memberikan Pelatihan, Seminar dan Ujian Sertifikasi bertaraf Nasional dan Internasional.',
                                'Membentuk SDM yang memiliki skill IT mulai dari tingkatan Pemahaman Dasar sampai Profesional.',
                                'Berkontribusi terhadap peningkatan keterampilan anak bangsa dengan skil IT yang dimilik sehingga dapat berwirausaha dan juga menciptakan lapangan kerja.',
                                'Membangun Profesionalisme dalam pekerjaan khususnya yang terkait keterampilan bidang Teknologi Informasi.'
                            ] as $misi)
                            <div style="display:flex;align-items:flex-start;gap:12px;">
                                <div style="width:22px;height:22px;border-radius:7px;background:#10B98118;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <span style="color:#5A6275;font-size:14.5px;line-height:1.75;">{{ $misi }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="fcc-card" style="padding:32px 36px;transition:all .3s ease;"
                         onmouseover="this.style.boxShadow='0 12px 32px rgba(0,0,0,0.06)';this.style.transform='translateY(-4px)';this.style.borderColor='rgba(59,130,246,.3)'"
                         onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,.04)';this.style.transform='translateY(0)';this.style.borderColor='#E2E4EB'">
                        <div style="display:flex;align-items:center;gap:14px;margin-bottom:22px;">
                            <div style="width:44px;height:44px;border-radius:12px;background:#3B82F615;border:1.5px solid #3B82F630;display:flex;align-items:center;justify-content:center;">
                                @include('components.icon',['name'=>'check','size'=>20,'style'=>'color:#3B82F6'])
                            </div>
                            <span style="font-size:20px;font-weight:900;color:#0F0F14;letter-spacing:-0.5px;">Tujuan</span>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:16px;">
                            @foreach([
                                'Menunjang tercapainya kemampuan program pelatihan di lingkungan lembaga dalam mengembangkan kurikulum yang dinamis dan mampu mengantarkan lulusannya pada kualitas yang diharapkan.',
                                'Menunjang tercapainya kemampuan, profesionalitas dan akuntabilitas kinerja dosen/mahasiswa/praktisi dan tenaga kependidikan di lingkungan lembaga dalam menyelenggarakan proses pendidikan yang berkualitas.',
                                'Menunjang tercapainya kemampuan penyelenggaraan pendidikan pada berbagai tingkat di lingkungan lembaga dalam mengelola pendidikan dengan efektif, efisien dan produktif.',
                                'Menunjang tercapainya kemampuan peserta didik di lingkungan lembaga dalam belajar sepanjang hayat.',
                                'Menunjang tercapainya kemampuan penyelenggara pendidikan dalam memanfaatkan teknologi informasi seluas-luasnya dalam penyelenggaraan pendidikan.',
                                'Menunjang tercapainya kerjasama dan jejaring kependidikan dan pembelajaran dengan lembaga pelatihan lainnya dan dunia industri.'
                            ] as $tujuan)
                            <div style="display:flex;align-items:flex-start;gap:12px;">
                                <div style="width:22px;height:22px;border-radius:7px;background:#3B82F618;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#3B82F6" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <span style="color:#5A6275;font-size:14.5px;line-height:1.75;">{{ $tujuan }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Mitra --}}
        <div id="content-mitra" style="display:none;">
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
                @foreach($mitras as $m)
                <div class="fcc-card" style="padding:28px 20px;text-align:center;transition:transform .22s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width:72px;height:72px;border-radius:16px;margin:0 auto 16px;background:{{ $m->warna ? $m->warna.'18' : '#FFC81A18' }};border:1.5px solid {{ $m->warna ? $m->warna.'40' : '#FFC81A40' }};display:flex;align-items:center;justify-content:center;overflow:hidden;">
                        @if($m->logo)
                        <img src="{{ asset('storage/'.$m->logo) }}" alt="{{ $m->nama_mitra }}" style="width:48px;height:48px;object-fit:contain;mix-blend-mode:multiply;">
                        @else
                        <span style="color:{{ $m->warna ?? '#FFC81A' }};font-size:16px;font-weight:900;">{{ $m->inisial ?? substr($m->nama_mitra,0,3) }}</span>
                        @endif
                    </div>
                    <p style="color:#0F0F14;font-size:14px;font-weight:800;margin:0;line-height:1.4;">{{ $m->nama_mitra }}</p>
                    <p style="color:#9CA3B0;font-size:11px;margin:6px 0 0;text-transform:uppercase;font-weight:700;letter-spacing:0.5px;">Mitra Resmi FCC</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.tab-content-anim {
    animation: fadeSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes fadeSlideUp {
    from {
        opacity: 0;
        transform: translateY(12px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
<script>
function showTab(tab) {
    const tabs = ['tentang', 'visi', 'mitra'];
    
    tabs.forEach(t => {
        // Toggle konten & trigger animasi
        const content = document.getElementById('content-' + t);
        if (content) {
            if (t === tab) {
                content.style.display = 'block';
                content.classList.remove('tab-content-anim');
                void content.offsetWidth; // Trigger reflow agar animasi di-restart
                content.classList.add('tab-content-anim');
            } else {
                content.style.display = 'none';
            }
        }
        
        // Toggle gaya tombol (aktif/tidak aktif)
        const btn = document.getElementById('tab-' + t);
        if (btn) {
            if (t === tab) {
                btn.style.color = '#FFC81A';
                btn.style.borderBottom = '3px solid #FFC81A';
            } else {
                btn.style.color = '#6B7280';
                btn.style.borderBottom = '3px solid transparent';
            }
        }
    });
}
// Memicu animasi untuk tab default saat halaman pertama dimuat
document.addEventListener('DOMContentLoaded', () => {
    const defaultContent = document.getElementById('content-tentang');
    if (defaultContent) {
        defaultContent.classList.add('tab-content-anim');
    }
});
</script>
@endpush
