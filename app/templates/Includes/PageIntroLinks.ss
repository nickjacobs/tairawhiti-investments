<% if $LearnMoreLink %>
    <% with $LearnMoreLink %>
        <a href="$URL" class="pill-link" <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>>
            $Title
        </a>
    <% end_with %>
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
