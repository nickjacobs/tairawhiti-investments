<?php

namespace {

    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\TextField;

    class Page extends SiteTree
    {
        private static $db = [
            'TeReoTitle' => 'Varchar'
        ];

        private static $has_one = [];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            $fields->addFieldToTab(
                'Root.Main',
                TextField::create('TeReoTitle', 'Te Reo Title'),
                'MenuTitle'
            );

            return $fields;
        }
    }
}
