<%----------------------------------------------------------------
Meta
----------------------------------------------------------------%>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="pinterest" content="nopin" />
<meta name="robots" content="noindex, nofollow" />

<%----------------------------------------------------------------
Base Tag
----------------------------------------------------------------%>

<% base_tag %>

<%----------------------------------------------------------------
Meta tags
----------------------------------------------------------------%>

$MetaTags(false)


<%----------------------------------------------------------------
Found Tags
----------------------------------------------------------------%>
$FoundTags

<%----------------------------------------------------------------
Favion
----------------------------------------------------------------%>
<% include FavIcon %>


<%----------------------------------------------------------------
Google Tag
----------------------------------------------------------------%>
<% if $SiteConfig.GoogleTag %>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={$SiteConfig.GoogleTag}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{$SiteConfig.GoogleTag}');
    </script>
<% end_if %>


<link rel="alternate" href="$AbsoluteLink" hreflang="en-nz">
<link rel="canonical" href="$AbsoluteLink">

<% require css('css/style.css') %>


