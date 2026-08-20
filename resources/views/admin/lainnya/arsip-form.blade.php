@extends('layouts.admin')
@section('title', 'Edit Arsip Kegiatan')
@section('page-content')
<div style="padding:24px;max-width:760px;margin:0 auto;width:100%;">
    
    {{-- Header --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.arsip.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;font-weight:600;" onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#6B7280'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Daftar Arsip
        </a>
        <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">Edit Arsip Kegiatan</h1>
        <p style="color:#6B7280;font-size:13.5px;margin:0;">Lengkapi berita acara, ringkasan, dan dokumentasi foto-foto kegiatan.</p>
    </div>

    {{-- Card Form --}}
    <div class="fcc-card" style="padding:28px;border-radius:16px;">
        @if($errors->any())
        <div style="background:#FEF2F2; border:1.5px solid #FCA5A5; color:#991B1B; padding:14px 18px; border-radius:12px; margin-bottom:20px; font-size:13px;">
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

        <form action="{{ route('admin.arsip.update', $arsip) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT')

            <div style="margin-bottom:18px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Judul Arsip *</label>
                <input type="text" name="judul" value="{{ old('judul', isset($arsip) ? $arsip->judul : '') }}" placeholder="Judul ringkasan atau dokumentasi kegiatan" required class="fcc-input" style="font-size:13.5px;height:40px;">
            </div>

            <div style="margin-bottom:18px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Ringkasan / Deskripsi Kegiatan</label>
                <textarea name="ringkasan" rows="4" placeholder="Tuliskan ringkasan hasil pelaksanaan kegiatan..." class="fcc-input" style="resize:vertical;font-size:13px;padding:10px 14px;">{{ old('ringkasan', isset($arsip) ? $arsip->ringkasan : '') }}</textarea>
            </div>

            <div style="margin-bottom:22px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">File Berita Acara (PDF / Lampiran)</label>
                <input type="file" name="berita_acara" accept=".pdf,.doc,.docx,.zip" class="fcc-input" style="padding:8px;font-size:12.5px;">
                @if(isset($arsip) && $arsip->berita_acara)
                <div style="margin-top:8px;font-size:12px;color:#10B981;display:flex;align-items:center;gap:6px;font-weight:700;">
                    @include('components.icon',['name'=>'file-text','size'=>14])
                    File terlampir: <a href="{{ asset('storage/'.$arsip->berita_acara) }}" target="_blank" style="color:#3B82F6;text-decoration:underline;">{{ basename($arsip->berita_acara) }}</a>
                </div>
                @endif
            </div>

            <hr style="border:none;border-top:1.5px dashed #E2E4EB;margin:22px 0;">

            {{-- UPLOAD FOTO DOKUMENTASI KEGIATAN (ASYNC PROGRESS BAR) --}}
            <div style="margin-bottom:24px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.7px;">
                    Upload Foto-Foto Dokumentasi Kegiatan
                </label>
                <p style="font-size:12px;color:#6B7280;margin:0 0 12px;">Pilih foto kegiatan (PNG, JPG, JPEG, WEBP, HEIC - hingga 40MB/foto). Foto akan langsung diunggah secara async dengan indikator progress real-time.</p>
                
                {{-- Input File Async --}}
                <label style="display:flex;align-items:center;justify-content:center;gap:10px;border:2px dashed #E2E4EB;border-radius:12px;padding:20px;cursor:pointer;background:#F8F9FB;transition:all .2s;"
                       onmouseover="this.style.borderColor='#FFC81A';this.style.background='#FFFDF5'"
                       onmouseout="this.style.borderColor='#E2E4EB';this.style.background='#F8F9FB'">
                    @include('components.icon',['name'=>'camera','size'=>22,'style'=>'color:#FFC81A'])
                    <div>
                        <p style="margin:0;font-size:13.5px;font-weight:800;color:#131218;">Klik untuk Pilih &amp; Unggah Foto Kegiatan</p>
                        <p style="margin:2px 0 0;font-size:11.5px;color:#9CA3B0;">Dapat memilih beberapa foto sekaligus. Progress unggah akan tampil di bawah.</p>
                    </div>
                    <input type="file" id="foto-input-file" accept="image/*" multiple style="display:none;" onchange="handleAsyncFileUpload(this)">
                </label>

                {{-- Progress List Container --}}
                <div id="async-progress-list" style="display:flex; flex-direction:column; gap:10px; margin-top:14px;"></div>

                {{-- Hidden Inputs Container for Pre-uploaded Paths --}}
                <div id="uploaded-hidden-inputs"></div>

                {{-- Foto Dokumentasi Yang Sudah Ter-upload Sebelumnya (Tersimpan di DB) --}}
                @if(isset($arsip) && !empty($arsip->dokumentasi))
                <div style="margin-top:22px;">
                    <p style="font-size:11px;font-weight:800;color:#131218;margin:0 0 10px;text-transform:uppercase;">
                        Dokumentasi Foto Tersimpan ({{ count($arsip->dokumentasi) }} foto):
                    </p>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(110px, 1fr));gap:12px;">
                        @foreach($arsip->dokumentasi as $img)
                        <div style="position:relative;border-radius:10px;overflow:hidden;border:1.5px solid #E2E4EB;background:#F7F8FA;aspect-ratio:4/3;">
                            <img src="{{ asset('storage/'.$img) }}" alt="Dokumentasi" style="width:100%;height:100%;object-fit:cover;">
                            
                            {{-- Checkbox Hapus Foto --}}
                            <label style="position:absolute;top:6px;right:6px;background:rgba(239,68,68,.9);color:#FFF;padding:3px 6px;border-radius:6px;font-size:10px;font-weight:800;cursor:pointer;display:flex;align-items:center;gap:3px;box-shadow:0 2px 6px rgba(0,0,0,.2);">
                                <input type="checkbox" name="delete_dokumentasi[]" value="{{ $img }}" style="cursor:pointer;accent-color:#EF4444;"> Hapus
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Buttons --}}
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:28px;">
                <a href="{{ route('admin.arsip.index') }}" class="fcc-btn-outline-dark" style="padding:10px 20px;font-size:13px;text-decoration:none;border-radius:10px;">
                    Batal
                </a>
                <button type="submit" id="btn-submit-arsip" class="fcc-btn-gold" style="padding:10px 28px;font-size:13px;border-radius:10px;font-weight:800;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                    @include('components.icon',['name'=>'check','size'=>15]) Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
