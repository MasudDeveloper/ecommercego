<!-- ======================================================== -->
<!-- edokanpro Conversion Boosters & FOMO Sales Accelerator  -->
<!-- 1. Urgency Countdown Offer Bar                            -->
<!-- 2. Recent Sales Notification Popup (Live Ticker)          -->
<!-- 3. Mobile Sticky Order Bar                                -->
<!-- 4. Abandoned Cart Auto-Capture                            -->
<!-- ======================================================== -->

<!-- 1. Top Urgency Countdown Banner -->
<div id="edokanproUrgencyBanner" style="background: linear-gradient(90deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%); color: #ffffff; padding: 10px 16px; font-size: 13.5px; font-weight: 600; text-align: center; position: sticky; top: 0; z-index: 99998; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.25); display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 8px 16px;">
    <div style="display: inline-flex; align-items: center; gap: 6px;">
        <span style="font-size: 16px; animation: flamePulse 1.2s infinite alternate;">🔥</span>
        <span>আজকের বিশেষ ধামাকা অফার! আর মাত্র</span>
        <span id="edokanproCountdown" style="background: #ffffff; color: #b91c1c; font-family: monospace; font-size: 14px; font-weight: 800; padding: 2px 8px; border-radius: 6px; letter-spacing: 1px;">
            14:59
        </span>
        <span>মিনিট বাকি!</span>
    </div>
    <div style="display: inline-flex; align-items: center; gap: 8px;">
        <span style="color: #fef08a; font-weight: 700;">(ফ্রি হোম ডেলিভারি ও বিশেষ ক্যাশব্যাক)</span>
        <a href="#order_form" onclick="scrollToOrderForm(event)" style="background: #ffffff; color: #b91c1c; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(0,0,0,0.15); transition: transform 0.2s ease;">
            অর্ডার করুন ➜
        </a>
    </div>
</div>

<!-- 2. Recent Sales Notification Popup (Live Ticker) -->
<div id="edokanproSalesTicker" style="position: fixed; bottom: 85px; left: 20px; z-index: 99997; background: #ffffff; border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); border: 1px solid #e2e8f0; padding: 12px 16px; display: none; align-items: center; gap: 12px; max-width: 340px; font-family: inherit; transform: translateY(20px); opacity: 0; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);">
    <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px; color: #2563eb;">
        📦
    </div>
    <div style="flex: 1; min-width: 0;">
        <div style="font-size: 13px; font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" id="tickerCustomerName">
            মোহাম্মদ রফিক (উত্তরা, ঢাকা)
        </div>
        <div style="font-size: 11.5px; color: #64748b; margin-top: 1px;" id="tickerProductName">
            এইমাত্র ১টি পণ্য অর্ডার করেছেন!
        </div>
        <div style="display: flex; align-items: center; gap: 6px; margin-top: 4px;">
            <span style="font-size: 10.5px; color: #10b981; font-weight: 700; display: inline-flex; align-items: center; gap: 2px;">
                ✓ ভেরিফাইড ক্রেতা
            </span>
            <span style="font-size: 10.5px; color: #94a3b8;">•</span>
            <span style="font-size: 10.5px; color: #94a3b8;" id="tickerTimeAgo">২ মিনিট আগে</span>
        </div>
    </div>
    <button type="button" onclick="closeSalesTicker()" style="background: transparent; border: none; font-size: 18px; color: #94a3b8; cursor: pointer; padding: 0 4px; line-height: 1;">
        &times;
    </button>
</div>

