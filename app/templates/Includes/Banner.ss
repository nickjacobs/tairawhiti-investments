<div class="page-banner"
    <% if $BannerImage && not $BannerVideo && not $BannerCloudflareStreamURL %>
    <% with $BannerImage %>
     style="background-image: url($FocusFill(2000,600).URL);
         background-position: {$FocusPoint.PercentageX}% {$FocusPoint.PercentageY}%;
         background-size: cover;"
    <% end_with %>
    <% end_if %>>
    <% if $BannerCloudflareStreamURL %>
        <video
            class="page-banner__video"
            preload="auto"
            autoplay
            muted
            loop
            playsinline
            data-hls-src="$BannerCloudflareStreamURL"
            <% if $BannerImage %>poster="$BannerImage.FocusFill(2400,800).URL"<% end_if %>
        ></video>
    <% else_if $BannerVideo %>
        <video
            class="page-banner__video"
            autoplay
            muted
            loop
            playsinline
            <% if $BannerImage %>poster="$BannerImage.FocusFill(2400,800).URL"<% end_if %>
        >
            <source src="$BannerVideo.URL" type="$BannerVideo.MimeType">
        </video>
    <% end_if %>
    <div class="banner__overlay"></div>
    <div class="page-banner__title">
        <h1>$BannerTitleForDisplay.PipeBr</h1>
        <% if $BannerTeReoTitle %><div class="page-banner__te-reo-title">$BannerTeReoTitle.PipeBr</div><% end_if %>
    </div>
</div>
