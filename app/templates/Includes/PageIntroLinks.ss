<% if $LearnMoreLink %>
        <div class="page-intro__learnmore">
            <% with $LearnMoreLink %>
                <a href="$URL" class="page-intro__link" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
                    $Title
                    <span class="page-intro__link-arrow" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 512 512"><path d="m506.134 241.843-.018-.019-104.504-104c-7.829-7.791-20.492-7.762-28.285.068s-7.762 20.492.067 28.284L443.558 236H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h423.557l-70.162 69.824c-7.829 7.792-7.859 20.455-.067 28.284 7.793 7.831 20.457 7.858 28.285.068l104.504-104 .018-.019c7.833-7.818 7.808-20.522-.001-28.314"/></svg>
                    </span>
                </a>
            <% end_with %>
        </div>
<% end_if %>

<% if $OurStoryVideo %>
    <div class="page-intro__video">
        <button type="button" class="video-trigger" data-bs-toggle="modal" data-bs-target="#our-story-video-modal">
            <span class="video-trigger__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M8 5v14l11-7z"/></svg>
            </span>
            Watch our story
        </button>
    </div>

    <div class="modal fade video-modal" id="our-story-video-modal" tabindex="-1" aria-labelledby="our-story-video-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h2 id="our-story-video-modal-label" class="visually-hidden">Our story</h2>
                    <% if $OurStoryVideoCloudflareStreamURL %>
                        <video class="video-modal__player" preload="auto" controls playsinline data-hls-src="$OurStoryVideoCloudflareStreamURL"></video>
                    <% else %>
                        <video class="video-modal__player" controls playsinline>
                            <source src="$OurStoryVideo.URL" type="$OurStoryVideo.MimeType">
                        </video>
                    <% end_if %>
                </div>
            </div>
        </div>
    </div>
<% end_if %>
