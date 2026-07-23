<?php

namespace {

    class StaffPage extends Page
    {
        private static $description = 'A page listing staff, grouped into staff blocks';

        private static $table_name = 'StaffPage';

        private static $cms_icon_class = 'font-icon-torsos-all';

        private static $has_many = [
            'StaffBlocks' => StaffBlock::class,
        ];
    }
}
