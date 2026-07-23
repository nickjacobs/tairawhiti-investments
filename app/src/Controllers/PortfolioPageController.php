<?php

namespace {

    use SilverStripe\Control\HTTPRequest;

    /**
     * @template T of PortfolioPage
     * @extends PageController<T>
     */
    class PortfolioPageController extends PageController
    {
        private static $allowed_actions = ['index'];

        /**
         * Portfolio items don't have a standalone page - send visitors who land on
         * this page's own URL to the matching section on the parent holder instead.
         */
        public function index(HTTPRequest $request)
        {
            $page = $this->data();

            if (!$this->getResponse()->isFinished() && $page->Parent() instanceof PortfolioHolder) {
                return $this->redirect($page->Link(), 301);
            }

            return parent::handleAction($request, 'handleIndex');
        }
    }
}
