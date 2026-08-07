@extends('layouts.public')
@section('title','Profil FCC')
@section('page-content')
<div style="padding-top:64px; background:#131218; min-height: calc(100vh - 64px);">
    {{-- Hero Section --}}
    <div style="background: #131218; padding: 48px 24px 38px; text-align: center; position: relative; overflow: hidden; border-bottom: 1px solid #1E1D26;">
        <!-- Ambient Glow -->
        <div style="position: absolute; top: -50%; left: -20%; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 200, 26, 0.08), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; bottom: -50%; right: -20%; width: 450px; height: 450px; border-radius: 50%; background: radial-gradient(circle, rgba(255, 200, 26, 0.05), transparent 70%); pointer-events: none;"></div>
        <div style="position: absolute; inset: 0; opacity: .03; background-image: linear-gradient(rgba(255, 200, 26, 1) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 200, 26, 1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div style="position: relative; z-index: 1; max-width: 740px; margin: 0 auto;">
            <span style="display: inline-block; padding: 5px 16px; background: #FFC81A; color: #131218; font-size: 10.5px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 12px; border-radius: 100px; border: 1.5px solid #131218; box-shadow: 0 4px 12px rgba(255, 200, 26, 0.25);">
                Tentang Unit Kami
            </span>
            <h1 style="color: #FFFFFF; font-size: clamp(26px, 4.5vw, 40px); font-weight: 900; margin: 0 0 10px; letter-spacing: -0.8px; line-height: 1.15;">
                Profil <span style="color: #FFC81A;">FCC UMI</span>
            </h1>
            <p style="color: rgba(255, 255, 255, 0.8); font-size: 14.5px; margin: 0 auto; line-height: 1.55; font-weight: 500; max-width: 500px;">
                FIKOM Certification Center, unit pelaksana sertifikasi &amp; pelatihan profesional berstandar nasional dan internasional.
            </p>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div style="background: #FFFFFF; border-bottom: 1.5px solid #E2E8F0; position: sticky; top: 64px; z-index: 50; box-shadow: 0 4px 16px rgba(0,0,0,0.04);">
        <div style="max-width: 1100px; margin: 0 auto; padding: 0 24px; display: flex; justify-content: center; gap: 8px;" id="profil-tabs">
            @foreach([['tentang','Tentang Kami'],['visi','Visi, Misi & Tujuan'],['mitra','Mitra Strategis']] as [$v,$l])
            <button onclick="showTab('{{ $v }}')" id="tab-{{ $v }}"
                style="padding: 14px 24px; border: none; background: none; font-weight: 900; font-size: 14px; cursor: pointer; transition: all .25s ease; position: relative; margin-bottom:-1.5px;
                       color: {{ $loop->first ? '#131218' : '#64748B' }}; border-bottom: 3px solid {{ $loop->first ? '#FFC81A' : 'transparent' }};">
                {{ $l }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- Content Container --}}
    <div style="background:#F8F9FA; padding: 48px 24px 72px;">
        <div style="max-width: 1100px; margin: 0 auto;">
            
            {{-- Tentang Kami --}}
            <div id="content-tentang">
                <div style="display:grid; grid-template-columns: 1.1fr 0.9fr; gap:40px; align-items:start;">
                    <div>
                        <div style="width: 44px; height: 4px; background: #FFC81A; border-radius: 2px; margin-bottom: 18px;"></div>
                        <h3 style="font-size: 26px; font-weight: 900; color: #0F172A; margin: 0 0 16px; letter-spacing: -0.5px; line-height: 1.3;">
                            Membangun Talenta Digital <br>
                            <span style="color: #D97706; background:#FEF3C7; padding:2px 10px; border-radius:6px;">Kompeten &amp; Berdaya Saing</span>
                        </h3>
                        <p style="color: #334155; font-size: 14.5px; line-height: 1.8; margin: 0 0 14px; font-weight: 500;">
                            {{ $konten['tentang_kami']?->isi ?? 'FIKOM Certification Center (FCC) adalah unit pelaksana di bawah Fakultas Ilmu Komputer Universitas Muslim Indonesia.' }}
                        </p>
                        <p style="color: #475569; font-size: 14.5px; line-height: 1.8; margin: 0 0 28px; font-weight: 500;">
                            FCC berdiri untuk menjawab kebutuhan industri akan tenaga kerja yang kompeten, bersertifikat, dan siap menghadapi tantangan ekonomi digital global dengan membekali mahasiswa dan masyarakat umum melalui program sertifikasi terstandarisasi.
                        </p>
                        <div style="display: flex; gap: 14px;">
                            <a href="{{ route('landing.kegiatan') }}" style="padding: 13px 26px; font-size: 14px; font-weight: 900; background: #FFC81A; color: #131218; border:1.5px solid #131218; border-radius: 30px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 16px rgba(255, 200, 26, 0.35);">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                Lihat Program Sertifikasi
                            </a>
                        </div>
                    </div>

                    {{-- Visual Stat Cards --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                        <!-- Stat Card 1 -->
                        <div style="padding: 22px 20px; border-radius: 18px; background: #FFFFFF; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 16px rgba(0,0,0,0.04);"
                             onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#FFC81A'; this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">
                            <div style="width: 42px; height: 42px; border-radius: 12px; background: #FFC81A; border:1.5px solid #131218; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; color:#131218; box-shadow: 0 4px 12px rgba(255,200,26,0.25);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <div>
                                <p style="margin: 0; color: #0F172A; font-size: 26px; font-weight: 900; letter-spacing: -0.5px; line-height: 1;">2020</p>
                                <p style="margin: 4px 0 0; color: #D97706; font-size: 11.5px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px;">Tahun Berdiri</p>
                            </div>
                        </div>
                        <!-- Stat Card 2 -->
                        <div style="padding: 22px 20px; border-radius: 18px; background: #FFFFFF; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 16px rgba(0,0,0,0.04);"
                             onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#FFC81A'; this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">
                            <div style="width: 42px; height: 42px; border-radius: 12px; background: #FFC81A; border:1.5px solid #131218; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; color:#131218; box-shadow: 0 4px 12px rgba(255,200,26,0.25);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <div>
                                <p style="margin: 0; color: #0F172A; font-size: 26px; font-weight: 900; letter-spacing: -0.5px; line-height: 1;">342+</p>
                                <p style="margin: 4px 0 0; color: #D97706; font-size: 11.5px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px;">Total Alumni</p>
                            </div>
                        </div>
                        <!-- Stat Card 3 -->
                        <div style="padding: 22px 20px; border-radius: 18px; background: #FFFFFF; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 16px rgba(0,0,0,0.04);"
                             onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#FFC81A'; this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">
                            <div style="width: 42px; height: 42px; border-radius: 12px; background: #FFC81A; border:1.5px solid #131218; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; color:#131218; box-shadow: 0 4px 12px rgba(255,200,26,0.25);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            </div>
                            <div>
                                <p style="margin: 0; color: #0F172A; font-size: 26px; font-weight: 900; letter-spacing: -0.5px; line-height: 1;">25+</p>
                                <p style="margin: 4px 0 0; color: #D97706; font-size: 11.5px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px;">Program Aktif</p>
                            </div>
                        </div>
                        <!-- Stat Card 4 -->
                        <div style="padding: 22px 20px; border-radius: 18px; background: #FFFFFF; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; border: 1.5px solid #E2E8F0; box-shadow: 0 4px 16px rgba(0,0,0,0.04);"
                             onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#FFC81A'; this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">
                            <div style="width: 42px; height: 42px; border-radius: 12px; background: #FFC81A; border:1.5px solid #131218; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; color:#131218; box-shadow: 0 4px 12px rgba(255,200,26,0.25);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            </div>
                            <div>
                                <p style="margin: 0; color: #0F172A; font-size: 26px; font-weight: 900; letter-spacing: -0.5px; line-height: 1;">12+</p>
                                <p style="margin: 4px 0 0; color: #D97706; font-size: 11.5px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px;">Mitra Industri</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Visi Misi --}}
            <div id="content-visi" style="display:none;">
                <div style="display:grid;grid-template-columns:1fr;gap:24px;">
                    <div style="padding:28px 32px;background:#FFFFFF;border-radius:20px;border:1.5px solid #E2E8F0;box-shadow: 0 6px 20px rgba(0,0,0,0.04);transition:all .3s ease;"
                         onmouseover="this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';this.style.borderColor='#FFC81A'"
                         onmouseout="this.style.boxShadow='0 6px 20px rgba(0,0,0,0.04)';this.style.borderColor='#E2E8F0'">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                            <div style="width:40px;height:40px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                                @include('components.icon',['name'=>'star','size'=>18,'style'=>'color:#131218'])
                            </div>
                            <span style="font-size:22px;font-weight:900;color:#0F172A;letter-spacing:-0.5px;">Visi</span>
                        </div>
                        <p style="color:#334155;font-size:15px;line-height:1.8;margin:0;font-weight:500;">Menjadi unit pelatihan dan sertifikasi profesional yang mampu mencetak tenaga kerja yang berkualitas, terampil dan mandiri sesuai dengan Standar Kompetensi Nasional maupun Internasional sehingga dapat mengisi peluang kerja dan mampu menciptakan lapangan kerja.</p>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
                        <div style="padding:28px 32px;background:#FFFFFF;border-radius:20px;border:1.5px solid #E2E8F0;box-shadow: 0 6px 20px rgba(0,0,0,0.04);transition:all .3s ease;"
                             onmouseover="this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';this.style.borderColor='#FFC81A'"
                             onmouseout="this.style.boxShadow='0 6px 20px rgba(0,0,0,0.04)';this.style.borderColor='#E2E8F0'">
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
                                <div style="width:40px;height:40px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                                    @include('components.icon',['name'=>'zap','size'=>18,'style'=>'color:#131218'])
                                </div>
                                <span style="font-size:22px;font-weight:900;color:#0F172A;letter-spacing:-0.5px;">Misi</span>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:16px;">
                                @foreach([
                                    'Memberikan Pelatihan, Seminar dan Ujian Sertifikasi bertaraf Nasional dan Internasional.',
                                    'Membentuk SDM yang memiliki skill IT mulai dari tingkatan Pemahaman Dasar sampai Profesional.',
                                    'Berkontribusi terhadap peningkatan keterampilan anak bangsa dengan skil IT yang dimilik sehingga dapat berwirausaha dan juga menciptakan lapangan kerja.',
                                    'Membangun Profesionalisme dalam pekerjaan khususnya yang terkait keterampilan bidang Teknologi Informasi.'
                                ] as $misi)
                                <div style="display:flex;align-items:flex-start;gap:12px;">
                                    <div style="width:22px;height:22px;border-radius:6px;background:#FFC81A;border:1px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;color:#131218;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                    <span style="color:#334155;font-size:14px;line-height:1.7;font-weight:500;">{{ $misi }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div style="padding:28px 32px;background:#FFFFFF;border-radius:20px;border:1.5px solid #E2E8F0;box-shadow: 0 6px 20px rgba(0,0,0,0.04);transition:all .3s ease;"
                             onmouseover="this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';this.style.borderColor='#FFC81A'"
                             onmouseout="this.style.boxShadow='0 6px 20px rgba(0,0,0,0.04)';this.style.borderColor='#E2E8F0'">
                            <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
                                <div style="width:40px;height:40px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                                    @include('components.icon',['name'=>'check','size'=>18,'style'=>'color:#131218'])
                                </div>
                                <span style="font-size:22px;font-weight:900;color:#0F172A;letter-spacing:-0.5px;">Tujuan</span>
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
                                    <div style="width:22px;height:22px;border-radius:6px;background:#FFC81A;border:1px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;color:#131218;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                    <span style="color:#334155;font-size:14px;line-height:1.7;font-weight:500;">{{ $tujuan }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mitra --}}
            <div id="content-mitra" style="display:none;">
                <div style="text-align:center; max-width:540px; margin: 0 auto 32px;">
                    <h3 style="font-size:24px; font-weight:900; color:#0F172A; margin:0 0 10px;">Mitra Kolaborasi Strategis</h3>
                    <p style="color:#64748B; font-size:14px; line-height:1.6; margin:0; font-weight:500;">FIKOM Certification Center bekerja sama dengan berbagai penyedia sertifikasi dan vendor teknologi global untuk menghadirkan kurikulum berstandar internasional.</p>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));gap:24px;">
                    @foreach($mitras as $m)
                    <div style="padding:28px 24px;background:#FFFFFF;border-radius:20px;border:1.5px solid #E2E8F0;box-shadow: 0 4px 16px rgba(0,0,0,0.04);text-align:center;transition:all .3s ease;display:flex;flex-direction:column;align-items:center;justify-content:space-between;" 
                         onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#FFC81A'; this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';" 
                         onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='#E2E8F0'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">
                        @if($m->logo)
                        <img src="{{ asset('storage/'.$m->logo) }}" alt="{{ $m->nama_mitra }}" style="max-height:56px; max-width:160px; object-fit:contain; margin-bottom:16px;">
                        @else
                        <div style="width:52px; height:52px; border-radius:14px; background:#FFC81A; border:1.5px solid #131218; color:#131218; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:16px; margin-bottom:16px; box-shadow:0 4px 12px rgba(255,200,26,0.25);">
                            {{ Str::upper(Str::substr($m->inisial ?? $m->nama_mitra, 0, 4)) }}
                        </div>
                        @endif
                    <h4 style="color:#0F172A;font-size:16.5px;font-weight:900;margin:0 0 6px;line-height:1.3;">{{ $m->nama_mitra }}</h4>
                    <p style="color:#D97706;font-size:11px;margin:0 0 16px;text-transform:uppercase;font-weight:800;letter-spacing:0.5px;">Mitra Resmi FIKOM UMI</p>
                    
                    @if($m->link_website)
                    <a href="{{ $m->link_website }}" target="_blank" rel="noopener noreferrer" 
                       style="padding:9px 20px;font-size:12.5px;font-weight:800;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .2s;box-shadow:0 4px 10px rgba(255,200,26,0.25);"
                       onmouseover="this.style.background='#131218';this.style.color='#FFC81A';"
                       onmouseout="this.style.background='#FFC81A';this.style.color='#131218';">
                        Kunjungi Website ↗
                    </a>
                    @else
                    <span style="padding:7px 16px;font-size:11.5px;font-weight:800;background:#F1F5F9;color:#475569;border-radius:30px;border:1px solid #CBD5E1;">
                        Mitra Terverifikasi
                    </span>
                    @endif
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
                btn.style.color = '#64748B';
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
