<?php

namespace {

    use SilverStripe\Assets\File;
    use SilverStripe\Assets\Image;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Forms\HeaderField;
    use SilverStripe\Forms\TextField;

    class AboutPage extends Page
    {
        private static $description = 'A page about TIL';

        private static $table_name = 'AboutPage';

        private static $cms_icon_class = 'font-icon-book-open';

        private static $db = [
            'AboutVideoCloudflareID' => 'Varchar(32)',
        ];

        private static $has_one = [
            'AboutVideo' => File::class,
            'Tile1Image' => Image::class,
            'Tile2Image' => Image::class,
            'Tile3Image' => Image::class,
        ];

        private static $owns = [
            'AboutVideo',
            'Tile1Image',
            'Tile2Image',
            'Tile3Image',
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            $fields->removeByName([
                'AboutVideoID',
                'AboutVideoCloudflareID',
                'Tile1ImageID',
                'Tile2ImageID',
                'Tile3ImageID',
            ]);

            $fields->addFieldsToTab('Root.Main', [
                UploadField::create('AboutVideo', 'Video')
                    ->setAllowedFileCategories('video'),
                TextField::create('AboutVideoCloudflareID', 'Video Cloudflare Stream video ID')
                    ->setDescription(
                        'Filled in automatically when you upload a video above and save - it gets pushed to '
                        . 'Cloudflare Stream for adaptive bitrate playback. You can also paste in a video ID '
                        . 'directly if it\'s already on Stream.'
                    ),
            ], 'Content');

            $fields->addFieldsToTab('Root.Tiles', [
                HeaderField::create('Tile1Header', 'Tile 1'),
                UploadField::create('Tile1Image', 'Image')->setFolderName('Tiles'),
                HeaderField::create('Tile2Header', 'Tile 2'),
                UploadField::create('Tile2Image', 'Image')->setFolderName('Tiles'),
                HeaderField::create('Tile3Header', 'Tile 3'),
                UploadField::create('Tile3Image', 'Image')->setFolderName('Tiles'),
            ]);

            return $fields;
        }

        public function getAboutVideoCloudflareStreamURL()
        {
            return $this->getCloudflareStreamURL('AboutVideoCloudflareID');
        }

        protected function onBeforeWrite()
        {
            parent::onBeforeWrite();

            $this->pushVideoToCloudflareStream('AboutVideo', 'AboutVideoCloudflareID');
        }
    }
}
