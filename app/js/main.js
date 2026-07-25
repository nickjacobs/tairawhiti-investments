

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


