<?php
/*
 * This file is part of the Rutube PHP API Client package.
 *
 * (c) Rutube & Friday
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Rutube;

use InvalidArgumentException;
use Rutube\Models\Show\VideoRelation;
use Rutube\Models\Video\PublicationResponse;
use Rutube\Models\Video\VideoInfo;

/**
 * Работа с видео
 *
 * @package Rutube
 */
class Video extends Entity
{
    /**
     * Загрузка видео
     *
     * @autorization требуется
     *
     * @param string|array $url URL по которому находится скачиваемый ролик. Обратите внимание, что ролик должен быть
     * доступен для загрузки сервисам Rutube, добавьте, если это необходимо, элементы авторизации в ссылку
     * @param string $title Название ролика, до 100 символов
     * @param string $description Описание
     * @param boolean $is_hidden Признак видимости, 1 - ролик скрыт
     * @param int $category_id ID категории
     * @param string|null $callback_url callbacl-URL по завершению обработки ролика
     * @param string|null $errback_url URL, вызываемый для сообщения об ошибке
     * @param string|null $query_fields Поля, которые должны быть переданы в callback_url.
     * Задаются в виде json-массива. Пример: query_fields=["id", "description"]. Если не указано - будут переданы все.
     * @param string|null $extra Поля, которые как есть будут добавляться к ответу, приходящему на
     * callback_url или errback_url. Задаются в виде json строки. В callback или errback все поля,
     * переданные в extra, будут находится в поле "session"
     * @param boolean|null $quality_report Если задано, то уведомление на callback будет приходить по готовности
     * каждого качества, а не единожды по доступности видео.
     * @param string|null $converter_params Может содержать дополнительные параметры конвертации, например, xml-разметку:
     * converter_params=%7B%22editor_xml%22%3A%22ftp%3A%5C%2F%5C%2Frutube%3pass%4010.50.222%5C%2FPR291117-A.xml%22%7D
     * @param int|null $author id канала в который заливается контент. Обратите внимание, что канал должен быть
     * доступен для редактирования пользователю, производящему загрузку
     *
     * @return string В случае успешной передачи параметров загрузки, в ответ вы получите id созданного видео.
     *
     * @throws InvalidArgumentException
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function upload(
        $url,
        $title = '',
        $description = '',
        $is_hidden = true,
        $category_id = 13,
        $callback_url = null,
        $errback_url = null,
        $query_fields = null,
        $extra = null,
        $quality_report = null,
        $converter_params = null,
        $author = null
    ) {
        if (is_array($url)) {
            $params = $url;
        } else {
            $params = [
                'url' => $url,
                'is_hidden' => intval($is_hidden),
                'category_id' => $category_id,
            ];

            if (!empty($title)) {
                $params['title'] = $title;
            }

            if (!empty($description)) {
                $params['description'] = $description;
            }

            if ($callback_url !== null) {
                $params['callback_url'] = $callback_url;
            }

            if ($errback_url !== null) {
                $params['errback_url'] = $errback_url;
            }

            if ($query_fields !== null) {
                $params['query_fields'] = $query_fields;
            }

            if ($extra !== null) {
                $params['extra'] = $extra;
            }

            if ($quality_report !== null) {
                $params['quality_report'] = $quality_report;
            }

            if ($converter_params !== null) {
                $params['converter_params'] = $converter_params;
            }

            if ($author !== null) {
                $params['author'] = $author;
            }
        }

        if (empty($params['url'])) {
            throw new InvalidArgumentException("Параметр 'url' должен быть указан");
        }

        $result = $this->getTransport()->uploadVideo($params);

        return isset($result['video_id']) ? $result['video_id'] : null;
    }

    /**
     * Удаление ролика
     *
     * @autorization требуется
     *
     * @param string $video_id ID ролика
     *
     * @return bool Ролик поставлен в очередь на удаление
     *
     * @throws InvalidArgumentException
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function deleteVideo($video_id)
    {
        if (empty($video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        return $this->getTransport()->deleteVideo($video_id);
    }

    /**
     * Получени информации о ролике
     *
     * @autorization требуется
     *
     * @param string $video_id ID ролика
     *
     * @return VideoInfo
     *
     * @throws InvalidArgumentException
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function getVideo($video_id)
    {
        if (empty($video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        $result = $this->getTransport()->getVideo($video_id);
        return new VideoInfo($result);
    }

    /**
     * Обновить информацию о ролике
     *
     * @autorization требуется
     *
     * @param VideoInfo|array|string $video_id ID ролика или массив именованных параметров или объект VideoInfo
     * @param string $title Название
     * @param int $category_id ID категории
     * @param string $description Описание
     * @param boolean $is_hidden Признак видимости, 1 - ролик скрыт
     * @param int $author id канала в который загружен ролик. Обратите внимание, что канал в который загружен ролик,
     * а так же канал, в который переносится ролик, должны быть доступны для редактирования пользователю,
     * производящему изменение
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function putVideo(
        $video_id,
        $title = null,
        $category_id = null,
        $description = null,
        $is_hidden = null,
        $author = null
    ) {
        if ($video_id instanceof VideoInfo) {
            $id = $video_id->id;

            $params = [
                'title' => $video_id->title
            ];

            if (isset($video_id->category)) {
                $params['category'] = $video_id->category->id;
            }

            if (isset($video_id->description)) {
                $params['description'] = $video_id->description;
            }

            if (isset($video_id->is_hidden)) {
                $params['is_hidden'] = $video_id->is_hidden;
            }

            if (isset($video_id->author)) {
                $params['author'] = $video_id->author->id;
            }
        } elseif (is_array($video_id)) {
            $id = $video_id['video_id'];
            unset($video_id['video_id']);
            $params = $video_id;
        } else {
            $id = $video_id;

            $params = [
                'title' => $title,
                'category' => $category_id,
            ];

            if (!is_null($description)) {
                $params['description'] = $description;
            }

            if (!is_null($is_hidden)) {
                $params['is_hidden'] = $is_hidden;
            }

            if (!is_null($author)) {
                $params['author'] = $author;
            }
        }

        if (empty($id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        if (empty($params['title'])) {
            throw new InvalidArgumentException("Параметр 'title' должен быть указан");
        }

        if (empty($params['category'])) {
            throw new InvalidArgumentException("Параметр 'category' должен быть указан");
        }

        $result = $this->getTransport()->putVideo($id, $params);
        return new VideoInfo($result);
    }

    /**
     * Обновление только указанных полей в информации о ролике
     *
     * @autorization требуется
     *
     * @param VideoInfo|array|string $video_id ID ролика или массив именованных параметров или объект VideoInfo
     * @param string|null $title Название
     * @param int|null $category_id ID категории
     * @param string|null $description Описание
     * @param int|null $is_hidden Признак видимости, 1 - ролик скрыт
     * @param int $author id канала в который загружен ролик. Обратите внимание, что канал в который загружен ролик,
     * а так же канал, в который переносится ролик, должны быть доступны для редактирования пользователю,
     * производящему изменение
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function patchVideo(
        $video_id,
        $title = null,
        $category_id = null,
        $description = null,
        $is_hidden = null,
        $author = null
    ) {
        if ($video_id instanceof VideoInfo) {
            $id = $video_id->id;

            $params = [];

            if (isset($video_id->title)) {
                $params['title'] = $video_id->title;
            }

            if (isset($video_id->category)) {
                $params['category'] = $video_id->category->id;
            }

            if (isset($video_id->description)) {
                $params['description'] = $video_id->description;
            }

            if (isset($video_id->is_hidden)) {
                $params['is_hidden'] = $video_id->is_hidden;
            }

            if (isset($video_id->author)) {
                $params['author'] = $video_id->author->id;
            }
        } elseif (is_array($video_id)) {
            $id = $video_id['video_id'];
            unset($video_id['video_id']);
            $params = $video_id;
        } else {
            $id = $video_id;

            $params = [];

            if (!is_null($title)) {
                $params['title'] = $title;
            }

            if (!is_null($description)) {
                $params['description'] = $description;
            }

            if (!is_null($is_hidden)) {
                $params['is_hidden'] = $is_hidden;
            }

            if (!is_null($category_id)) {
                $params['category'] = $category_id;
            }

            if (!is_null($author)) {
                $params['author'] = $author;
            }
        }

        if (empty($id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        $result = $this->getTransport()->patchVideo($id, $params);
        return new VideoInfo($result);
    }

    /**
     * Загрузка превью к ролику
     *
     * @autorization требуется
     *
     * @param string $video_id ID ролика
     * @param string $filename Путь к файлу превью
     *
     * @return string URL загруженного превью или null, если загрузка не удалась
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function addThumb($video_id, $filename)
    {
        if (empty($video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        $file = ['file' => $filename];

        $result = $this->getTransport()->addThumb($video_id, $file);

        return isset($result['thumbnail_url']) ? $result['thumbnail_url'] : null;
    }

    /**
     * Получение информации об отложенной публикации
     *
     * @autorization требуется + надо быть автором видео
     *
     * @param $video_id
     *
     * @return PublicationResponse
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function getPublication($video_id)
    {
        if (empty($video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        try {
            $result = $this->getTransport()->getPublication($video_id);
            if (!empty($result)) {
                return new PublicationResponse($result);
            }
        } catch (Exceptions\NotFoundException $e) {
        }

        return null;
    }

    /**
     * Создание отложенной публикации
     *
     * @autorization требуется + надо быть автором видео
     *
     * @param string $video_id ID ролика
     * @param string $timestamp Дата в формате 'YYYY-MM-DD H:i:s', например: '2015-01-16 20:36:31'
     *
     * @return PublicationResponse
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function addPublication($video_id, $timestamp)
    {
        if (empty($video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        $params = [
            'video' => $video_id,
            'timestamp' => $timestamp,
        ];

        $result = $this->getTransport()->addPublication($params);
        return new PublicationResponse($result);
    }

    /**
     * Изменение отложенной публикации ролика
     *
     * @autorization требуется + надо быть автором видео
     *
     * @param string $video_id ID ролика
     * @param string $timestamp Дата в формате 'YYYY-MM-DD H:i:s', например: '2015-01-16 20:36:31'
     *
     * @return PublicationResponse
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function putPublication($video_id, $timestamp)
    {
        if (empty($video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        $params = [
            'video' => $video_id,
            'timestamp' => $timestamp,
        ];

        $result = $this->getTransport()->putPublication($params);
        return new PublicationResponse($result);
    }

    /**
     * Изменение отложенной публикации ролика
     *
     * @autorization требуется + надо быть автором видео
     *
     * @param string $video_id ID ролика
     * @param string $timestamp Дата в формате 'YYYY-MM-DD H:i:s', например: '2015-01-16 20:36:31'
     *
     * @return PublicationResponse
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function patchPublication($video_id, $timestamp)
    {
        if (empty($video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        $params = [
            'video' => $video_id,
            'timestamp' => $timestamp,
        ];

        $result = $this->getTransport()->patchPublication($params);
        return new PublicationResponse($result);
    }

    /**
     * Удаление отложенной публикации
     *
     * @autorization требуется + надо быть автором видео
     *
     * @param $video_id
     *
     * @return PublicationResponse
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     * @throws Exceptions\NotFoundException
     */
    public function deletePublication($video_id)
    {
        if (empty($video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        return $this->getTransport()->deletePublication($video_id);
    }

    /**
     * Получение информации о связи конкретного видео и телешоу
     *
     * @autorization требуется + надо быть автором видео
     *
     * @param string $video_id
     *
     * @return VideoRelation
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function getRelatedShowMeta($video_id)
    {
        if (empty($video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        try {
            $result = $this->getTransport()->loadMetainfoContenttvs($video_id);
            return new VideoRelation($result);
        } catch (Exceptions\NotFoundException $e) {
            return null;
        }
    }

    /**
     * Добавление информации о связи конкретного видео и телешоу
     *
     * @autorization требуется + надо быть автором видео
     *
     * @param VideoRelation $relation
     *
     * @return VideoRelation
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function addRelatedShowMeta($relation)
    {
        if (empty($relation->video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        $result = $this->getTransport()->postMetainfoContenttvs($relation);
        return new VideoRelation($result);
    }

    /**
     * Изменение информации о связи конкретного видео и телешоу
     *
     * @autorization требуется + надо быть автором видео
     *
     * @param VideoRelation $relation
     *
     * @return VideoRelation
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function putRelatedShowMeta($relation)
    {
        if (empty($relation->video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        $video_id = $relation->video_id;

        $result = $this->getTransport()->putMetainfoContenttvs($video_id, $relation);
        return new VideoRelation($result);
    }

    /**
     * Изменение информации о связи конкретного видео и телешоу
     *
     * @autorization требуется + надо быть автором видео
     *
     * @param VideoRelation $relation
     *
     * @return mixed
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function patchRelatedShowMeta($relation)
    {
        if (empty($relation->video_id)) {
            throw new InvalidArgumentException("Параметр 'video_id' должен быть указан");
        }

        $video_id = $relation->video_id;

        $result = $this->getTransport()->patchMetainfoContenttvs($video_id, $relation);
        return new VideoRelation($result);
    }

    /**
     * Получение информации для проигрывания видео
     *
     * @param string $id ID ролика
     * @param int|null $quality количество выдаваемых качеств
     * @param string|null $userAgent
     * @param string|null $userIP IP от имени которого выполнялся запрос
     * @param string|null $referer Referer от имени которого выполнялся запрос
     *
     * @return mixed
     *
     * @throws Exceptions\BadRequestException
     * @throws Exceptions\ConnectionErrorException
     * @throws Exceptions\ForbiddenException
     * @throws Exceptions\MethodNotAllowedException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\ServerErrorException
     * @throws Exceptions\UnauthorizedException
     */
    public function getPlayOptions($id, $quality = null, $userAgent = null, $userIP = null, $referer = null)
    {
        $query = ($quality !== null) ? ['quality' => $quality] : [];

        if ($userAgent !== null) {
            $this->getTransport()->getClient()->setUserAgent($userAgent);
        }

        if ($userIP !== null) {
            $this->getTransport()->getClient()->setXRealIP($userIP);
        }

        if ($referer !== null) {
            $query['referer'] = $referer;
        }

        return $this->getTransport()->getVideoPlayOptions($id, $query);
    }
}
