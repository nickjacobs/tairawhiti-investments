<?php

namespace {

    use SilverStripe\Assets\File;
    use SilverStripe\Assets\Image;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Forms\HeaderField;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\LinkField\Form\LinkField;
    use SilverStripe\LinkField\Models\Link;

    class HomePage extends Page
    {
        private static $description = 'Home page';

        private static $table_name = 'HomePage';

        private static $cms_icon_class = 'font-icon-home';

        private static $db = [
            'OurStoryVideoCloudflareID' => 'Varchar(32)',
            'TilesContent' => 'HTMLText'
        ];

        private static $has_one = [
            'LearnMoreLink' => Link::class,
            'OurStoryVideo' => File::class,
            'TilesHeaderLink' => Link::class,
            'Tile1Image' => Image::class,
            'Tile1Link' => Link::class,
            'Tile2Image' => Image::class,
            'Tile2Link' => Link::class,
            'Tile3Image' => Image::class,
            'Tile3Link' => Link::class,

        ];

        private static $owns = [
            'LearnMoreLink',
            'OurStoryVideo',
            'Tile1Image',
            'Tile1Link',
            'Tile2Image',
            'Tile2Link',
            'Tile3Image',
            'Tile3Link',
            'TilesHeaderLink'
        ];

        private static $cascade_deletes = [
            'LearnMoreLink',
            'Tile1Link',
            'Tile2Link',
            'Tile3Link',
            'TilesHeaderLink'
        ];

        private static $cascade_duplicates = [
            'LearnMoreLink',
            'Tile1Link',
            'Tile2Link',
            'Tile3Link',
            'TilesHeaderLink'
        ];

//        private static $allowed_children = [//
//        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            $fields->removeByName([
                'OurStoryVideoID',
                'Tile1ImageID',
                'Tile2ImageID',
                'Tile3ImageID',
                'TilesHeaderLinkID',
                'Content',
                'OurStoryVideoCloudflareID',
                'LearnMoreLink',
                'OurStoryVideo'
            ]);

            $fields->addFieldsToTab('Root.Main', [
                LinkField::create('LearnMoreLink', 'Learn more link'),
                UploadField::create('OurStoryVideo', 'Our story video')
                    ->setAllowedFileCategories('video'),
                TextField::create('OurStoryVideoCloudflareID', 'Our story video Cloudflare Stream video ID')
                    ->setDescription(
                        'Filled in automatically when you upload a video above and save - it gets pushed to '
                        . 'Cloudflare Stream for adaptive bitrate playback. You can also paste in a video ID '
                        . 'directly if it\'s already on Stream.'
                    ),
            ],'Metadata');

            $fields->addFieldsToTab('Root.Tiles', [
                HeaderField::create('TilesHeader', 'Tiles Intro'),
                HTMLEditorField::create('TilesContent')->setRows(8),
                LinkField::create('TilesHeaderLink', 'Tiles intro link'),
                HeaderField::create('Tile1Header', 'Tile 1'),
                UploadField::create('Tile1Image', 'Image')->setFolderName('Tiles'),
                LinkField::create('Tile1Link', 'Link'),
                HeaderField::create('Tile2Header', 'Tile 2'),
                UploadField::create('Tile2Image', 'Image')->setFolderName('Tiles'),
                LinkField::create('Tile2Link', 'Link'),
                HeaderField::create('Tile3Header', 'Tile 3'),
                UploadField::create('Tile3Image', 'Image')->setFolderName('Tiles'),
                LinkField::create('Tile3Link', 'Link'),
            ]);

            return $fields;
        }

        public function getOurStoryVideoCloudflareStreamURL()
        {
            return $this->getCloudflareStreamURL('OurStoryVideoCloudflareID');
        }

        protected function onBeforeWrite()
        {
            parent::onBeforeWrite();

            $this->pushVideoToCloudflareStream('OurStoryVideo', 'OurStoryVideoCloudflareID');
        }
    }
}
