<?php

namespace {

    class PortfolioHolder extends Page
    {
        private static $description = 'Displays a list of portfolio pages';

        private static $table_name = 'PortfolioHolder';

        private static $cms_icon_class = 'font-icon-p-package';

        private static $allowed_children = [
            PortfolioPage::class,
        ];
    }
}
