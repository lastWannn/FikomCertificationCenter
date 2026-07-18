/**
 * FCC Landing Pendaftaran — Step Animation
 * Menyamaratakan animasi step dengan landing/index.
 */
(function () {
    'use strict';

    const STEP_COUNT = 4;
    let curStep = 0, stepTimer;

    // Warna berbeda karena background putih (bukan hitam)
    function setStep(s) {
        curStep = s;

        for (let i = 0; i < STEP_COUNT; i++) {
            const box   = document.getElementById(`step-${i}`);
            if (!box) continue;
            const ic    = box.querySelector('svg');
            const num   = box.querySelector('.step-num-badge');
            const isActive = i === s;
            const isPast   = i < s;

            // Box styling (light background variant)
            box.style.background = isActive
                ? 'linear-gradient(135deg,#FFC81A,#FFD84D)'
                : isPast ? 'rgba(255,200,26,.1)' : '#FFF';
            box.style.border = isActive ? 'none'
                : isPast ? '2px solid rgba(255,200,26,.4)' : '2px solid #E2E4EB';
            box.style.boxShadow = isActive ? '0 8px 28px rgba(255,200,26,.45)' : '0 2px 8px rgba(0,0,0,.06)';

            if (ic) ic.style.color = isActive ? '#131218' : (isPast ? '#FFC81A' : '#A0A3AD');
            if (num) {
                num.style.background = i <= s ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : '#E2E4EB';
                num.style.color      = i <= s ? '#131218' : '#9CA3B0';
            }
        }

        // Update progress line fill (0%, 33.3%, 66.6%, 100%)
        const fill = document.getElementById('step-fill-pend');
        if (fill) fill.style.width = ['0%','33.3%','66.6%','100%'][s];

        // Update dots
        document.querySelectorAll('#step-dots-pend .step-dot').forEach((d, i) => {
            d.style.width      = i === s ? '20px' : '8px';
            d.style.background = i === s ? '#FFC81A' : '#E2E4EB';
        });
    }

    function startTimer() {
        stepTimer = setInterval(() => setStep((curStep + 1) % STEP_COUNT), 2400);
    }

    // Global callbacks dipanggil dari onclick di Blade
    window.setStepPend   = setStep;
    window.hovStepPend   = (i) => { clearInterval(stepTimer); setStep(i); };
    window.unhovStepPend = () => startTimer();

    document.addEventListener('DOMContentLoaded', () => {
        setStep(0);
        startTimer();
    });
})();
