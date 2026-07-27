<?php

use SilverStripe\Security\PermissionProvider;

class BasicAuthPermissions implements PermissionProvider
{
    public function providePermissions()
    {
        return [
            'SITE_BASIC_AUTH_VIEWER' => [
                'name' => 'Access site while basic auth protected',
                'category' => 'Roles and access permissions',
                'help' => 'Lets a member pass the site-wide HTTP basic auth prompt (SS_USE_BASIC_AUTH) without needing full CMS admin access.',
            ],
        ];
    }
}
