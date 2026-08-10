@extends('layouts.admin')
@section('title', isset($arsip) ? 'Edit Arsip Kegiatan' : 'Tambah Arsip Kegiatan')
@section('page-content')
<div style="padding:24px;max-width:760px;margin:0 auto;width:100%;">
    
    {{-- Header & Back Button --}}
    <div style="margin-bottom:24px;">
        <a href="{{ route('admin.arsip.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#131218;font-size:12.5px;font-weight:800;text-decoration:none;margin-bottom:12px;background:#FFFFFF;border:1.5px solid #131218;padding:6px 14px;border-radius:20px;transition:all .18s;"
           onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Daftar Arsip
        </a>
        <div style="display:flex;align-items:center;gap:10px;margin-top:6px;">
            <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Form Arsip</span>
            <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">{{ isset($arsip) ? 'Edit' : 'Tambah' }} Arsip Kegiatan</h1>
        </div>
        <p style="color:#64748B;font-size:13px;margin:6px 0 0;font-weight:500;">Lengkapi berita acara, ringkasan, dan dokumentasi foto-foto kegiatan.</p>
    </div>

    {{-- Card Form --}}
    <div class="fcc-card" style="padding:32px;border-radius:24px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 6px 24px rgba(0,0,0,0.04);">
        @if($errors->any())
        <div style="background:#FEF2F2; border:1.5px solid #FCA5A5; color:#991B1B; padding:14px 18px; border-radius:12px; margin-bottom:24px; font-size:13px;">
            <p style="margin:0 0 6px; font-weight:800; font-size:13.5px; display:flex; align-items:center; gap:6px;">
                @include('components.icon',['name'=>'alert-triangle','size'=>16,'style'=>'color:#DC2626'])
                Gagal Mengunggah / Validasi Data:
            </p>
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $err)
                <li style="margin-bottom:2px; font-weight:600;">{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ isset($arsip) ? route('admin.arsip.update', $arsip) : route('admin.arsip.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @if(isset($arsip)) @method('PUT') @endif

            @if(!isset($arsip))
            <div style="margin-bottom:20px;">
                <label style="font-size:11px;font-weight:800;color:#64748B;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.6px;">Pilih Kegiatan *</label>
                <select name="kegiatan_id" required class="fcc-input" style="font-size:13.5px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
                    <option value="">-- Pilih Kegiatan Selesai --</option>
                    @foreach($kegiatan as $k)
                    <option value="{{ $k->id }}">{{ $k->judul }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div style="margin-bottom:20px;">
                <label style="font-size:11px;font-weight:800;color:#64748B;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.6px;">Judul Arsip *</label>
                <input type="text" name="judul" value="{{ old('judul', isset($arsip) ? $arsip->judul : '') }}" placeholder="Judul ringkasan atau dokumentasi kegiatan" required class="fcc-input" style="font-size:13.5px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-size:11px;font-weight:800;color:#64748B;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.6px;">Ringkasan / Deskripsi Kegiatan</label>
                <textarea name="ringkasan" rows="4" placeholder="Tuliskan ringkasan hasil pelaksanaan kegiatan..." class="fcc-input" style="resize:vertical;font-size:13.5px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;padding:10px 14px;width:100%;box-sizing:border-box;">{{ old('ringkasan', isset($arsip) ? $arsip->ringkasan : '') }}</textarea>
            </div>

            <div style="margin-bottom:24px;">
                <label style="font-size:11px;font-weight:800;color:#64748B;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.6px;">File Berita Acara (PDF / Lampiran)</label>
                <input type="file" name="berita_acara" accept=".pdf,.doc,.docx,.zip" class="fcc-input" style="padding:8px 14px;font-size:13px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;width:100%;box-sizing:border-box;cursor:pointer;">
                @if(isset($arsip) && $arsip->berita_acara)
                <div style="margin-top:10px;font-size:12.5px;color:#059669;display:flex;align-items:center;gap:6px;font-weight:800;background:#ECFDF5;padding:8px 14px;border-radius:10px;border:1px solid #A7F3D0;">
                    @include('components.icon',['name'=>'file-text','size'=>14])
                    File terlampir: <a href="{{ asset('storage/'.$arsip->berita_acara) }}" target="_blank" style="color:#2563EB;text-decoration:underline;">{{ basename($arsip->berita_acara) }}</a>
                </div>
                @endif
            </div>

            <hr style="border:none;border-top:1.5px dashed #CBD5E1;margin:24px 0;">

            {{-- UPLOAD FOTO DOKUMENTASI KEGIATAN (ASYNC PROGRESS BAR) --}}
            <div style="margin-bottom:24px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:12px;text-transform:uppercase;letter-spacing:.7px;">
                    Upload Foto-Foto Dokumentasi Kegiatan
                </label>
                
                {{-- Input File Async Dropzone --}}
                <label style="display:flex;align-items:center;gap:14px;border:2px dashed #CBD5E1;border-radius:16px;padding:20px 24px;cursor:pointer;background:#F8FAFC;transition:all .2s;"
                       onmouseover="this.style.borderColor='#FFC81A';this.style.background='#FFFDF5'"
                       onmouseout="this.style.borderColor='#CBD5E1';this.style.background='#F8FAFC'">
                    <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        @include('components.icon',['name'=>'camera','size'=>22,'style'=>'color:#131218'])
                    </div>
                    <div>
                        <p style="margin:0;font-size:14px;font-weight:900;color:#131218;">Klik untuk Pilih &amp; Unggah Foto Kegiatan</p>
                        <p style="margin:2px 0 0;font-size:12px;color:#64748B;font-weight:500;">Pilih satu atau beberapa foto sekaligus (PNG, JPG, WEBP, HEIC).</p>
                    </div>
                    <input type="file" id="foto-input-file" accept="image/*" multiple style="display:none;" onchange="handleAsyncFileUpload(this)">
                </label>

                {{-- Progress Grid Gallery Container (Compact & Scrollable - Tidak Panjang ke Bawah) --}}
                <div id="async-progress-container" style="display:none; margin-top:14px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <span style="font-size:11px; font-weight:900; color:#131218; text-transform:uppercase; letter-spacing:0.5px;">
                            Foto Dokumentasi Baru Ditambahkan:
                        </span>
                        <span id="upload-summary-badge" style="font-size:11px; font-weight:800; color:#D97706; background:#FFFBEB; border:1px solid #FCD34D; padding:2px 8px; border-radius:10px;">
                            Memproses foto...
                        </span>
                    </div>

                    <div id="async-progress-list" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(110px, 1fr)); gap:10px; max-height:240px; overflow-y:auto; padding:10px; background:#F8FAFC; border:1.5px solid #CBD5E1; border-radius:14px;">
                    </div>
                </div>

                {{-- Hidden Inputs Container for Pre-uploaded Paths --}}
                <div id="uploaded-hidden-inputs"></div>

                {{-- Foto Dokumentasi Yang Sudah Ter-upload Sebelumnya (Tersimpan di DB) --}}
                @if(isset($arsip) && !empty($arsip->dokumentasi))
                <div style="margin-top:24px;">
                    <p style="font-size:11px;font-weight:800;color:#131218;margin:0 0 12px;text-transform:uppercase;letter-spacing:0.5px;">
                        Dokumentasi Foto Tersimpan ({{ count($arsip->dokumentasi) }} foto):
                    </p>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(110px, 1fr));gap:10px;max-height:240px;overflow-y:auto;padding:10px;background:#F8FAFC;border:1.5px solid #CBD5E1;border-radius:14px;">
                        @foreach($arsip->dokumentasi as $img)
                        <div style="position:relative;border-radius:10px;overflow:hidden;border:1.5px solid #CBD5E1;background:#131218;aspect-ratio:1/1;">
                            <img src="{{ asset('storage/'.$img) }}" alt="Dokumentasi" style="width:100%;height:100%;object-fit:cover;">
                            
                            {{-- Checkbox Hapus Foto --}}
                            <label style="position:absolute;top:4px;right:4px;background:rgba(239,68,68,.95);color:#FFF;padding:2px 6px;border-radius:6px;font-size:10px;font-weight:900;cursor:pointer;display:flex;align-items:center;gap:3px;box-shadow:0 2px 6px rgba(0,0,0,.2);">
                                <input type="checkbox" name="delete_dokumentasi[]" value="{{ $img }}" style="cursor:pointer;accent-color:#EF4444;"> Hapus
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Buttons --}}
            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:28px;border-top:1.5px solid #E2E4EB;padding-top:20px;">
                <a href="{{ route('admin.arsip.index') }}" style="padding:10px 18px;font-size:13px;font-weight:800;color:#131218;text-decoration:none;background:#FFFFFF;border:1.5px solid #131218;border-radius:10px;">
                    Batal
                </a>
                <button type="submit" id="btn-submit-arsip" style="padding:10px 24px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;display:inline-flex;align-items:center;gap:6px;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                    @include('components.icon',['name'=>'check','size'=>15]) {{ isset($arsip) ? 'Simpan Perubahan' : 'Simpan Arsip' }}
                </button>
            </div>

        </form>
    </div>
