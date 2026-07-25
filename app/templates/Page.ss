<!DOCTYPE html>
<html lang="$ContentLocale" class="">
<head>
<% include Meta %>
</head>
<body class="{$ClassName.ShortName.LowerCase} page--{$URLSegment} $PageClass" id="top">

<div class="page-wrapper">
    <div class="header-banner">
        <% include Header %>
        <% include Banner %>
        <% include PageIntro %>
    </div>
    <div class="page-layout">
        <!-- start layout -->
            $Layout
            <!-- end layout -->
    </div>
</div>
<% include Footer %>
<% require javascript('js/scripts.min.js') %>
</body>
</html>
