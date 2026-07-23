<?php

namespace {

    use SilverStripe\Core\Extension;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\TextField;

    class RedirectorPageAnchorExtension extends Extension
    {
        private static $db = [
            'Anchor' => 'Varchar(255)',
        ];

        public function updateCMSFields(FieldList $fields)
        {
            $fields->insertAfter(
                'LinkToID',
                TextField::create('Anchor', 'Anchor')
                    ->setDescription('Optional. Jumps to an anchor on the target page, e.g. "section-id" (without the #). Only applies when redirecting to a page on your website.')
            );
        }

        public function updateRedirectionLink(&$link)
        {
            if ($link && $this->owner->RedirectionType == 'Internal' && $this->owner->Anchor) {
                $link .= '#' . ltrim($this->owner->Anchor, '#');
            }
        }
    }
}
