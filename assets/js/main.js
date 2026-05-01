document.addEventListener('DOMContentLoaded', function() {
    const grid = document.querySelector('.motomotus-grid');
    if (!grid) return;

    const items = document.querySelectorAll('.motomotus-item');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const modal = document.getElementById('motomotus-video-modal');
    const modalContent = modal.querySelector('.video-container');
    const modalCaption = modal.querySelector('.modal-caption');
    const modalClose = modal.querySelector('.modal-close');
    const modalOverlay = modal.querySelector('.modal-overlay');

    // --- Hover Video Logic ---
    items.forEach(item => {
        const video = item.querySelector('.motomotus-preview-video');
        if (video) {
            item.addEventListener('mouseenter', () => {
                video.play();
            });
            item.addEventListener('mouseleave', () => {
                video.pause();
                video.currentTime = 0;
            });
        }

        // --- Magnetic Effect (Simple) ---
        item.addEventListener('mousemove', (e) => {
            const rect = item.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            
            gsap.to(item.querySelector('.motomotus-item-inner'), {
                x: x * 0.1,
                y: y * 0.1,
                duration: 0.5,
                ease: 'power2.out'
            });
        });

        item.addEventListener('mouseleave', () => {
            gsap.to(item.querySelector('.motomotus-item-inner'), {
                x: 0,
                y: 0,
                duration: 0.5,
                ease: 'power2.out'
            });
        });

        // --- Open Modal ---
        item.addEventListener('click', () => {
            const videoUrl = item.getAttribute('data-video');
            const caption = item.getAttribute('data-caption');
            if (!videoUrl) return;

            let videoHtml = '';
            if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                const videoId = videoUrl.split('v=')[1] || videoUrl.split('/').pop();
                videoHtml = `<iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`;
            } else if (videoUrl.includes('vimeo.com')) {
                const videoId = videoUrl.split('/').pop();
                videoHtml = `<iframe src="https://player.vimeo.com/video/${videoId}?autoplay=1" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>`;
            } else {
                videoHtml = `<video src="${videoUrl}" controls autoplay></video>`;
            }

            modalContent.innerHTML = videoHtml;
            modalCaption.innerHTML = caption ? `<div class="caption-inner">${caption}</div>` : '';
            
            modal.style.display = 'flex';
            gsap.fromTo(modal, { opacity: 0 }, { opacity: 1, duration: 0.3 });
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
                if (filter === 'all' || item.classList.contains(filter)) {
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
            });
        });
    });

    // --- Modal Closing ---
    const closeModal = () => {
        gsap.to(modal, {
            opacity: 0,
            duration: 0.3,
            onComplete: () => {
                modal.style.display = 'none';
                modalContent.innerHTML = '';
                modalCaption.innerHTML = '';
            }
        });
    };

    modalClose.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', closeModal);

    // --- Entrance Animation ---
    gsap.from('.motomotus-item', {
        y: 50,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out'
    });
});
