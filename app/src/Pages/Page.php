<?php

namespace {

    use Psr\Log\LoggerInterface;
    use SilverStripe\Assets\File;
    use SilverStripe\Assets\Image;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Core\Environment;
    use SilverStripe\Core\Injector\Injector;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\DataObject;

    class Page extends SiteTree
    {
        private static $db = [
            'TeReoTitle' => 'Varchar',
            'BannerTitle' => 'Varchar(255)',
            'BannerTeReoTitle' => 'Varchar(255)',
            'BannerCloudflareVideoID' => 'Varchar(32)',
            'PageIntro' => 'HTMLText'
        ];

        private static $has_one = [
            'BannerImage' => Image::class,
            'BannerVideo' => File::class,
        ];

        private static $owns = [
            'BannerImage',
            'BannerVideo',
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            $fields->removeByName(['BannerImageID', 'BannerVideoID']);

            $fields->addFieldToTab(
                'Root.Main',
                TextField::create('TeReoTitle', 'Te Reo name'),
                'MenuTitle'
            );

            $fields->addFieldToTab('Root.Main',
            HTMLEditorField::create('PageIntro')->setRows(4),
                'Content'
            );

            $fields->addFieldsToTab('Root.Banner', [
                TextField::create('BannerTitle', 'Banner title')
                    ->setDescription('If left blank, the page title will be used'),
                TextField::create('BannerTeReoTitle', 'Banner Te Reo title')
                    ->setDescription('If left blank, the page\'s Te Reo name will be used'),
                UploadField::create('BannerImage', 'Banner background image')->setFolderName('Banners'),
                UploadField::create('BannerVideo', 'Banner background video')
                    ->setFolderName('Banners')
                    ->setAllowedFileCategories('video')
                    ->setDescription('Optional. If set, this plays instead of the background image.'),
                TextField::create('BannerCloudflareVideoID', 'Banner Cloudflare Stream video ID')
                    ->setDescription(
                        'Filled in automatically when you upload a background video above and save - it gets '
                        . 'pushed to Cloudflare Stream for adaptive bitrate playback. You can also paste in a '
                        . 'video ID directly if it\'s already on Stream. Takes priority over the background '
                        . 'video above.'
                    ),
            ]);

            return $fields;
        }

        /**
         * The banner title to display, falling back to the page title. Deliberately
         * not named getBannerTitle() - that would shadow the BannerTitle db field on
         * magic property access, which the CMS form uses to populate the field's
         * value. That would pre-fill the (blank) field with the fallback whenever
         * the form loads, and saving without touching it would write that fallback
         * in permanently instead of leaving it blank.
         */
        public function getBannerTitleForDisplay()
        {
            return $this->getField('BannerTitle') ?: $this->Title;
        }

        /**
         * The HLS manifest URL for the banner's Cloudflare Stream video, or null
         * if no video ID is set or CLOUDFLARE_STREAM_CUSTOMER_CODE isn't set in .env.
         */
        public function getBannerCloudflareStreamURL()
        {
            return $this->getCloudflareStreamURL('BannerCloudflareVideoID');
        }

        /**
         * The HLS manifest URL for a Cloudflare Stream video ID stored in $videoIDField,
         * or null if that field is empty or CLOUDFLARE_STREAM_CUSTOMER_CODE isn't set in .env.
         */
        protected function getCloudflareStreamURL(string $videoIDField)
        {
            $videoID = $this->getField($videoIDField);
            $customerCode = Environment::getEnv('CLOUDFLARE_STREAM_CUSTOMER_CODE');

            if (!$videoID || !$customerCode) {
                return null;
            }

            // Accept the code with or without its "customer-" prefix, since
            // that's easy to grab either way when copying it from Cloudflare.
            $customerCode = preg_replace('/^customer-/', '', $customerCode);

            return sprintf(
                'https://customer-%s.cloudflarestream.com/%s/manifest/video.m3u8',
                $customerCode,
                $videoID
            );
        }

        /**
         * Whenever a new BannerVideo is uploaded and saved, push it to Cloudflare
         * Stream so it plays back with adaptive bitrate. Runs before the write so
         * the resulting video ID is saved in the same request - no extra write.
         */
        protected function onBeforeWrite()
        {
            parent::onBeforeWrite();

            $this->pushVideoToCloudflareStream('BannerVideo', 'BannerCloudflareVideoID');
        }

        /**
         * If the has_one File relation named $videoRelation has changed to point at
         * a new file, push it to Cloudflare Stream and store the resulting video ID
         * in $cloudflareIDField. Safe to call from onBeforeWrite() for any number of
         * video relations on a page.
         */
        protected function pushVideoToCloudflareStream(string $videoRelation, string $cloudflareIDField)
        {
            if (!$this->isChanged("{$videoRelation}ID", DataObject::CHANGE_VALUE)) {
                return;
            }

            $video = $this->{$videoRelation}();

            if (!$video || !$video->exists()) {
                $this->{$cloudflareIDField} = '';
                return;
            }

            try {
                $this->{$cloudflareIDField} = CloudflareStreamService::create()->upload(
                    $video->getStream(),
                    $video->Name
                );
            } catch (Throwable $e) {
                Injector::inst()->get(LoggerInterface::class)->error(
                    "Cloudflare Stream upload failed for {$this->ClassName} #{$this->ID} "
                    . "({$videoRelation}): {$e->getMessage()}"
                );
            }
        }
    }
}
