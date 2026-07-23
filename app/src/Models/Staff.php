<?php

namespace {

    use SilverStripe\Assets\Image;
    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Forms\EmailField;
    use SilverStripe\ORM\DataObject;

    class Staff extends DataObject
    {
        private static $table_name = 'Staff';

        private static $db = [
            'Name' => 'Varchar(255)',
            'JobTitle' => 'Varchar(255)',
            'Affiliation' => 'Varchar(255)',
            'Email' => 'Varchar(255)',
            'Bio' => 'Text',
        ];

        private static $has_one = [
            'StaffBlock' => StaffBlock::class,
            'Photo' => Image::class,
        ];

        private static $owns = [
            'Photo',
        ];

        private static $summary_fields = [
            'Photo.CMSThumbnail' => 'Photo',
            'Name' => 'Name',
            'JobTitle' => 'Job title',
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            $fields->removeByName(['StaffBlockID', 'PhotoID']);
            $fields->insertBefore('Name', UploadField::create('Photo', 'Photo'));
            $fields->replaceField('Email', EmailField::create('Email', 'Email'));

            return $fields;
        }
    }
}
