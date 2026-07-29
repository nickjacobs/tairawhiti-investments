

$(function() {

    // Cloudflare Stream banner videos: point them at the HLS manifest, using
    // native playback where supported (Safari) and hls.js everywhere else for
    // adaptive bitrate.
    $('[data-hls-src]').each(function() {
        var video = this;
        var src = video.getAttribute('data-hls-src');

        if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = src;
        } else if (window.Hls && Hls.isSupported()) {
            var hls = new Hls();
            hls.loadSource(src);
            hls.attachMedia(video);
        }
    });

    // Any video inside a modal plays when the modal opens and stops (pauses and
    // rewinds) when it closes, rather than carrying on playing behind the scenes.
    $(document).on('shown.bs.modal', '.modal', function() {
        var video = this.querySelector('video');

        if (video) {
            video.play();
        }
    });

    $(document).on('hidden.bs.modal', '.modal', function() {
        var video = this.querySelector('video');

        if (video) {
            video.pause();
            video.currentTime = 0;
        }
    });

}); // end of document ready


document.addEventListener('DOMContentLoaded', () => {
    const bannerTitle = document.querySelector('.page-banner__title h1');

    if (!bannerTitle) {
        return;
    }

    gsap.registerPlugin(SplitText);

    // `mask: 'lines'` wraps each line in its own overflow:hidden box so the
    // yPercent slide-up reveals from behind a clean edge rather than
    // visibly sliding in from outside the banner. linesClass names that
    // wrapper (as `banner-line-mask`) so _header-banner.scss can pad it
    // out to stop descenders getting clipped.
    const titleSplit = SplitText.create(bannerTitle, { type: 'lines', mask: 'lines', linesClass: 'banner-line' });

    const tl = gsap.timeline({ defaults: { ease: 'power3.out', duration: 1.4 } });
    tl.from(titleSplit.lines, { yPercent: 100, opacity: 0, stagger: 0.3 });

    const teReoTitle = document.querySelector('.page-banner__title2');

    if (teReoTitle) {
        const teReoSplit = SplitText.create(teReoTitle, { type: 'lines', mask: 'lines', linesClass: 'banner-line' });
        tl.from(teReoSplit.lines, { yPercent: 100, opacity: 0, stagger: 0.3 }, '-=0.6');

        // BannerTitle2 (rendered here) gets the brand accent colour instead
        // of it being tied to the main title happening to wrap to 2 lines
        // (see .line--accent in _header-banner.scss).
        teReoSplit.lines.forEach((line) => line.classList.add('line--accent'));
    }
});


document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('.svg-images');

    if (!wrapper) {
        return;
    }

    // Each element is now its own wrapper div with a self-contained <svg>,
    // absolutely positioned to recreate the assembled logo - animate the
    // wrapper, not the shapes inside it (their own <svg> viewBox is sized
    // tight to their content, so moving them internally just clips them).
    const element1 = wrapper.querySelector('.svg-image-1');
    const element2 = wrapper.querySelector('.svg-image-2');
    const element3 = wrapper.querySelector('.svg-image-3');

    const text1 = document.querySelector('.svg-text1');
    const text2 = document.querySelector('.svg-text2');
    const text3 = document.querySelector('.svg-text3');

    // ScrollTrigger reference point - start/end below are calculated relative
    // to .svg-wrapper's own position.
    const pinTarget = wrapper.closest('.svg-wrapper') || wrapper;

    gsap.registerPlugin(ScrollTrigger);

    // Below 900px the elements are laid out statically/stacked instead (see
    // _svg-animation.scss) - the whole split/reveal/converge animation is
    // gsap.matchMedia()'d to min-width:900px so it never runs there, and
    // gsap automatically reverts every tween/ScrollTrigger created inside
    // when a resize crosses back below that width.
    const mm = gsap.matchMedia();

    mm.add('(min-width: 900px)', () => {
        gsap.set([text1, text2, text3], { opacity: 0 });
        gsap.set([element1, element2, element3], { opacity: 1, y: 0 });

        const tl = gsap.timeline({
            defaults: { duration: 0.8, ease: 'power2.out' },
            scrollTrigger: {
                trigger: pinTarget,
                // .svg-images (the logo) is 356px tall and sits top:60px inside
                // the wrapper, so its vertical center is 60 + 356/2 = 238px below
                // the wrapper's own top edge. 'top+=238 50%' fires once that
                // center point - not the wrapper's top edge - reaches the
                // vertical middle of the viewport, and the 50% (rather than a
                // fixed px offset) keeps it scaling with viewport height.
                start: 'top+=238 50%',
                end: '+=1200',
                // No pin/scrub - the timeline autoplays on its own once `start`
                // is reached. No onLeaveBack handler - scrolling back up doesn't
                // interrupt it, so it always runs through to completion once
                // triggered, regardless of what the user does with scroll
                // afterwards. Scrolling back down and re-entering still restarts
                // it fresh via onEnter.
                onEnter: () => tl.timeScale(1).restart(),
            },
        });

        // Marks which image/text pair is "active" (picks up its brand colour -
        // see .svg-image--N.active / .svg-textN.active in _svg-animation.scss).
        // A full-state set rather than +=/-= class deltas so it's deterministic
        // scrubbing in either direction, not just playing forward.
        const setActiveElement = (activeImage, activeText) => {
            [element1, element2, element3].forEach((el) => el.classList.toggle('active', el === activeImage));
            [text1, text2, text3].forEach((el) => el.classList.toggle('active', el === activeText));
        };

        // .svg-image-1/.svg-image-2 overlap by ~74px at rest, and .svg-image-2/
        // .svg-image-3 overlap by ~77px - offset must clear both with room to
        // spare or the pieces still collide mid-animation.
        tl.to(element1, { y: -80 }, 'split')
            .to(element3, { y: 100 }, 'split')
            // Clears any active colour when scrubbing back past reveal1 - without
            // this, reversing past the start of the reveal sequence leaves
            // element1/text1 stuck active since nothing before reveal1 resets it.
            .call(setActiveElement, [null, null], 'split');

        // Text fades in at 1.5x the default speed (0.8s / 1.5) - reads quicker
        // than the logo-piece opacity dimming it's paired with, which stays at
        // the default duration.
        const TEXT_FADE_DURATION = 0.8 / 1.5;

        tl.to([element2, element3], { opacity: 0.6 }, 'reveal1')
            .to(text1, { opacity: 1, duration: TEXT_FADE_DURATION }, 'reveal1')
            .call(setActiveElement, [element1, text1], 'reveal1');

        tl.to({}, { duration: 1 });

        tl.to([element1, element3], { opacity: 0.6 }, 'reveal2')
            .to(element2, { opacity: 1 }, 'reveal2')
            .to(text2, { opacity: 1, duration: TEXT_FADE_DURATION }, 'reveal2')
            .call(setActiveElement, [element2, text2], 'reveal2');

        tl.to({}, { duration: 1 });

        tl.to([element1, element2], { opacity: 0.6 }, 'reveal3')
            .to(element3, { opacity: 1 }, 'reveal3')
            .to(text3, { opacity: 1, duration: TEXT_FADE_DURATION }, 'reveal3')
            .call(setActiveElement, [element3, text3], 'reveal3');

        // Longer hold than the pauses above - gives the last text time to be
        // read before the logo pieces rejoin.
        tl.to({}, { duration: 2 });

        tl.to([element1, element2, element3], { y: 0, opacity: 1 }, 'converge')
            .call(setActiveElement, [null, null], 'converge');
    });
});
