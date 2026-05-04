document.addEventListener('DOMContentLoaded', function() {
    const grid = document.querySelector('.motomotus-grid');
    if (!grid) return;

    // Ensure GSAP is loaded
    if (typeof gsap === 'undefined') {
        console.warn('Motomotus Portfolio: GSAP is not loaded. Animations will be disabled.');
    }

    const items = document.querySelectorAll('.motomotus-item');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const modal = document.getElementById('motomotus-video-modal');
    if (!modal) return;

    const modalContent = modal.querySelector('.video-container');
    const modalCaption = modal.querySelector('.modal-caption');
    const modalClose = modal.querySelector('.modal-close');
    const modalOverlay = modal.querySelector('.modal-overlay');

    /**
     * Extracts Video ID from various YouTube/Vimeo formats
     */
    function getEmbedUrl(url) {
        let videoHtml = '';
        
        // YouTube
        const ytRegex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i;
        const ytMatch = url.match(ytRegex);
        
        // Vimeo
        const vimeoRegex = /(?:vimeo\.com\/|player\.vimeo\.com\/video\/)([0-9]+)/i;
        const vimeoMatch = url.match(vimeoRegex);

        if (ytMatch && ytMatch[1]) {
            videoHtml = `<iframe src="https://www.youtube.com/embed/${ytMatch[1]}?autoplay=1&rel=0" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`;
        } else if (vimeoMatch && vimeoMatch[1]) {
            videoHtml = `<iframe src="https://player.vimeo.com/video/${vimeoMatch[1]}?autoplay=1" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`;
        } else {
            // Fallback to direct video link
            videoHtml = `<video src="${url}" controls autoplay playsinline></video>`;
        }
        
        return videoHtml;
    }

    // --- Hover Video Logic ---
    items.forEach(item => {
        const video = item.querySelector('.motomotus-preview-video');
        const inner = item.querySelector('.motomotus-item-inner');

        if (video) {
            item.addEventListener('mouseenter', () => {
                video.play().catch(e => console.log('Autoplay prevented'));
            });
            item.addEventListener('mouseleave', () => {
                video.pause();
                video.currentTime = 0;
            });
        }

        // --- Magnetic Effect ---
        if (typeof gsap !== 'undefined' && inner) {
            item.addEventListener('mousemove', (e) => {
                const rect = item.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                
                gsap.to(inner, {
                    x: x * 0.1,
                    y: y * 0.1,
                    duration: 0.5,
                    ease: 'power2.out'
                });
            });

            item.addEventListener('mouseleave', () => {
                gsap.to(inner, {
                    x: 0,
                    y: 0,
                    duration: 0.5,
                    ease: 'power2.out'
                });
            });
        }

        // --- Open Modal ---
        item.addEventListener('click', () => {
            const videoUrl = item.getAttribute('data-video');
            const caption = item.getAttribute('data-caption');
            if (!videoUrl) return;

            modalContent.innerHTML = getEmbedUrl(videoUrl);
            modalCaption.innerHTML = caption ? `<div class="caption-inner">${caption}</div>` : '';
            
            modal.style.display = 'flex';
            if (typeof gsap !== 'undefined') {
                gsap.fromTo(modal, { opacity: 0 }, { opacity: 1, duration: 0.3 });
            } else {
                modal.style.opacity = '1';
            }
        });
    });

    // --- Filtering Logic ---
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter');
            
            // Update buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Filter items
            items.forEach(item => {
                const isVisible = (filter === 'all' || item.classList.contains(filter));
                
                if (typeof gsap !== 'undefined') {
                    if (isVisible) {
                        gsap.to(item, {
                            opacity: 1,
                            scale: 1,
                            duration: 0.4,
                            display: 'block',
                            ease: 'power2.out'
                        });
                    } else {
                        gsap.to(item, {
                            opacity: 0,
                            scale: 0.8,
                            duration: 0.4,
                            display: 'none',
                            ease: 'power2.out'
                        });
                    }
                } else {
                    item.style.display = isVisible ? 'block' : 'none';
                    item.style.opacity = isVisible ? '1' : '0';
                }
            });
        });
    });

    // --- Modal Closing ---
    const closeModal = () => {
        if (typeof gsap !== 'undefined') {
            gsap.to(modal, {
                opacity: 0,
                duration: 0.3,
                onComplete: () => {
                    modal.style.display = 'none';
                    modalContent.innerHTML = '';
                    modalCaption.innerHTML = '';
                }
            });
        } else {
            modal.style.display = 'none';
            modalContent.innerHTML = '';
            modalCaption.innerHTML = '';
        }
    };

    if (modalClose) modalClose.addEventListener('click', closeModal);
    if (modalOverlay) modalOverlay.addEventListener('click', closeModal);

    // --- Entrance Animation ---
    if (typeof gsap !== 'undefined') {
        gsap.from('.motomotus-item', {
            y: 50,
            opacity: 0,
            duration: 0.8,
            stagger: 0.1,
            ease: 'power3.out'
        });
    }
});
