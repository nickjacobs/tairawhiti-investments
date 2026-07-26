<div class="container ">
    <div class="tiles-intro text-center">
        $TilesContent

        <% if $TilesHeaderLink %>
            <% with $TilesHeaderLink %>
                <a href="$URL" class="pill-link tiles-intro__link" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
                    $Title
                    <span class="pill-link__arrow" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 512 512"><path d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068s-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314"/></svg>
                    </span>
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
                        <% if $Up.Tile1Image %>$Up.Tile1Image.Fill(600,600)<% end_if %>
                        <span class="tile__overlay"></span>
                        <span class="tile__title">
                            $Title
                            <span class="tile__arrow" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 512 512"><path d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068s-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314"/></svg>
                            </span>
                        </span>
                    </a>
                <% end_with %>
            <% end_if %>
            <% if $Tile2Link %>
                <% with $Tile2Link %>
                    <a href="$URL" class="tile" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
                        <% if $Up.Tile2Image %>$Up.Tile2Image.Fill(600,600)<% end_if %>
                        <span class="tile__overlay"></span>
                        <span class="tile__title">
                            $Title
                            <span class="tile__arrow" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 512 512"><path d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068s-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314"/></svg>
                            </span>
                        </span>
                    </a>
                <% end_with %>
            <% end_if %>
            <% if $Tile3Link %>
                <% with $Tile3Link %>
                    <a href="$URL" class="tile" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
                        <% if $Up.Tile3Image %>$Up.Tile3Image.Fill(600,600)<% end_if %>
                        <span class="tile__overlay"></span>
                        <span class="tile__title">
                            $Title
                            <span class="tile__arrow" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 512 512"><path d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068s-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314"/></svg>
                            </span>
                        </span>
                    </a>
                <% end_with %>
            <% end_if %>
        </div>
    </div>
<% end_if %>
