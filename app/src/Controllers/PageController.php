<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\Control\Middleware\HTTPCacheControlMiddleware;
    use SilverStripe\Security\Security;

    /**
     * @template T of Page
     * @extends ContentController<T>
     */
    class PageController extends ContentController
    {
        /**
         * An array of actions that can be accessed via a request. Each array element should be an action name, and the
         * permissions or conditions required to allow the user to access it.
         *
         * <code>
         * [
         *     'action', // anyone can access this action
         *     'action' => true, // same as above
         *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
         *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
         * ];
         * </code>
         *
         * @var array
         */
        private static $allowed_actions = [];

        /**
         * How long (in seconds) anonymous GET responses can be cached for by
         * shared caches (CDN, reverse proxy) and browsers. Overridden to
         * disableCache() on controllers whose pages contain a session-tied
         * form (see ContactPageController) - caching those would serve one
         * visitor's CSRF token to everyone else.
         *
         * @var int
         */
        private static $cache_max_age = 300;

        protected function init()
        {
            parent::init();
            // You can include any CSS or JS required by your project here.
            // See: https://docs.silverstripe.org/en/developer_guides/templates/requirements/

            if ($this->getRequest()->isGET() && !Security::getCurrentUser()) {
                // Unforced - the framework's own dev-environment config
                // (see vendor/silverstripe/framework/_config/config.yml)
                // forces caching off in dev at a higher level than this, so
                // this only actually takes effect in test/live.
                HTTPCacheControlMiddleware::singleton()->publicCache(
                    false,
                    $this->config()->get('cache_max_age')
                );
            }
        }
    }
}
