<?php

namespace {

    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\ORM\DataObject;

    class StaffBlock extends DataObject
    {
        private static $table_name = 'StaffBlock';

        private static $db = [
            'Title' => 'Varchar(255)',
        ];

        private static $has_one = [
            'StaffPage' => StaffPage::class,
        ];

        private static $has_many = [
            'Staff' => Staff::class,
        ];

        private static $summary_fields = [
            'Title' => 'Title',
            'Staff.Count' => 'Staff members',
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();

            $fields->removeByName(['StaffPageID', 'Staff']);

            $fields->insertAfter(
                'Title',
                GridField::create(
                    'Staff',
                    'Staff',
                    $this->Staff(),
                    GridFieldConfig_RecordEditor::create()
                )
            );

            return $fields;
        }
    }
}
