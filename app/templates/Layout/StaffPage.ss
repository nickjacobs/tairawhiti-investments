<div class="container">

    <div class="page-content reading-width typ">
        $Content
    </div>

    <% if $StaffBlocks %>
        <% loop $StaffBlocks %>
            <section class="staff-block">
                <h2>$Title</h2>

                <% if $Staff %>
                    <div class="staff-tiles">
                        <% loop $Staff %>
                            <div class="staff-tile">
                                <div class="staff-tile__photo">
                                    <% if $Photo %>
                                        $Photo.Fill(300,300)
                                    <% else %>
                                        <img src="/images/staff-placeholder.svg" alt="" />
                                    <% end_if %>
                                </div>
                                <h3>$Name</h3>
                                <% if $JobTitle %><p class="staff-tile__job-title">$JobTitle</p><% end_if %>
                                <% if $Affiliation %><p class="staff-tile__affiliation">$Affiliation</p><% end_if %>
                                <% if $Email %><p class="staff-tile__email"><a href="mailto:$Email">$Email</a></p><% end_if %>
                                <% if $Bio %><p class="staff-tile__bio">$Bio</p><% end_if %>
                            </div>
                        <% end_loop %>
                    </div>
                <% end_if %>
            </section>
        <% end_loop %>
    <% end_if %>
</div>
