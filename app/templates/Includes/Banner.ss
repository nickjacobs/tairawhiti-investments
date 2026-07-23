<section class="page-banner"<% if $BannerImage %> style="background-image: url('$BannerImage.Fill(1920,600).URL')"<% end_if %>>
    <div class="container">
        <h1 class="page-banner__title">$BannerTitle.PipeBr</h1>
        <% if $BannerTeReoTitle %><p class="page-banner__te-reo-title">$BannerTeReoTitle.PipeBr</p><% end_if %>
    </div>
</section>
