$Content

<% if $StaffBlocks %>
    <% loop $StaffBlocks %>
        <section class="staff-block">
            <h2>$Title</h2>

            <% if $Staff %>
                <div class="staff-tiles">
                    <% loop $Staff %>
                        <div class="staff-tile">
                            <% if $Photo %>
                                <div class="staff-tile__photo">
                                    $Photo.Fill(300,300)
                                </div>
                            <% end_if %>
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
