<?php
namespace Rutube\Models\Video;

use Rutube\Models\BaseObject;
use Rutube\Models\PgRating;
use Rutube\Models\Restrictions;
use Rutube\Models\Tag;

/**
 * Информация о загруженном видео
 *
 * @property string $id уникальный идентификатор видео (video_id)
 * @property string $title Название ролика
 * @property string $description Описание ролика
 * @property string $thumbnail_url Ссылка на тамбнейл видео
 * @property string $created_ts Дата и время создания ролика - "yyyy-mm-ddThh:mm:ss"
 * @property string $video_url Канонический URL страницы этого видео на Rutube
 * @property int $track_id Идентификатор трека на "старой платформе"
 * @property int $hits Просмотры ролика
 * @property int $duration Длительность ролика (мс)
 * @property string[] $hashtags
 * @property boolean $is_livestream
 * @property int $comments_count
 * @property string $last_update_ts Время последнего обновления видео - "yyyy-mm-ddThh:mm:ss"
 * @property string $short_description Краткое описание ролика
 * @property string $picture_url
 * @property VideoAuthor $author Информация об авторе ролика
 * @property boolean $is_adult Наличие контента, не подходящего для детей
 * @property PgRating $pg_rating
 * @property string $publication_ts Дата и время создания ролика - "yyyy-mm-ddThh:mm:ss"
 * @property VideoCategory $category Информация о категории ролика
 * @property boolean $is_official Принадлежность к официальному каналу
 * @property string $comment_editors html код плеера для вставки
 * @property string $embed_url Ссылка на контейнер с видео
 * @property string $html html код плеера для вставки
 * @property boolean $is_hidden Статус приватности ролика.
 * @property boolean $for_registered Ограничение просмотра видео - только для авторизованных пользователей
 * @property boolean $for_linked Ограничение просмотра видео - только для пользователей,
 * связавших аккаунт с социальной сетью
 * @property boolean $has_high_quality Наличие у ролика высокого качества
 * @property boolean $is_deleted Статус ролика - удален или доступен
 * @property string $source_url URL "старого" типа
 * @property boolean $is_external
 * @property int $rutube_poster
 * @property int $action_reason Причина недоступности ролика, значения -
 * см. справочник в http://rutube.ru/api/action_reason/
 * Если action_reason = 0 - с вашим видео все хорошо)
 * @property string $pepper
 * @property string $show Ссылка на информацию о шоу
 * @property string $persons Ссылка на информацию о персонах
 * @property string $genres Ссылка на информацию о жанрах
 * @property string $music Ссылка на музыку
 * @property Tag[] $all_tags
 * @property Restrictions $restrictions Запрет для показа в тех или иных странах
 * @property string $feed_url
 * @property string $feed_name
 * @property string $feed_subscription_url
 * @property string $feed_subscribers_count
 */
class VideoInfo extends BaseObject
{
    protected function init()
    {
        parent::init();

        if (!empty($this->attributes['author'])) {
            $this->attributes['author'] = new VideoAuthor($this->attributes['author']);
        }

        if (!empty($this->attributes['category'])) {
            $this->attributes['category'] = new VideoCategory($this->attributes['category']);
        }

        if (!empty($this->attributes['pg_rating'])) {
            $this->attributes['pg_rating'] = new PgRating($this->attributes['pg_rating']);
        }

        if (!empty($this->attributes['restrictions'])) {
            $this->attributes['restrictions'] = new Restrictions($this->attributes['restrictions']);
        }

        $tags = [];
        if (!empty($this->attributes['all_tags'])) {
            foreach ($this->attributes['all_tags'] as $tag) {
                $tags[] = new Tag($tag);
            }
        }

        $this->attributes['all_tags'] = $tags;
    }

    /**
     * Задает данные, которые должны быть сериализованы в JSON
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        $result = parent::jsonSerialize();

        if (count($result['all_tags']) === 0) {
            unset($result['all_tags']);
        }

        return $result;
    }
}
