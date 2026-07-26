<?php


use SilverStripe\Admin\CMSMenu;
use SilverStripe\Admin\SecurityAdmin;
use SilverStripe\CampaignAdmin\CampaignAdmin;
use SilverStripe\Reports\ReportAdmin;
use SilverStripe\VersionedAdmin\ArchiveAdmin;

CMSMenu::remove_menu_class(CampaignAdmin::class);
CMSMenu::remove_menu_class(ReportAdmin::class);
//CMSMenu::remove_menu_class(SecurityAdmin::class);
//CMSMenu::remove_menu_class(ArchiveAdmin::class);
