<?php

namespace Innoweb\CMSStickyMenu\Model;

use SilverStripe\Core\Extension;
use SilverStripe\Core\Config\Config;
use SilverStripe\Security\Security;
use SilverStripe\Control\Cookie;

class CMSMenuPreference extends Extension {

    public function init()
    {
        $mode = Config::inst()->get(UserMenuPreference::class, 'DefaultMode');
        $userMode = Security::getCurrentUser()->DefaultMenuMode;

        if (!empty($userMode)) {
            $mode = $userMode;
        }

        if ($mode == 'default') {
            Cookie::force_expiry('cms-menu-sticky', null, null, false, false);
            Cookie::force_expiry('cms-panel-collapsed-cms-menu', null, null, false, false);
        } else {
            Cookie::set('cms-menu-sticky', 'true', 90, null, null, false, false);
            if ($mode == 'open') {
                Cookie::set('cms-panel-collapsed-cms-menu', 'false', 90, null, null, false, false);
            } else {
                Cookie::set('cms-panel-collapsed-cms-menu', 'true', 90, null, null, false, false);
            }
        }
    }
}