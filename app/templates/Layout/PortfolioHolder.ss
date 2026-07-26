<% if $Content %>
<div class="container">
    <div class="page-content reading-width typ">
        $Content
    </div>
</div>
<% end_if %>
<div class="container">
    <% if $PortfolioItems %>
        <nav class="portfolio-nav justify-content-center">
            <% loop $PortfolioItems %>
                <a href="#$URLSegment" class="pill-link pill-link--down">
                    $Title
                </a>
            <% end_loop %>
        </nav>

        <div class="portfolio-sections">
            <% loop $PortfolioItems %>
                <section id="$URLSegment" class="portfolio-section">
                    <div class="title-row">
                        <h2>
                        <% if $Logo %>
                            <div class="portfolio__logo">
                                $Logo.ScaleHeight(400)
                            </div>
                        <% end_if %>
                            <span class="visually-hidden">$Title</span>
                        </h2>
                    </div>
                    <% if $FeaturedImages %>
                        <div class="tile-grid">
                            <% loop $FeaturedImages.Sort('SortOrder') %>
                                <div class="tile">
                                    $Fill(600,600)
                                </div>
                            <% end_loop %>
                        </div>
                    <% end_if %>

                    <div class="content-row">
                        <div class="content-column typ">
                            $Content
                        </div>
                        <div class="content-sidebar">
                            <div class="details-panel">
                                <div class="details-panel__body">
                                    $Performance
                                </div>
                            </div>
                            <% if $FindOutMoreLink %>
                                <% with $FindOutMoreLink %>
                                    <a href="$URL" class="pill-link" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
                                        $Title
                                    </a>
                                <% end_with %>
                            <% end_if %>
                        </div>
                    </div>




                </section>
            <% end_loop %>
        </div>
    <% end_if %>
</div>

