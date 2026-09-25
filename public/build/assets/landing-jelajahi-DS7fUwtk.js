(function(){window.showDaftarModal=function(t,a,e){const o=document.getElementById("daftar-modal"),s=document.getElementById("modal-judul"),i=document.getElementById("daftar-form"),d=document.getElementById("biaya-section");if(o){if(s&&(s.textContent=a),i){const r=(i.dataset.baseUrl||(window.APP_URL?window.APP_URL.replace(/\/$/,"")+"/peserta/daftar":"/peserta/daftar")).replace(/\/$/,"");i.action=`${r}/${t}`;const n=i.querySelector('button[type="submit"]');n&&(n.disabled=!1,n.style.opacity="1",n.style.cursor="pointer",n.innerHTML="✔ Konfirmasi Pendaftaran")}if(d)if(e&&e.length>0){const l=e.map((r,n)=>`
                    <label style="display:flex;align-items:center;gap:12px;background:${n===0?"#FFFDF5":"#F7F8FA"};border:2px solid ${n===0?"#FFC81A":"#E2E4EB"};border-radius:12px;padding:12px 16px;margin-bottom:10px;cursor:pointer;transition:all 0.18s ease;"
                           onclick="highlightBiayaOption(this)">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <input type="radio" name="biaya_kegiatan_id" value="${r.id}" ${n===0?"checked":""} style="accent-color:#FFC81A;width:17px;height:17px;cursor:pointer;" required>
                            <span style="font-size:13.5px;font-weight:800;color:#0F0F14;">${r.nama_jenis}</span>
                        </div>
                    </label>
                `).join("");d.innerHTML=`
                    <p style="font-size:11px;font-weight:900;color:#131218;text-transform:uppercase;letter-spacing:0.7px;margin:0 0 10px;">
                        Pilih Kategori Peserta Anda:
                    </p>
                    <div style="margin-bottom:18px;" id="biaya-radio-group">
                        ${l}
                    </div>
                `}else d.innerHTML=`
                    <div style="background:#ECFDF5;border:1.5px solid #10B981;border-radius:12px;padding:14px;margin-bottom:18px;color:#065F46;font-size:13.5px;font-weight:800;text-align:center;">
                        ✓ Kegiatan ini Gratis! Anda akan langsung terdaftar setelah konfirmasi.
                    </div>
                `;o.style.display="flex",o.setAttribute("aria-hidden","false")}},window.highlightBiayaOption=function(t){const a=document.getElementById("biaya-radio-group");a&&a.querySelectorAll("label").forEach(e=>{const o=e.querySelector("input");o&&o.checked?(e.style.borderColor="#FFC81A",e.style.background="#FFFDF5"):(e.style.borderColor="#E2E4EB",e.style.background="#F7F8FA")})},window.closeDaftarModal=function(){const t=document.getElementById("daftar-modal");t&&(t.style.display="none",t.setAttribute("aria-hidden","true"))},document.addEventListener("DOMContentLoaded",()=>{const t=document.getElementById("daftar-modal");t&&t.addEventListener("click",e=>{e.target===t&&window.closeDaftarModal()}),document.addEventListener("keydown",e=>{e.key==="Escape"&&window.closeDaftarModal()});const a=document.getElementById("daftar-form");a&&a.addEventListener("submit",function(){const e=a.querySelector('button[type="submit"]');e&&(e.disabled=!0,e.style.opacity="0.75",e.style.cursor="wait",e.innerHTML='<span style="display:inline-flex;align-items:center;gap:8px;">⏳ Memproses Pendaftaran...</span>')})})})();
