<?php
class UserMenuPreference extends DataExtension {
	
    private static $db=array(
		'DefaultMenuMode' => "Enum(array('open', 'closed', 'default'), 'default')"
	);
    
    private static $defaults=array(
		'DefaultMenuMode' => 'default'
	);
	
    private $isSaving=false;
    
    
    /**
     * Updates the fields used in the cms
     * @param {FieldList} $fields Fields to be extended
     */
    public function updateCMSFields(FieldList $fields) {
        
        $fields->addFieldToTab(
			'Root.Main', 
			$field = OptionsetField::create(
				'DefaultMenuMode',
				_t('UserMenuPreference.MENU_MODE', '_Default Menu Mode'), 
				array(
					'open'=>_t('UserMenuPreference.OPEN_MODE', '_Open Mode: Menu is open and the sticky box is ticked'),
					'closed'=>_t('UserMenuPreference.CLOSED_MODE', '_Closed Mode: Menu is closed and the sticky box is ticked'),
					'preview'=>_t('UserMenuPreference.DEFAULT_MODE', '_Default Mode: Showing the menu is left to the CMS default behaviour')
				),
				Config::inst()->get('UserMenuPreference', 'DefaultMode')
			)
		);
        
        if(Session::get('ShowMenuSettingChangeReload')==true) {
            $field->setError(_t('UserMenuPreference.CHANGE_REFRESH', '_You have updated your menu preference, you must refresh your browser to see the updated setting'), 'warning');

            if($this->isSaving==false) {
                Session::clear('ShowMenuSettingChangeReload');
            }
        }
    }
    
    /**
     * Ensures config defaults are enforced on write
     */ 
    public function onBeforeWrite() {
        parent::onBeforeWrite();
        
        if(empty($this->owner->DefaultMenuMode)) {
            $this->owner->DefaultMenuMode = Config::inst()->get('UserMenuPreference', 'DefaultMode');
        }
                
        //If changed ensure their is a session message
        if($this->owner->isChanged('DefaultMenuMode')) {
            Session::set('ShowMenuSettingChangeReload', true);
            $this->isSaving=true;
        }
    }
}
