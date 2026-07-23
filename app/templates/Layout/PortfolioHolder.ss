$Content

<% if $PortfolioItems %>
    <nav class="portfolio-nav">
        <ul>
            <% loop $PortfolioItems %>
                <li><a href="#$URLSegment">$Title</a></li>
            <% end_loop %>
        </ul>
    </nav>

    <div class="portfolio-sections">
        <% loop $PortfolioItems %>
            <section id="$URLSegment" class="portfolio-section">
                <h2>$Title</h2>
                <% if $FeaturedImage %>
                    <div class="portfolio-section__image">
                        $FeaturedImage.Fill(1200,600)
                    </div>
                <% end_if %>
                <% if $Summary %><p class="portfolio-section__summary">$Summary</p><% end_if %>
                $Content
            </section>
        <% end_loop %>
    </div>
<% end_if %>
