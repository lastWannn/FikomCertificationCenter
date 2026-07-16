@php
    $title    = $pageTitle ?? '';
    $subtitle = $pageSubtitle ?? '';
@endphp
<div style="background:#131218;padding:44px 24px 36px;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;opacity:.04;background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);background-size:60px 60px;"></div>
    <div style="max-width:1100px;margin:0 auto;position:relative;z-index:1;">
        <h1 class="fcc-gold-text" style="font-size:clamp(24px,4vw,42px);font-weight:900;margin:0 0 8px;">{{ $title }}</h1>
        @if($subtitle)<p style="color:rgba(255,255,255,.55);font-size:15px;margin:0;">{{ $subtitle }}</p>@endif
    </div>
</div>