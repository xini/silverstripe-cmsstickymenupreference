<?php

namespace Innoweb\CMSStickyMenu\Model;

use SilverStripe\Control\Cookie;
use SilverStripe\Control\Session;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Extension;
use SilverStripe\Security\Security;

class CMSMenuPreference extends Extension {

    public function init()
    {
        $mode = Config::inst()->get(UserMenuPreference::class, 'DefaultMode');
        $userMode = Security::getCurrentUser()->DefaultMenuMode;

        if (!empty($userMode)) {
            $mode = $userMode;
        }

        if ($mode == 'default') {
            Cookie::force_expiry('cms-menu-sticky', null, null, Session::config()->get('cookie_secure'), false);
            Cookie::force_expiry('cms-panel-collapsed-cms-menu', null, null, Session::config()->get('cookie_secure'), false);
        } else {
            Cookie::set('cms-menu-sticky', 'true', 90, null, null, Session::config()->get('cookie_secure'), false);
            if ($mode == 'open') {
                Cookie::set('cms-panel-collapsed-cms-menu', 'false', 90, null, null, Session::config()->get('cookie_secure'), false);
            } else {
                Cookie::set('cms-panel-collapsed-cms-menu', 'true', 90, null, null, Session::config()->get('cookie_secure'), false);
            }
        }
    }
}