<!-- 3. Mobile Sticky Order Bar -->
<div id="edokanproMobileStickyBar" style="position: fixed; bottom: 0; left: 0; right: 0; background: #ffffff; border-top: 1px solid #e2e8f0; box-shadow: 0 -4px 20px rgba(0,0,0,0.1); padding: 10px 16px; z-index: 99996; display: none; align-items: center; justify-content: space-between; gap: 12px;">
    <div>
        <div style="font-size: 11px; color: #16a34a; font-weight: 700; display: flex; align-items: center; gap: 4px;">
            <span style="width: 6px; height: 6px; background: #16a34a; border-radius: 50%; display: inline-block;"></span>
            ক্যাশ অন ডেলিভারি
        </div>
        <div style="font-size: 15px; font-weight: 800; color: #0f172a;" id="stickyProductPrice">
            অফার চলছে
        </div>
    </div>
    <a href="#order_form" onclick="scrollToOrderForm(event)" style="background: linear-gradient(135deg, #e2136e 0%, #be125a 100%); color: #ffffff; font-size: 14.5px; font-weight: 700; padding: 12px 24px; border-radius: 50px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 15px rgba(226, 19, 110, 0.4); animation: stickyPulse 1.8s infinite;">
        <span>🛒</span> <span>এখনই অর্ডার করুন</span>
    </a>
</div>

<style>
    @keyframes flamePulse {
        0% { transform: scale(1); }
        100% { transform: scale(1.25); }
    }
    @keyframes stickyPulse {
        0% { box-shadow: 0 0 0 0 rgba(226, 19, 110, 0.6); }
        70% { box-shadow: 0 0 0 10px rgba(226, 19, 110, 0); }
        100% { box-shadow: 0 0 0 0 rgba(226, 19, 110, 0); }
    }
    @media (max-width: 768px) {
        #edokanproMobileStickyBar {
            display: flex !important;
        }
        #edokanproSalesTicker {
            bottom: 75px !important;
            left: 10px !important;
            right: 10px !important;
            max-width: none !important;
        }
    }
</style>

