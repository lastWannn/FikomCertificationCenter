/**
 * FCC Landing Pendaftaran — Step Animation
 * Menyamaratakan animasi step dengan landing/index.
 */
(function () {
    'use strict';

    const STEP_COUNT = 4;
    let curStep = 0, stepTimer;

    // Animasi step untuk dark mode
    function setStep(s) {
        curStep = s;

        for (let i = 0; i < STEP_COUNT; i++) {
            const wrapper = document.getElementById(`step-${i}`);
            if (!wrapper) continue;
            
            const box   = document.getElementById(`step-box-${i}`);
            const ic    = box ? box.querySelector('svg') : null;
            const num   = wrapper.querySelector('.step-num-badge');
            const title = document.getElementById(`step-title-${i}`);
            
            const isActive = i === s;
            const isPast   = i < s;

            // Box styling (Dark Mode Premium)
            if (box) {
                box.style.background = isActive
                    ? 'linear-gradient(135deg,#FFC81A,#FFD84D)'
                    : isPast ? 'rgba(255,255,255,.05)' : 'rgba(255,255,255,.03)';
                box.style.border = isActive ? '2px solid transparent'
                    : isPast ? '2px solid rgba(255,200,26,.3)' : '2px solid rgba(255,255,255,.08)';
                box.style.boxShadow = isActive ? '0 8px 28px rgba(255,200,26,.45)' : '0 2px 8px rgba(0,0,0,.2)';
            }

            if (ic) ic.style.color = isActive ? '#111' : (isPast ? '#FFC81A' : 'rgba(255,255,255,.4)');
            
            if (num) {
                num.style.background = i <= s ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : 'rgba(255,255,255,.08)';
                num.style.color      = i <= s ? '#111' : 'rgba(255,255,255,.6)';
            }
            if (title) {
                title.style.color = isActive ? '#FFF' : 'rgba(255,255,255,.6)';
            }
        }

        // Update progress line fill (0%, 33.3%, 66.6%, 100%)
        const fill = document.getElementById('step-fill-pend');
        if (fill) fill.style.width = ['0%','33.3%','66.6%','100%'][s];

        // Update dots
        document.querySelectorAll('#step-dots div').forEach((d, i) => {
            d.style.width      = i === s ? '20px' : '8px';
            d.style.background = i === s ? '#FFC81A' : 'rgba(255,255,255,.1)';
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