</div>


<script>
const uploadUrl = "{{ route('admin.arsip.upload-foto') }}";
const csrfToken = "{{ csrf_token() }}";

// Client-side instant image compression before uploading (Super Fast)
function compressImageBeforeUpload(file, maxDimension = 1600, quality = 0.82) {
    return new Promise((resolve) => {
        if (!file.type.startsWith('image/') || file.size < 400 * 1024) {
            resolve(file);
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            const img = new Image();
            img.onload = () => {
                let width = img.width;
                let height = img.height;

                if (width > maxDimension || height > maxDimension) {
                    if (width > height) {
                        height = Math.round((height * maxDimension) / width);
                        width = maxDimension;
                    } else {
                        width = Math.round((width * maxDimension) / height);
                        height = maxDimension;
                    }
                }

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;

                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob(
                    (blob) => {
                        if (blob && blob.size < file.size) {
                            const compressedFile = new File([blob], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            resolve(compressedFile);
                        } else {
                            resolve(file);
                        }
                    },
                    'image/jpeg',
                    quality
                );
            };
            img.onerror = () => resolve(file);
            img.src = e.target.result;
        };
        reader.onerror = () => resolve(file);
        reader.readAsDataURL(file);
    });
}

function handleAsyncFileUpload(input) {
    const files = Array.from(input.files);
    if (!files.length) return;

    const progressContainer = document.getElementById('async-progress-container');
    const progressList = document.getElementById('async-progress-list');
    const hiddenInputs = document.getElementById('uploaded-hidden-inputs');
    const summaryBadge = document.getElementById('upload-summary-badge');

    progressContainer.style.display = 'block';
    if (summaryBadge) summaryBadge.innerText = `Mengunggah ${files.length} foto...`;

    files.forEach((file) => {
        const fileId = 'file-' + Date.now() + '-' + Math.random().toString(36).substr(2, 6);

        // Create Grid Thumbnail Card (110px square)
        const card = document.createElement('div');
        card.id = fileId;
        card.style.cssText = 'position:relative; width:100%; aspect-ratio:1/1; border-radius:10px; overflow:hidden; border:1.5px solid #CBD5E1; background:#131218; box-shadow:0 2px 6px rgba(0,0,0,0.06);';

        card.innerHTML = `
            <div id="thumb-${fileId}" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#1E1D26;">
                <span style="color:#FFC81A; font-size:10px; font-weight:900;">...</span>
            </div>
            <div id="overlay-${fileId}" style="position:absolute; inset:0; background:rgba(19,18,24,0.7); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px; padding:6px; transition:all 0.2s;">
                <span id="status-text-${fileId}" style="color:#FFC81A; font-size:11px; font-weight:900;">0%</span>
                <div style="width:80%; height:4px; background:rgba(255,255,255,0.2); border-radius:100px; overflow:hidden;">
                    <div id="bar-${fileId}" style="width:0%; height:100%; background:#FFC81A; border-radius:100px; transition:width 0.15s ease;"></div>
                </div>
            </div>
            <button type="button" onclick="cancelOrRemoveUpload('${fileId}')" title="Hapus Foto" style="position:absolute; top:4px; right:4px; width:22px; height:22px; border-radius:50%; background:rgba(19,18,24,0.8); border:1px solid rgba(255,255,255,0.3); color:#FFFFFF; font-size:11px; font-weight:900; cursor:pointer; display:flex; align-items:center; justify-content:center; opacity:0.85; transition:all 0.2s; z-index:5;" onmouseover="this.style.background='#EF4444';this.style.opacity='1'" onmouseout="this.style.background='rgba(19,18,24,0.8)';this.style.opacity='0.85'">✕</button>
        `;

        progressList.appendChild(card);

        // Immediate Preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const thumbWrap = document.getElementById(`thumb-${fileId}`);
            if (thumbWrap) {
                thumbWrap.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            }
        };
        reader.readAsDataURL(file);

        // Async Compress + Upload Execution
        processSingleUpload(file, fileId, hiddenInputs);
    });

    input.value = '';
}

