<?php

namespace {

    use Bummzack\SortableFile\Forms\SortableUploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\Forms\TextareaField;
    use SilverStripe\LinkField\Form\LinkField;
    use SilverStripe\LinkField\Models\Link;

    class PortfolioPage extends Page
    {
        private static $description = 'A single portfolio item, shown within a PortfolioHolder';

        private static $table_name = 'PortfolioPage';

        private static $cms_icon_class = 'font-icon-circle-star';

        private static $can_be_root = false;

        private static $allowed_children = 'none';

        private static $db = [
            'Performance' => 'HTMLText'
        ];

        private static $has_one = [
            'Logo' => Image::class,
            'FindOutMoreLink' => Link::class,
        ];

        private static $many_many = [
            'FeaturedImages' => Image::class,
        ];

        private static $many_many_extraFields = [
            'FeaturedImages' => ['SortOrder' => 'Int'],
        ];

        private static $owns = [
            'Logo',
            'FeaturedImages',
            'FindOutMoreLink',
        ];

        private static $cascade_deletes = [
            'FindOutMoreLink',
        ];

        private static $cascade_duplicates = [
            'FindOutMoreLink',
        ];

        public function getCMSFields()
        {
            $this->beforeUpdateCMSFields(function (FieldList $fields) {

                $fields->addFieldsToTab(
                    'Root.Main',
                    [
                        UploadField::create('Logo', 'Logo')->setFolderName('Portfolio'),
                        SortableUploadField::create('FeaturedImages', 'Featured images')->setFolderName('Portfolio'),
                        LinkField::create('FindOutMoreLink', 'Find out more link'),
                    ],
                    'Content'
                );

                $fields->addFieldToTab('Root.Main',HTMLEditorField::create('Performance', 'Performance')->setRows(8)->addExtraClass('stacked'),'Metadata');
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
