<div class="footer">
    <div class="container">
        <div class="row top-row">
            <div class="col-md-5">
                <div class="footer-logo">
                    <a href="/">
                        <% include FooterLogo %>
                    </a>
            </div>
            </div>
            <div class="col-md-7">
                <div class="footer-menus">
                    <ul class="list-unstyled list-inline d-flex gap-5">
                        <% loop Menu(1) %>
                            <li class="nav-item list-inline-item">
                                <a class="nav-link" href="$Link">
                                    $MenuTitle
                                </a>
                            </li>
                        <% end_loop %>
                    </ul>
                </div>
                <div class="copy-privacy">
                    <div class="copyright">
                        Copyright © $Now.Year Tāirawhiti Investments Ltd, all rights reserved.
                    </div>
                    <div class="privacy">
                        <a class="nav-link" href="privacy-policy">Privacy policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
