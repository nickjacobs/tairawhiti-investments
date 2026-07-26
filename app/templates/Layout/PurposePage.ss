
<div class="container">
    <% if $PerformanceHighlights %>
        <div class="content-row">
            <div class="content-column reading-width typ">
                $Content
            </div>
            <div class="content-sidebar">
                <div class="details-panel">
                    <div class="details-panel__body">
                        $PerformanceHighlights
                    </div>
                </div>
            </div>
        </div>
    <% else %>
        <div class="page-content reading-width typ">
            $Content
        </div>
    <% end_if %>
</div>
