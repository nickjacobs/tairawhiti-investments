<header class="site-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <%-- Brand --%>
            <a class="navbar-brand" href="$BaseHref">
                <% include SiteLogo %>
            </a>

            <%-- Mobile toggle --%>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <%-- Nav menu --%>
            <div class="collapse navbar-collapse" id="main-nav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <% loop $Menu(1) %>
                        <% if $Children %>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <% if $isCurrent || $isSection %> active<% end_if %>" href="$Link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    $MenuTitle
                                </a>
                                <ul class="dropdown-menu">
                                    <% loop $Children %>
                                        <li>
                                            <a class="dropdown-item <% if $isCurrent || $isSection %> active<% end_if %>" href="$Link">$MenuTitle</a>
                                        </li>
                                    <% end_loop %>
                                </ul>
                            </li>
                        <% else %>
                            <li class="nav-item">
                                <a class="nav-link $IsCurrentOrSection.Nice <% if $isCurrent || $isSection %> active<% end_if %>" href="$Link"<% if $isCurrent || $isSection %> aria-current="page"<% end_if %>>
                                    $MenuTitle
                                </a>
                            </li>
                        <% end_if %>
                    <% end_loop %>
                </ul>
            </div>

        </div>
    </nav>
</header>
