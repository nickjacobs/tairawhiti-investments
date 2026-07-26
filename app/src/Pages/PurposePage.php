<?php

namespace {

    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

    class PurposePage extends Page
    {
        private static $description = 'Our purpose specific page';

        private static $table_name = 'PurposePage';

        private static $cms_icon_class = 'font-icon-flag';

        private static $db = [
            'PerformanceHighlights' => 'HTMLText',
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            $fields->addFieldToTab(
                'Root.Main',
                HTMLEditorField::create('PerformanceHighlights', 'Performance highlights')
                    ->setRows(8)
                    ->addExtraClass('stacked'),
                'Metadata'
            );

            return $fields;
        }
    }
}
