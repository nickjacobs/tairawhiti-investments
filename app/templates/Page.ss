<!DOCTYPE html>
<html lang="$ContentLocale" class="">
<head>
<% include Meta %>
</head>
<body class="{$ClassName.ShortName.LowerCase} page--{$URLSegment} $PageClass" id="top">

<div class="page-wrapper h-100">
    <% include Header %>
    <% include Banner %>
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
