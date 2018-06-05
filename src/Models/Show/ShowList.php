<?php
namespace Rutube\Models\Show;

use Rutube\Models\BaseListModel;

/**
 * Список шоу
 * @property-read ShowInfo[] $results
 */
class ShowList extends BaseListModel
{
    protected function getItemClass()
    {
        return ShowInfo::className();
    }
}
