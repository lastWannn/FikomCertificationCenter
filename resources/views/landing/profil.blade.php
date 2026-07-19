@extends('layouts.public')
@section('title','Profil FCC')
@section('page-content')
<div style="padding-top:68px; background:#F9FAFB; min-height: calc(100vh - 68px);">
    {{-- Hero Section --}}
    <div style="background: linear-gradient(135deg, #131218 0%, #1c1b22 100%); padding: 76px 24px 64px; text-align: center; position: relative; overflow: hidden; border-bottom: 1px solid rgba(255, 200, 26, 0.08);">
        <!-- Glow effects -->
        <div style="position: absolute; top: -50%; left: -20%; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 200, 26, 0.06), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; bottom: -50%; right: -20%; width: 450px; height: 450px; border-radius: 50%; background: radial-gradient(circle, rgba(59, 130, 246, 0.04), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; inset: 0; opacity: .03; background-image: linear-gradient(rgba(255, 200, 26, 1) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 200, 26, 1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div style="position: relative; z-index: 1; max-width: 800px; margin: 0 auto;">
            <span style="display: inline-block; padding: 6px 14px; background: rgba(255, 200, 26, 0.1); border: 1px solid rgba(255, 200, 26, 0.25); border-radius: 100px; color: #FFC81A; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(255, 200, 26, 0.05);">Tentang Unit Kami</span>
            <h1 style="color: #FFF; font-size: clamp(30px, 5.5vw, 48px); font-weight: 900; margin: 0 0 16px; letter-spacing: -1.2px; line-height: 1.15;">
                Profil <span class="fcc-gold-text">FCC UMI</span>
            </h1>
            <p style="color: rgba(255, 255, 255, 0.55); font-size: 16px; margin: 0; line-height: 1.6; font-weight: 500; max-width: 520px; margin: 0 auto;">
                FIKOM Certification Center, unit pelaksana sertifikasi & pelatihan profesional berstandar nasional dan internasional.
            </p>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid #E2E4EB; position: sticky; top: 68px; z-index: 50; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
        <div style="max-width: 1100px; margin: 0 auto; padding: 0 24px; display: flex; justify-content: center; gap: 8px;" id="profil-tabs">
            @foreach([['tentang','Tentang Kami'],['visi','Visi, Misi & Tujuan'],['mitra','Mitra Strategis']] as [$v,$l])
            <button onclick="showTab('{{ $v }}')" id="tab-{{ $v }}"
                style="padding: 18px 24px; border: none; background: none; font-weight: 800; font-size: 14px; cursor: pointer; transition: all .25s ease; position: relative; margin-bottom:-1px;
                       color: {{ $loop->first ? '#131218' : '#6B7280' }}; border-bottom: 3px solid {{ $loop->first ? '#FFC81A' : 'transparent' }};">
                {{ $l }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- Content Container --}}
    <div style="padding: 56px 24px; max-width: 1100px; margin: 0 auto;">
        
        {{-- Tentang Kami --}}
        <div id="content-tentang">
            <div style="display:grid; grid-template-columns: 1.1fr 0.9fr; gap:48px; align-items:start;">
                <div style="padding-top: 8px;">
                    <div style="width: 50px; height: 4px; background: #FFC81A; border-radius: 2px; margin-bottom: 24px;"></div>
                    <h3 style="font-size: 28px; font-weight: 900; color: #131218; margin: 0 0 20px; letter-spacing: -0.5px; line-height: 1.3;">
                        Membangun Talenta Digital <br>
                        <span style="color: #FFC81A;">Kompeten & Berdaya Saing</span>
                    </h3>
                    <p style="color: #5A6275; font-size: 15.5px; line-height: 1.85; margin: 0 0 18px; font-weight: 500;">
                        {{ $konten['tentang_kami']?->isi ?? 'FIKOM Certification Center (FCC) adalah unit pelaksana di bawah Fakultas Ilmu Komputer Universitas Muslim Indonesia.' }}
                    </p>
                    <p style="color: #5A6275; font-size: 15.5px; line-height: 1.85; margin: 0 0 32px; font-weight: 500;">
                        FCC berdiri untuk menjawab kebutuhan industri akan tenaga kerja yang kompeten, bersertifikat, dan siap menghadapi tantangan ekonomi digital global dengan membekali mahasiswa dan masyarakat umum melalui program sertifikasi terstandarisasi.
                    </p>
                    <div style="display: flex; gap: 16px;">
                        <a href="{{ route('landing.kegiatan') }}" class="fcc-btn-gold" style="padding: 14px 28px; font-size: 14px; font-weight: 700; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 8px 24px rgba(255, 200, 26, 0.25);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Lihat Program Sertifikasi
                        </a>
                    </div>
                </div>

                {{-- Visual Stat Cards --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <!-- Stat Card 1 -->
                    <div class="fcc-card" style="padding: 28px 24px; border-radius: 20px; background: #FFF; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid #E2E4EB;"
                         onmouseover="this.style.transform='translateY(-6px)'; this.style.borderColor='rgba(255, 200, 26, 0.4)'; this.style.boxShadow='0 12px 30px rgba(255, 200, 26, 0.08)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E4EB'; this.style.boxShadow='none';">
                        <div style="width: 46px; height: 46px; border-radius: 14px; background: #FFC81A15; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; border: 1px solid rgba(255,200,26,0.25);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <p style="margin: 0; color: #131218; font-size: 28px; font-weight: 900; letter-spacing: -1px; line-height: 1;">2020</p>
                            <p style="margin: 6px 0 0; color: #6B7280; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Tahun Berdiri</p>
                        </div>
                    </div>
                    <!-- Stat Card 2 -->
                    <div class="fcc-card" style="padding: 28px 24px; border-radius: 20px; background: #FFF; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid #E2E4EB;"
                         onmouseover="this.style.transform='translateY(-6px)'; this.style.borderColor='rgba(16, 185, 129, 0.4)'; this.style.boxShadow='0 12px 30px rgba(16, 185, 129, 0.08)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E4EB'; this.style.boxShadow='none';">
                        <div style="width: 46px; height: 46px; border-radius: 14px; background: #10B98115; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; border: 1px solid rgba(16, 185, 129, 0.25);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <div>
                            <p style="margin: 0; color: #131218; font-size: 28px; font-weight: 900; letter-spacing: -1px; line-height: 1;">342+</p>
                            <p style="margin: 6px 0 0; color: #6B7280; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Alumni</p>
                        </div>
                    </div>
                    <!-- Stat Card 3 -->
                    <div class="fcc-card" style="padding: 28px 24px; border-radius: 20px; background: #FFF; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid #E2E4EB;"
                         onmouseover="this.style.transform='translateY(-6px)'; this.style.borderColor='rgba(59, 130, 246, 0.4)'; this.style.boxShadow='0 12px 30px rgba(59, 130, 246, 0.08)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E4EB'; this.style.boxShadow='none';">
                        <div style="width: 46px; height: 46px; border-radius: 14px; background: #3B82F615; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; border: 1px solid rgba(59, 130, 246, 0.25);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3B82F6" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        </div>
                        <div>
                            <p style="margin: 0; color: #131218; font-size: 28px; font-weight: 900; letter-spacing: -1px; line-height: 1;">25+</p>
                            <p style="margin: 6px 0 0; color: #6B7280; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Program Aktif</p>
                        </div>
                    </div>
                    <!-- Stat Card 4 -->
                    <div class="fcc-card" style="padding: 28px 24px; border-radius: 20px; background: #FFF; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid #E2E4EB;"
                         onmouseover="this.style.transform='translateY(-6px)'; this.style.borderColor='rgba(139, 92, 246, 0.4)'; this.style.boxShadow='0 12px 30px rgba(139, 92, 246, 0.08)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E4EB'; this.style.boxShadow='none';">
                        <div style="width: 46px; height: 46px; border-radius: 14px; background: #8B5CF615; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; border: 1px solid rgba(139, 92, 246, 0.25);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8B5CF6" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <div>
                            <p style="margin: 0; color: #131218; font-size: 28px; font-weight: 900; letter-spacing: -1px; line-height: 1;">12+</p>
                            <p style="margin: 6px 0 0; color: #6B7280; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Mitra Industri</p>
                        </div>
                    </div>
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
            <div style="text-align:center; max-width:600px; margin: 0 auto 36px;">
                <h3 style="font-size:22px; font-weight:900; color:#131218; margin:0 0 10px;">Mitra Kolaborasi Strategis</h3>
                <p style="color:#6B7280; font-size:14.5px; line-height:1.6; margin:0;">FIKOM Certification Center bekerja sama dengan berbagai penyedia sertifikasi dan vendor teknologi global untuk menghadirkan kurikulum berstandar internasional.</p>
            </div>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
                @foreach($mitras as $m)
                <div class="fcc-card" style="padding:28px 20px;text-align:center;transition:all .22s ease;" 
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.06)';" 
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
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
                btn.style.color = '#131218';
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
