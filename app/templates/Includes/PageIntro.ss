<% if $PageIntro %>
    <div class="container">
        <div class="page-intro">
            $PageIntro
        </div>
        <% if $LearnMoreLink || $OurStoryVideo %>
            <div class="container">
                <div class="page-intro__links">
                    <% include PageIntroLinks %>
                </div>
            </div>
        <% end_if %>

    </div>
<% end_if %>
