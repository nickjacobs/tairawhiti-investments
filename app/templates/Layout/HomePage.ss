<div class="container ">
    <div class="tiles-intro text-center">
        $TilesContent

        <% if $TilesHeaderLink %>
            <% with $TilesHeaderLink %>
                <a href="$URL" class="pill-link tiles-intro__link" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
                    $Title
                </a>
            <% end_with %>
        <% end_if %>
    </div>
</div>

<% if $Tile1Link || $Tile2Link || $Tile3Link %>
    <div class="container">
        <div class="tile-grid">
            <% if $Tile1Link %>
                <% with $Tile1Link %>
                    <a href="$URL" class="tile" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
                        <% if $Up.Tile1Image %>$Up.Tile1Image.FocusFill(600,600)<% end_if %>
                        <span class="tile__overlay"></span>
                        <span class="tile__title">
                            $Title
                            <span class="tile__arrow" aria-hidden="true"></span>
                        </span>
                    </a>
                <% end_with %>
            <% end_if %>
            <% if $Tile2Link %>
                <% with $Tile2Link %>
                    <a href="$URL" class="tile" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
                        <% if $Up.Tile2Image %>$Up.Tile2Image.FocusFill(600,600)<% end_if %>
                        <span class="tile__overlay"></span>
                        <span class="tile__title">
                            $Title
                            <span class="tile__arrow" aria-hidden="true"></span>
                        </span>
                    </a>
                <% end_with %>
            <% end_if %>
            <% if $Tile3Link %>
                <% with $Tile3Link %>
                    <a href="$URL" class="tile" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
                        <% if $Up.Tile3Image %>$Up.Tile3Image.FocusFill(600,600)<% end_if %>
                        <span class="tile__overlay"></span>
                        <span class="tile__title">
                            $Title
                            <span class="tile__arrow" aria-hidden="true"></span>
                        </span>
                    </a>
                <% end_with %>
            <% end_if %>
        </div>
    </div>
<% end_if %>
