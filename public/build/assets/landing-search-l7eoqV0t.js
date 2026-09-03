(function(){function o(e){return e?e.charAt(0).toUpperCase()+e.slice(1):""}function c(){const e=document.getElementById("main-search"),n=document.getElementById("search-dropdown");if(!e||!n)return;let r;e.addEventListener("input",()=>{clearTimeout(r),r=setTimeout(async()=>{var i;const s=e.value.trim();if(s.length<2){n.style.display="none";return}try{const a=await fetch(`/api/search?q=${encodeURIComponent(s)}&ajax=1`,{headers:{"X-Requested-With":"XMLHttpRequest"}}).then(t=>t.json());if(!((i=a.results)!=null&&i.length)){n.style.display="none";return}n.innerHTML=a.results.map(t=>`
                        <a href="${t.url}" class="search-drop-item">
                            <div class="search-drop-icon">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="#FFC81A" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                            <div class="search-drop-text">
                                <span class="search-drop-judul">${t.judul}</span>
                                <span class="search-drop-meta">
                                    ${o(t.jenis)} &bull; ${t.tanggal} &bull; <strong>${t.biaya}</strong>
                                </span>
                            </div>
                        </a>
                    `).join("")+`<a href="/api/search?q=${encodeURIComponent(s)}" class="search-drop-all">
                        Lihat semua ${a.total} hasil &rarr;
                    </a>`,n.style.display="block"}catch{}},280)}),document.addEventListener("click",s=>{s.target.closest("#search-form")||(n.style.display="none")})}document.addEventListener("DOMContentLoaded",c)})();