<script>
    // 1. Smooth Scroll to Order Form
    function scrollToOrderForm(e) {
        if (e) e.preventDefault();
        const targets = [
            document.getElementById('order_form'),
            document.getElementById('checkout-form'),
            document.querySelector('form[action*="order"]'),
            document.querySelector('input[name="name"]'),
            document.querySelector('input[name="billing_name"]'),
            document.querySelector('#order_section')
        ];
        for (let target of targets) {
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const input = target.querySelector('input[type="text"]') || target;
                if (input && typeof input.focus === 'function') {
                    setTimeout(() => input.focus(), 600);
                }
                return;
            }
        }
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }

    // 2. Countdown Timer (15 Minutes with LocalStorage Persistence)
    (function initCountdown() {
        const timerKey = 'edokanpro_countdown_end';
        let endTime = localStorage.getItem(timerKey);
        const duration = 15 * 60 * 1000; // 15 minutes

        if (!endTime || Date.now() > parseInt(endTime)) {
            endTime = Date.now() + duration;
            localStorage.setItem(timerKey, endTime);
        }

        const countdownEl = document.getElementById('edokanproCountdown');
        if (!countdownEl) return;

        function updateTimer() {
            let remaining = parseInt(endTime) - Date.now();
            if (remaining <= 0) {
                // Reset loop
                endTime = Date.now() + duration;
                localStorage.setItem(timerKey, endTime);
                remaining = duration;
            }

            const minutes = Math.floor(remaining / 60000);
            const seconds = Math.floor((remaining % 60000) / 1000);
            countdownEl.innerText = 
                (minutes < 10 ? '0' : '') + minutes + ':' + 
                (seconds < 10 ? '0' : '') + seconds;
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    })();

    // 3. Live Recent Sales Ticker (Realistic Bangladeshi Buyers)
    const recentBuyers = [
        { name: "মোহাম্মদ রফিক", location: "উত্তরা, ঢাকা", time: "২ মিনিট আগে" },
        { name: "তানভীর হাসান", location: "জিইসি, চট্টগ্রাম", time: "৪ মিনিট আগে" },
        { name: "আরিফুল ইসলাম", location: "ধানমন্ডি, ঢাকা", time: "১ মিনিট আগে" },
        { name: "সাদিয়া জাহান", location: "মিরপুর ১০, ঢাকা", time: "৫ মিনিট আগে" },
        { name: "মোস্তাফিজুর রহমান", location: "উপশহর, সিলেট", time: "৩ মিনিট আগে" },
        { name: "ফারজানা আক্তার", location: "বনশ্রী, ঢাকা", time: "৬ মিনিট আগে" },
        { name: "নাবিল মাহমুদ", location: "বোয়ালিয়া, রাজশাহী", time: "২ মিনিট আগে" },
        { name: "শাকিল আহমেদ", location: "খুলনা সদর", time: "৪ মিনিট আগে" },
        { name: "মাহমুদুল হাসান", location: "যাত্রাবাড়ী, ঢাকা", time: "১ মিনিট আগে" },
        { name: "ইসমাইল হোসেন", location: "বগুড়া সদর", time: "৭ মিনিট আগে" }
    ];

    let currentBuyerIndex = 0;
    const tickerEl = document.getElementById('edokanproSalesTicker');
    const tickerNameEl = document.getElementById('tickerCustomerName');
    const tickerTimeEl = document.getElementById('tickerTimeAgo');
    let tickerDismissed = false;

    function showNextSalesTicker() {
        if (tickerDismissed || !tickerEl) return;

        const buyer = recentBuyers[currentBuyerIndex];
        currentBuyerIndex = (currentBuyerIndex + 1) % recentBuyers.length;

        tickerNameEl.innerText = buyer.name + ' (' + buyer.location + ')';
        tickerTimeEl.innerText = buyer.time;

        tickerEl.style.display = 'flex';
        setTimeout(() => {
            tickerEl.style.transform = 'translateY(0)';
            tickerEl.style.opacity = '1';
        }, 50);

        // Hide after 5.5 seconds
        setTimeout(() => {
            if (!tickerDismissed && tickerEl) {
                tickerEl.style.transform = 'translateY(20px)';
                tickerEl.style.opacity = '0';
                setTimeout(() => {
                    tickerEl.style.display = 'none';
                }, 400);
            }
        }, 5500);
    }

    function closeSalesTicker() {
        tickerDismissed = true;
        if (tickerEl) {
            tickerEl.style.transform = 'translateY(20px)';
            tickerEl.style.opacity = '0';
            setTimeout(() => tickerEl.style.display = 'none', 400);
        }
    }

    // Start ticker after 3 seconds, then show every 22 seconds
    setTimeout(() => {
        showNextSalesTicker();
        setInterval(showNextSalesTicker, 22000);
    }, 3000);

    // 4. Abandoned Cart Auto-Capture (Listens to phone input)
    (function initAbandonedCartCapture() {
        let captureTimer = null;
        let lastCapturedPhone = '';

        document.addEventListener('input', function (e) {
            const target = e.target;
            if (!target) return;

            const nameAttr = (target.name || '').toLowerCase();
            const idAttr = (target.id || '').toLowerCase();
            const typeAttr = (target.type || '').toLowerCase();

            const isPhoneInput = nameAttr.includes('phone') || nameAttr.includes('mobile') || idAttr.includes('phone') || idAttr.includes('mobile') || typeAttr === 'tel';

            if (isPhoneInput) {
                clearTimeout(captureTimer);
                captureTimer = setTimeout(() => {
                    const cleanPhone = (target.value || '').replace(/[^0-9]/g, '');
                    if (cleanPhone.length >= 11 && cleanPhone !== lastCapturedPhone) {
                        lastCapturedPhone = cleanPhone;

                        // Find customer name and address nearby
                        let form = target.closest('form') || document;
                        let nameInput = form.querySelector('input[name*="name"], input[id*="name"]');
                        let addressInput = form.querySelector('textarea, input[name*="address"], input[id*="address"]');

                        let customerName = nameInput ? nameInput.value : '';
                        let customerAddress = addressInput ? addressInput.value : '';

                        // Send AJAX to server
                        fetch('/api/v1/store/capture-abandoned-cart', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            body: JSON.stringify({
                                phone: cleanPhone,
                                name: customerName,
                                address: customerAddress,
                                page_url: window.location.href,
                                store_slug: window.location.pathname.split('/')[1] || ''
                            })
                        }).catch(err => console.debug('Cart capture:', err));
                    }
                }, 1500); // 1.5s after typing finishes
            }
        });
    })();
</script>
<!-- ======================================================== -->

