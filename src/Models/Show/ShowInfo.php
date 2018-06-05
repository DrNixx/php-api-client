<?php
namespace Rutube\Models\Show;

use Rutube\Models\Country;
use Rutube\Models\Genre;

/**
 * Информация о шоу
 * @property string $content Ссылка на api для получения списка видео, связанного с этим ТВ-шоу
 * @property ShowType $type Тип шоу
 * @property string $original_title Оригинальное название
 * @property Country[] $countries Страны
 * @property Genre[] $genres Жанры
 * @property integer $year
 * @property integer $year_start
 * @property integer $year_end
 * @property bool $isActive
 * @property string $related_showcase
 * @property string $age_restriction
 * @property string $slogan
 * @property string $poster_url
 * @property Studio[] $studios
 * @property string[] $external_ids
 * @property Person[] $persons
 * @property Age[] $age
 * @property string $persons_url
 * @property boolean $can_subscribe Является ли данное ТВ-шоу архивным или регулярно обновляемым
 * @property string $description Описание ТВ-шоу
 * @property string $picture Ссылка на основную заставку ТВ-шоу (может отсутствовать,если не задано)
 */
class ShowInfo extends ShowInfoBase
{
    protected function init()
    {
        parent::init();
        if (!empty($this->attributes['type'])) {
            $this->attributes['type'] = new ShowType($this->attributes['type']);
        }

        $countries = [];
        if (!empty($this->attributes['countries'])) {
            foreach ($this->attributes['countries'] as $country) {
                $countries[] = new Country($country);
            }
        }

        $this->attributes['countries'] = $countries;

        $genres = [];
        if (!empty($this->attributes['genres'])) {
            foreach ($this->attributes['genres'] as $genre) {
                $genres[] = new Genre($genre);
            }
        }

        $this->attributes['genres'] = $genres;
    }

    public function getIsActive()
    {
        return isset($this->attributes['isActive']) ? boolval($this->attributes['isActive']) : false;
    }

    public function setIsActive($value)
    {
        return $this->attributes['isActive'] = boolval($value) ? 1 : 0;
    }

    /**
     * Задает данные, которые должны быть сериализованы в JSON
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();

        if (count($result['countries']) === 0) {
            unset($result['countries']);
        }

        if (count($result['genres']) === 0) {
            unset($result['genres']);
        }

        return $result;
    }
}
