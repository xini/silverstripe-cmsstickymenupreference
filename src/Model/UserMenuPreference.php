<?php

namespace Innoweb\CMSStickyMenu\Model;

use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\OptionsetField;

class UserMenuPreference extends Extension
{

    private static $db = [
        'DefaultMenuMode'   =>  "Enum(array('open', 'closed', 'default'), 'default')"
    ];

    private static $defaults = [
        'DefaultMenuMode'   =>  'default'
    ];

    protected $isSaving = false;

    /**
     * Updates the fields used in the cms
     * @param {FieldList} $fields Fields to be extended
     */
    public function updateCMSFields(FieldList $fields)
    {

        $fields->addFieldToTab(
            'Root.Main',
            $field = OptionsetField::create(
                'DefaultMenuMode',
                _t('Innoweb\\CMSStickyMenu\\Model\\UserMenuPreference.MENU_MODE', '_Default Menu Mode'),
                [
                    'open'      =>  _t(
                        'Innoweb\\CMSStickyMenu\\Model\\UserMenuPreference.OPEN_MODE',
                        '_Open Mode: Menu is open and the sticky box is ticked'
                    ),
                    'closed'    =>  _t(
                        'Innoweb\\CMSStickyMenu\\Model\\UserMenuPreference.CLOSED_MODE',
                        '_Closed Mode: Menu is closed and the sticky box is ticked'
                    ),
                    'default'   =>  _t(
                        'Innoweb\\CMSStickyMenu\\Model\\UserMenuPreference.DEFAULT_MODE',
                        '_Default Mode: Showing the menu is left to the CMS default behaviour'
                    )
                ],
                Config::inst()->get(UserMenuPreference::class, 'DefaultMode')
            )
        );

        $controller = Controller::curr();
        $session = $controller->getRequest()->getSession();

        if ($session->get('ShowMenuSettingChangeReload') == true) {
            $field->setMessage(
                _t(
                    'Innoweb\\CMSStickyMenu\\Model\\UserMenuPreference.CHANGE_REFRESH',
                    '_You have updated your menu preference, you must refresh your browser to see the updated setting'
                ),
                'warning'
            );

            if ($this->isSaving == false) {
                $session->clear('ShowMenuSettingChangeReload');
            }
        }
    }

    /**
     * Ensures config defaults are enforced on write
     */
    public function onBeforeWrite()
    {
        if (empty($this->getOwner()->DefaultMenuMode)) {
            $this->getOwner()->DefaultMenuMode = Config::inst()->get(UserMenuPreference::class, 'DefaultMode');
        }

        // If changed ensure their is a session message
        if ($this->getOwner()->isChanged('DefaultMenuMode')) {
            $controller = Controller::curr();
            $session = $controller->getRequest()->getSession();
            $session->set('ShowMenuSettingChangeReload', true);
            $this->isSaving = true;
        }
    }
}