const uploadUrl = "{{ route('admin.arsip.upload-foto') }}";
const csrfToken = "{{ csrf_token() }}";

function formatFileSize(bytes) {
    if (!bytes || bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
}

function handleAsyncFileUpload(input) {
    const files = Array.from(input.files);
    if (!files.length) return;

    const progressList = document.getElementById('async-progress-list');
    const hiddenInputs = document.getElementById('uploaded-hidden-inputs');

    files.forEach((file) => {
        const fileId = 'file-' + Date.now() + '-' + Math.random().toString(36).substr(2, 6);

        // Create Progress UI Card
        const card = document.createElement('div');
        card.id = fileId;
        card.style.cssText = 'background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:12px; padding:12px 14px; display:flex; align-items:center; gap:14px; box-shadow:0 2px 8px rgba(0,0,0,0.03); transition:all 0.2s ease;';

        card.innerHTML = `
            <div style="width:46px; height:46px; border-radius:8px; background:#131218; overflow:hidden; flex-shrink:0; display:flex; align-items:center; justify-content:center;" id="thumb-${fileId}">
                <span style="color:#FFC81A; font-size:10px; font-weight:900;">IMG</span>
            </div>
            <div style="flex:1; min-width:0;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                    <p style="margin:0; font-size:13px; font-weight:800; color:#0F172A; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="${file.name}">${file.name}</p>
                    <span id="status-text-${fileId}" style="font-size:11.5px; font-weight:900; color:#D97706; white-space:nowrap;">0%</span>
                </div>
                <div style="width:100%; height:8px; background:#F1F5F9; border-radius:100px; overflow:hidden; position:relative;">
                    <div id="bar-${fileId}" style="width:0%; height:100%; background:linear-gradient(90deg, #FFC81A, #F59E0B); border-radius:100px; transition:width 0.15s ease;"></div>
                </div>
                <div style="display:flex; justify-content:space-between; margin-top:4px;">
                    <span style="font-size:11px; color:#64748B; font-weight:600;">${formatFileSize(file.size)}</span>
                    <span id="substatus-${fileId}" style="font-size:11px; color:#64748B; font-weight:600;">Mengunggah...</span>
                </div>
            </div>
            <button type="button" onclick="cancelOrRemoveUpload('${fileId}')" style="background:none; border:none; color:#94A3B8; cursor:pointer; padding:6px; border-radius:8px; font-size:14px; display:inline-flex; align-items:center; transition:all 0.2s;" onmouseover="this.style.color='#EF4444';this.style.background='#FEE2E2'" onmouseout="this.style.color='#94A3B8';this.style.background='none'" title="Hapus">✕</button>
        `;

        progressList.appendChild(card);

        // Render preview image thumbnail
        const reader = new FileReader();
        reader.onload = function(e) {
            const thumbWrap = document.getElementById(`thumb-${fileId}`);
            if (thumbWrap) {
                thumbWrap.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            }
        };
        reader.readAsDataURL(file);

        // Perform XHR Async Upload
        const formData = new FormData();
        formData.append('foto', file);
        formData.append('_token', csrfToken);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', uploadUrl, true);

        // Progress Handler (0% -> 100%)
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                const bar = document.getElementById(`bar-${fileId}`);
                const statusText = document.getElementById(`status-text-${fileId}`);
                const substatus = document.getElementById(`substatus-${fileId}`);

                if (bar) bar.style.width = percent + '%';
                if (statusText) statusText.innerText = percent + '%';
                if (substatus) substatus.innerText = `Mengunggah (${percent}%)...`;
            }
        };

        // Complete Handler
        xhr.onload = function() {
            const statusText = document.getElementById(`status-text-${fileId}`);
            const substatus = document.getElementById(`substatus-${fileId}`);
            const bar = document.getElementById(`bar-${fileId}`);

            if (xhr.status === 200) {
                try {
                    const res = JSON.parse(xhr.responseText);
                    if (res.success && res.path) {
                        if (bar) {
                            bar.style.width = '100%';
                            bar.style.background = '#10B981';
                        }
                        if (statusText) {
                            statusText.innerText = '✔ Selesai';
                            statusText.style.color = '#10B981';
                        }
                        if (substatus) {
                            substatus.innerText = 'Berhasil diunggah & dikompres';
                            substatus.style.color = '#059669';
                        }

                        // Add hidden input for form post
                        const inputHidden = document.createElement('input');
                        inputHidden.type = 'hidden';
                        inputHidden.name = 'uploaded_dokumentasi[]';
                        inputHidden.value = res.path;
                        inputHidden.id = `input-${fileId}`;
                        hiddenInputs.appendChild(inputHidden);
                    } else {
                        showUploadError(fileId, res.message || 'Gagal mengunggah foto.');
                    }
                } catch (err) {
                    showUploadError(fileId, 'Respon server tidak valid.');
                }
            } else {
                let errMsg = 'Gagal mengunggah (HTTP ' + xhr.status + ')';
                try {
                    const res = JSON.parse(xhr.responseText);
                    if (res.message) errMsg = res.message;
                    if (res.errors && res.errors.foto) errMsg = res.errors.foto[0];
                } catch (e) {}
                showUploadError(fileId, errMsg);
            }
        };

        xhr.onerror = function() {
            showUploadError(fileId, 'Koneksi jaringan terputus.');
        };

        xhr.send(formData);
    });

    // Reset input value
    input.value = '';
}

function showUploadError(fileId, message) {
    const statusText = document.getElementById(`status-text-${fileId}`);
    const substatus = document.getElementById(`substatus-${fileId}`);
    const bar = document.getElementById(`bar-${fileId}`);

    if (bar) {
        bar.style.width = '100%';
        bar.style.background = '#EF4444';
    }
    if (statusText) {
        statusText.innerText = '✖ Gagal';
        statusText.style.color = '#EF4444';
    }
    if (substatus) {
        substatus.innerText = message;
        substatus.style.color = '#DC2626';
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
