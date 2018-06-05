<?php
namespace Rutube\Models\Show;

use Rutube\Models\BaseObject;
use Rutube\Models\PgRating;
use Rutube\Models\Video\VideoType;

/**
 * Class VideoRelation
 *
 * @property ShowInfoBase $tv
 * @property int $year год выхода серии (не год выхода сериала)
 * @property string $video_id идентификатор видео, к которому привязываем метаинформацию
 * @property int $season номер сезона
 * @property int $episode номер серии в сезоне
 * @property string $show_page
 * @property VideoType $type тип видео
 * @property string $release дата выпуска серии, по умолчанию приравнивается дате создания связанного видео
 * @property int $track_id
 * @property string $ext_id идентификатор в базе правообладателя
 * @property int $fragment номер фрагмента в серии (например, если серия разделена на скетчи)
 * @property int $episode_global сквозной номер эпизода
 * @property int $season_agreement номер сезона по договору
 * @property int $episode_agreement номер эпизода по договору
 * @property string $name_agreement название по договору
 * @property string $vc_version номер версии для TNS
 * @property int $fts смещение в секундах (для нарезок)
 * @property string $last_update_ts
 * @property PgRating[] $age возрастные ограничения
 * @property string $asset_id asset_id для экспорта на ютуб
 */
class VideoRelation extends BaseObject
{
    protected $attributeNames = [
        'tv',
        'year',
        'video_id',
        'season',
        'episode',
        'show_page',
        'type',
        'release',
        'track_id',
        'ext_id',
        'fragment',
        'episode_global',
        'season_agreement',
        'episode_agreement',
        'name_agreement',
        'vc_version',
        'fts',
        'last_update_ts',
        'age',
        'asset_id',
    ];

    protected function init()
    {
        parent::init();
        if (!empty($this->attributes['type'])) {
            $this->attributes['type'] = new VideoType($this->attributes['type']);
        }

        $ages = [];
        if (!empty($this->attributes['age'])) {
            foreach ($this->attributes['age'] as $age) {
                $ages[] = new PgRating($age);
            }
        }

        $this->attributes['age'] = $ages;
    }

    /**
     * Задает данные, которые должны быть сериализованы в JSON
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();

        if (count($result['age']) === 0) {
            unset($result['age']);
        }

        return $result;
    }
}
