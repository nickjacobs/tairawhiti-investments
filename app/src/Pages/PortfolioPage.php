<?php

namespace {

    use SilverStripe\Assets\Image;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\TextareaField;

    class PortfolioPage extends Page
    {
        private static $description = 'A single portfolio item, shown within a PortfolioHolder';

        private static $table_name = 'PortfolioPage';

        private static $cms_icon_class = 'font-icon-circle-star';

        private static $can_be_root = false;

        private static $allowed_children = 'none';

        private static $db = [
            'Summary' => 'Text',
        ];

        private static $has_one = [
            'Logo' => Image::class,
            'FeaturedImage' => Image::class,
        ];

        private static $owns = [
            'FeaturedImage','Logo'
        ];

        public function getCMSFields()
        {
            $this->beforeUpdateCMSFields(function (FieldList $fields) {
                $fields->addFieldToTab(
                    'Root.Main',
                    TextareaField::create('Summary', 'Summary')
                        ->setDescription('A short summary shown when this item is listed on the portfolio holder page'),
                    'Content'
                );

                $fields->addFieldsToTab(
                    'Root.Main',
                    [
                        UploadField::create('Logo', 'Logo')->setFolderName('Portfolio'),
                        UploadField::create('FeaturedImage', 'Featured image')->setFolderName('Portfolio')
                    ],
                    'Content'
                );
            });

            return parent::getCMSFields();
        }

        /**
         * Portfolio items render as a section on their parent PortfolioHolder, so links
         * to this page should jump to that section rather than to a standalone page.
         */
        public function Link($action = null)
        {
            $holder = $this->Parent();

            if ($holder && $holder->exists() && $holder instanceof PortfolioHolder) {
                return $holder->Link($action) . '#' . $this->URLSegment;
            }

            return parent::Link($action);
        }
    }
}
