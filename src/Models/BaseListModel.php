<?php
namespace Rutube\Models;

/**
 * Class BaseListModel
 * @property-read bool $hasNext
 * @property-read string $next => https://rutube.ru/api/tags/?limit=20&page=2
 * @property-read string $previous
 * @property integer $page
 * @property integer $per_page
 * @property-read array $results
 */
class BaseListModel extends BaseObject
{
    protected function getItemClass()
    {
        return BaseObject::className();
    }

    /**
     * @throws \ReflectionException
     */
    protected function init()
    {
        parent::init();

        if (!isset($this->attributes['results'])) {
            $this->attributes['results'] = [];
        }

        $reflection = new \ReflectionClass($this->getItemClass());
        $results = [];
        foreach ($this->attributes['results'] as $result) {
            $results[] = $reflection->newInstance($result);
        }

        $this->attributes['results'] = $results;
    }

    public function getHasNext()
    {
        return isset($this->attributes['has_next']) ? boolval($this->attributes['has_next']) : false;
    }

    public function setHasNext($value)
    {
        return $this->attributes['has_next'] = boolval($value) ? 1 : 0;
    }
}
