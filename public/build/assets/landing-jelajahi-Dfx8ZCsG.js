(function(){window.showDaftarModal=function(t,n,e){const o=document.getElementById("daftar-modal"),s=document.getElementById("modal-judul"),i=document.getElementById("daftar-form"),r=document.getElementById("biaya-section");if(o){if(s&&(s.textContent=n),i){i.action=`/peserta/daftar/${t}`;const a=i.querySelector('button[type="submit"]');a&&(a.disabled=!1,a.style.opacity="1",a.style.cursor="pointer",a.innerHTML="✔ Konfirmasi Pendaftaran")}if(r)if(e&&e.length>0){const a=e.map((l,d)=>`
                    <label style="display:flex;align-items:center;gap:12px;background:${d===0?"#FFFDF5":"#F7F8FA"};border:2px solid ${d===0?"#FFC81A":"#E2E4EB"};border-radius:12px;padding:12px 16px;margin-bottom:10px;cursor:pointer;transition:all 0.18s ease;"
                           onclick="highlightBiayaOption(this)">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <input type="radio" name="biaya_kegiatan_id" value="${l.id}" ${d===0?"checked":""} style="accent-color:#FFC81A;width:17px;height:17px;cursor:pointer;" required>
                            <span style="font-size:13.5px;font-weight:800;color:#0F0F14;">${l.nama_jenis}</span>
                        </div>
                    </label>
                `).join("");r.innerHTML=`
                    <p style="font-size:11px;font-weight:900;color:#131218;text-transform:uppercase;letter-spacing:0.7px;margin:0 0 10px;">
                        Pilih Kategori Peserta Anda:
                    </p>
                    <div style="margin-bottom:18px;" id="biaya-radio-group">
                        ${a}
                    </div>
                `}else r.innerHTML=`
                    <div style="background:#ECFDF5;border:1.5px solid #10B981;border-radius:12px;padding:14px;margin-bottom:18px;color:#065F46;font-size:13.5px;font-weight:800;text-align:center;">
                        ✓ Kegiatan ini Gratis! Anda akan langsung terdaftar setelah konfirmasi.
                    </div>
                `;o.style.display="flex",o.setAttribute("aria-hidden","false")}},window.highlightBiayaOption=function(t){const n=document.getElementById("biaya-radio-group");n&&n.querySelectorAll("label").forEach(e=>{const o=e.querySelector("input");o&&o.checked?(e.style.borderColor="#FFC81A",e.style.background="#FFFDF5"):(e.style.borderColor="#E2E4EB",e.style.background="#F7F8FA")})},window.closeDaftarModal=function(){const t=document.getElementById("daftar-modal");t&&(t.style.display="none",t.setAttribute("aria-hidden","true"))},document.addEventListener("DOMContentLoaded",()=>{const t=document.getElementById("daftar-modal");t&&t.addEventListener("click",e=>{e.target===t&&window.closeDaftarModal()}),document.addEventListener("keydown",e=>{e.key==="Escape"&&window.closeDaftarModal()});const n=document.getElementById("daftar-form");n&&n.addEventListener("submit",function(){const e=n.querySelector('button[type="submit"]');e&&(e.disabled=!0,e.style.opacity="0.75",e.style.cursor="wait",e.innerHTML='<span style="display:inline-flex;align-items:center;gap:8px;">⏳ Memproses Pendaftaran...</span>')})})})();
