<?php

namespace Innoweb\CMSStickyMenu\Model;

use SilverStripe\Control\Cookie;
use SilverStripe\Control\Director;
use SilverStripe\Control\Session;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Security;

class CMSMenuPreference extends Extension
{
    public function onInit()
    {
        $mode = Config::inst()->get(UserMenuPreference::class, 'DefaultMode');
        $userMode = Security::getCurrentUser()->DefaultMenuMode;

        if (!empty($userMode)) {
            $mode = $userMode;
        }

        $secure = Director::is_https() && Session::config()->get('cookie_secure');
        if ($mode == 'default') {
            Cookie::force_expiry('cms-menu-sticky', null, null, $secure, false);
            Cookie::force_expiry('cms-panel-collapsed-cms-menu', null, null, $secure, false);
        } else {
            Cookie::set('cms-menu-sticky', 'true', 90, null, null, $secure, false);
            if ($mode == 'open') {
                Cookie::set('cms-panel-collapsed-cms-menu', 'false', 90, null, null, $secure, false);
            } else {
                Cookie::set('cms-panel-collapsed-cms-menu', 'true', 90, null, null, $secure, false);
            }
        }
    }
}
