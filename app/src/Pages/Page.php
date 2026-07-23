<?php

namespace {

    use SilverStripe\Assets\Image;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\TextField;

    class Page extends SiteTree
    {
        private static $db = [
            'TeReoTitle' => 'Varchar',
            'BannerTitle' => 'Varchar(255)',
            'BannerTeReoTitle' => 'Varchar(255)',
        ];

        private static $has_one = [
            'BannerImage' => Image::class,
        ];

        private static $owns = [
            'BannerImage',
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            $fields->removeByName('BannerImageID');

            $fields->addFieldToTab(
                'Root.Main',
                TextField::create('TeReoTitle', 'Te Reo name'),
                'MenuTitle'
            );

            $fields->addFieldsToTab('Root.Banner', [
                TextField::create('BannerTitle', 'Banner title')
                    ->setDescription('If left blank, the page title will be used'),
                TextField::create('BannerTeReoTitle', 'Banner Te Reo title')
                    ->setDescription('If left blank, the page\'s Te Reo name will be used'),
                UploadField::create('BannerImage', 'Banner background image')->setFolderName('Banners'),
            ]);

            return $fields;
        }

        public function getBannerTitle()
        {
            return $this->getField('BannerTitle') ?: $this->Title;
        }

        public function getBannerTeReoTitle()
        {
            return $this->getField('BannerTeReoTitle') ?: $this->TeReoTitle;
        }
    }
}
