<?php

namespace {

    /**
     * @template T of PortfolioHolder
     * @extends PageController<T>
     */
    class PortfolioHolderController extends PageController
    {
        private static $allowed_actions = [];

        public function PortfolioItems()
        {
            return $this->Children();
        }
    }
}