async function processSingleUpload(file, fileId, hiddenInputs) {
    const statusText = document.getElementById(`status-text-${fileId}`);
    const bar = document.getElementById(`bar-${fileId}`);
    const overlay = document.getElementById(`overlay-${fileId}`);
    const summaryBadge = document.getElementById('upload-summary-badge');

    try {
        if (statusText) statusText.innerText = 'Kompres...';
        const compressedFile = await compressImageBeforeUpload(file);

        const formData = new FormData();
        formData.append('foto', compressedFile);
        formData.append('_token', csrfToken);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', uploadUrl, true);

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                if (bar) bar.style.width = percent + '%';
                if (statusText) statusText.innerText = percent + '%';
            }
        };

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const res = JSON.parse(xhr.responseText);
                    if (res.success && res.path) {
                        if (overlay) {
                            overlay.style.background = 'rgba(16,185,129,0.25)';
                            overlay.innerHTML = `<span style="background:#10B981; color:#FFFFFF; width:22px; height:22px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:900; border:1px solid #FFFFFF;">✔</span>`;
                        }

                        const inputHidden = document.createElement('input');
                        inputHidden.type = 'hidden';
                        inputHidden.name = 'uploaded_dokumentasi[]';
                        inputHidden.value = res.path;
                        inputHidden.id = `input-${fileId}`;
                        hiddenInputs.appendChild(inputHidden);

                        if (summaryBadge) summaryBadge.innerText = 'Selesai diunggah';
                    } else {
                        showUploadErrorGrid(fileId, res.message || 'Gagal');
                    }
                } catch (e) {
                    showUploadErrorGrid(fileId, 'Error');
                }
            } else {
                showUploadErrorGrid(fileId, 'Gagal');
            }
        };

        xhr.onerror = function() {
            showUploadErrorGrid(fileId, 'Putus');
        };

        xhr.send(formData);
    } catch (e) {
        showUploadErrorGrid(fileId, 'Error');
    }
}

function showUploadErrorGrid(fileId, message) {
    const overlay = document.getElementById(`overlay-${fileId}`);
    if (overlay) {
        overlay.style.background = 'rgba(239,68,68,0.7)';
        overlay.innerHTML = `<span style="color:#FFFFFF; font-size:10px; font-weight:900; text-align:center;">✖ ${message}</span>`;
    }
}

function cancelOrRemoveUpload(fileId) {
    const card = document.getElementById(fileId);
    const hiddenInput = document.getElementById(`input-${fileId}`);
    if (card) card.remove();
    if (hiddenInput) hiddenInput.remove();
}
</script>
@endsection
