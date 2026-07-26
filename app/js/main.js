

$(function() {

    // Staff bios are absolutely positioned overlays (see _staff.scss) so opening
    // one never changes the page's layout height - it floats over whatever's
    // below it rather than pushing it down. This just works out where "below
    // the row" is, since that varies with the responsive column count, and
    // where the clicked tile sits horizontally, so the connecting arrow can
    // point back up at it.
    var STAFF_BIO_GAP = 20;

    function positionStaffBio($bio) {
        var $tile = $('[data-bs-target="#' + $bio.attr('id') + '"]').closest('.staff-tile');

        if (!$tile.length) {
            return;
        }

        var rowTop = $tile[0].offsetTop;
        var $rowTiles = $tile.closest('.staff-tiles').children('.staff-tile').filter(function() {
            return this.offsetTop === rowTop;
        });

        var rowBottom = 0;
        $rowTiles.each(function() {
            rowBottom = Math.max(rowBottom, this.offsetTop + this.offsetHeight);
        });

        var tileCenter = $tile[0].offsetLeft + ($tile[0].offsetWidth / 2);

        $bio.css('top', rowBottom + STAFF_BIO_GAP);
        $bio[0].style.setProperty('--staff-bio-arrow-left', tileCenter + 'px');
    }

    $(document).on('show.bs.collapse', '.staff-row-bio', function() {
        var $bio = $(this);

        if ($bio.closest('.staff-block--horizontal').length) {
            return;
        }

        // Only one bio open at a time per row of tiles.
        $bio.closest('.staff-tiles').find('.staff-row-bio.show').not($bio).each(function() {
            bootstrap.Collapse.getOrCreateInstance(this).hide();
        });

        positionStaffBio($bio);
    });

    $(window).on('resize', function() {
        $('.staff-row-bio.show').each(function() {
            positionStaffBio($(this));
        });
    });

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

    // .svg-texts sits next to .svg-images as a sibling inside .svg-wrapper,
    // not inside it - pin the shared parent so the text column stays fixed
    // alongside the images instead of scrolling away from them.
    const pinTarget = wrapper.closest('.svg-wrapper') || wrapper;

    gsap.registerPlugin(ScrollTrigger);

    gsap.set([text1, text2, text3], { opacity: 0 });
    gsap.set([element1, element2, element3], { opacity: 1, y: 0 });

    const tl = gsap.timeline({
        defaults: { duration: 0.8, ease: 'power2.out' },
        scrollTrigger: {
            trigger: pinTarget,
            // With pin:true, wherever this sits when the trigger fires is
            // where it stays fixed for the whole scrub range. Pinning flush
            // to 'top top' leaves no headroom above the wrapper, but
            // .svg-images sits top:60px inside it and element1 moves y:-80
            // during the split, landing 20px above the viewport's top edge
            // (off-screen). +=100 offsets the pin down to leave enough room
            // above for that upward shift, with a little margin to spare.
            start: 'top top+=100',
            // How far you have to scroll past `start` for the timeline to go
            // from 0% to 100% complete - tune this to slow down/speed up the
            // scrub without touching the animation steps themselves.
            end: '+=1500',
            // Ties timeline progress directly to scroll position instead of
            // autoplaying; the number is a smoothing lag in seconds so it
            // doesn't feel too mechanically 1:1 with the scrollbar.
            scrub: 1,
            pin: true,
        },
    });

    // .svg-image-1/.svg-image-2 overlap by ~74px at rest, and .svg-image-2/
    // .svg-image-3 overlap by ~77px - offset must clear both with room to
    // spare or the pieces still collide mid-animation.
    tl.to(element1, { y: -80 }, 'split')
        .to(element3, { y: 100 }, 'split');

    tl.to([element2, element3], { opacity: 0.6 }, 'reveal1')
        .to(text1, { opacity: 1 }, 'reveal1');

    tl.to({}, { duration: 1 });

    tl.to([element1, element3], { opacity: 0.6 }, 'reveal2')
        .to(element2, { opacity: 1 }, 'reveal2')
        .to(text2, { opacity: 1 }, 'reveal2');

    tl.to({}, { duration: 1 });

    tl.to([element1, element2], { opacity: 0.6 }, 'reveal3')
        .to(element3, { opacity: 1 }, 'reveal3')
        .to(text3, { opacity: 1 }, 'reveal3');

    tl.to({}, { duration: 1 });

    tl.to([element1, element2, element3], { y: 0, opacity: 1 }, 'converge');
});
