<?php
namespace Rutube\Models;

/**
 * Class Restrictions
 *
 * @property CountryRestriction $country
 */
class Restrictions extends BaseObject
{
    protected function init()
    {
        parent::init();
        if (!empty($this->attributes['country'])) {
            $this->attributes['country'] = new CountryRestriction($this->attributes['country']);
        }
    }
}
