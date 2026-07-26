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
                <a href="#$URLSegment" class="pill-link">
                    $Title
                    <span class="pill-link__arrow pill-link__arrow--down" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 512 512"><path d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068s-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314"/></svg>
                    </span>
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

                    <div class="portfolio-content-row">
                        <div class="portfolio-content">
                            $Content
                        </div>
                        <div class="portfolio-sidebar">
                            <div class="portfolio-details-col">
                                <div class="portfolio__performance">
                                    $Performance
                                </div>
                            </div>
                            <% if $FindOutMoreLink %>
                                <% with $FindOutMoreLink %>
                                    <a href="$URL" class="pill-link" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
                                        $Title
                                        <span class="pill-link__arrow" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 512 512"><path d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068s-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314"/></svg>
                                        </span>
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

