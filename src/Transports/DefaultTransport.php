<?php

/*
 * This file is part of the Rutube PHP API Client package.
 *
 * (c) Rutube
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rutube\Transports;

/**
 * Низкоуровневое обращение к API
 *
 * @package Rutube\Transports
 */
class DefaultTransport extends Transport
{
    /**
     * @param string $username
     * @param string $password
     *
     * @return $this
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function authorize($username, $password)
    {
        $response = $this->call(
            'POST',
            'api/accounts/token_auth/',
            ['username' => $username, 'password' => $password]
        );

        $this->token = $response['token'];

        return $this;
    }

    /**
     * @param array $query
     * @return mixed
     * @throws \Rutube\Exceptions\ConnectionErrorException
     */
    public function loadVideoPerson(array $query)
    {
        return $this->call('GET', 'api/video/person/', [], $query);
    }

    /**
     * @param int $id
     * @param array $query
     * @return mixed
     * @throws \Rutube\Exceptions\ConnectionErrorException
     */
    public function loadVideoPersonById($id, array $query)
    {
        return $this->call('GET', 'api/video/person/' . $id . '/', [], $query);
    }

    /**
     * @return mixed
     * @param array $query
     * @throws \Rutube\Exceptions\ConnectionErrorException
     */
    public function loadTags(array $query)
    {
        return $this->call('GET', 'api/tags/', [], $query);
    }

    /**
     * @param int $id
     * @param array $query
     * @return mixed
     * @throws \Rutube\Exceptions\ConnectionErrorException
     */
    public function loadVideoTags($id, array $query)
    {
        return $this->call('GET', 'api/tags/video/' . $id . '/', [], $query);
    }

    /**
     * @param array $query
     * @return mixed
     * @throws \Rutube\Exceptions\ConnectionErrorException
     */
    public function loadMetainfoTv(array $query)
    {
        return $this->call('GET', 'api/metainfo/tv/', [], $query);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws \Rutube\Exceptions\ConnectionErrorException
     */
    public function loadMetainfoTvContentTypes($id)
    {
        return $this->call('GET', 'api/metainfo/tv/' . $id . '/contenttvstype/');
    }


    /**
     * @param string $id
     * @return mixed
     * @throws \Rutube\Exceptions\ConnectionErrorException
     */
    public function loadMetainfoTvSeasons($id)
    {
        return $this->call('GET', 'api/metainfo/tv/' . $id . '/season/');
    }

    /**
     * @param string $id
     * @param array $query
     * @return mixed
     * @throws \Rutube\Exceptions\ConnectionErrorException
     */
    public function loadMetainfoTvVideos($id, array $query)
    {
        return $this->call('GET', 'api/metainfo/tv/' . $id . '/video/', [], $query);
    }

    /**
     * @param string $id
     * @param array $query
     * @return mixed
     * @throws \Rutube\Exceptions\ConnectionErrorException
     */
    public function loadMetainfoTvLastEpisode($id, $query)
    {
        return $this->call('GET', 'api/metainfo/tv/' . $id . '/last_episode/', [], $query);
    }

    /**
     * @param string $video_id
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function loadMetainfoContenttvs($video_id)
    {
        return $this->call('GET', 'api/metainfo/contenttvs/' . $video_id . '/');
    }


    /**
     * Добавление связи видео с телешоу
     *
     * @param $relation
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function postMetainfoContenttvs($relation)
    {
        return $this->call('POST', 'api/metainfo/contenttvs/', $relation);
    }

    /**
     * Изменение связи видео с телешоу
     *
     * @param string $video_id
     * @param mixed $relation
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function putMetainfoContenttvs($video_id, $relation)
    {
        return $this->call('PUT', "api/metainfo/contenttvs/{$video_id}/", $relation);
    }

    /**
     * Изменение связи видео с телешоу
     *
     * @param string $video_id
     * @param mixed $relation
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function patchMetainfoContenttvs($video_id, $relation)
    {
        return $this->call('PATCH', "api/metainfo/contenttvs/{$video_id}/", $relation);
    }

    /**
     * @param string $id
     * @param array $query
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function getVideoPlayOptions($id, array $query)
    {
        return $this->call('GET', 'api/play/options/' . $id . '/', [], $query);
    }

    /**
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function uploadVideo(array $params)
    {
        return $this->call('POST', 'api/video/', $params);
    }

    /**
     * @param string $video_id
     *
     * @return bool
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function deleteVideo($video_id)
    {
        return $this->call('DELETE', 'api/video/' . $video_id, [], [], [], true) == 204;
    }

    /**
     * @param string $video_id
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function putVideo($video_id, array $params)
    {
        return $this->call('PUT', 'api/video/' . $video_id . '/', $params);
    }

    /**
     * @param string $video_id
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function getVideo($video_id)
    {
        return $this->call('GET', 'api/video/' . $video_id . '/');
    }

    /**
     * @param string $video_id
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function patchVideo($video_id, array $params)
    {
        return $this->call('PATCH', 'api/video/' . $video_id, $params);
    }

    /**
     * @param string $video_id
     * @param array $file
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function addThumb($video_id, array $file)
    {
        return $this->call('POST', 'api/video/' . $video_id . '/thumbnail/', [], [], $file);
    }

    /**
     * Получение информации об отложенной публикации
     *
     * @param string $video_id
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function getPublication($video_id)
    {
        return $this->call('GET', "api/video/publication/{$video_id}/");
    }

    /**
     * Создание отложенной публикации
     *
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function addPublication(array $params)
    {
        return $this->call('POST', 'api/video/publication/', $params);
    }

    /**
     * Изменение информации об отложенной публикации
     *
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function putPublication(array $params)
    {
        return $this->call('PUT', "api/video/publication/{$params['video']}/", $params);
    }

    /**
     * Изменение информации об отложенной публикации
     *
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function patchPublication(array $params)
    {
        return $this->call('PATCH', "api/video/publication/{$params['video']}/", $params);
    }

    /**
     * Удаление отложенной публикации
     *
     * @param string $video_id
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function deletePublication($video_id)
    {
        return $this->call('DELETE', "api/video/publication/{$video_id}/");
    }

    /**
     * Изменение пароля пользователя
     *
     * @param int $oldpass Старый пароль
     * @param int $newpass Новый пароль
     *
     * @return mixed
     *
     * @throws \Rutube\Exceptions\BadRequestException
     * @throws \Rutube\Exceptions\ConnectionErrorException
     * @throws \Rutube\Exceptions\ForbiddenException
     * @throws \Rutube\Exceptions\MethodNotAllowedException
     * @throws \Rutube\Exceptions\NotFoundException
     * @throws \Rutube\Exceptions\ServerErrorException
     * @throws \Rutube\Exceptions\UnauthorizedException
     */
    public function changePassword($oldpass, $newpass)
    {
        return $this->call(
            'PUT',
            '/api/accounts/edit/password/',
            ['current_pass' => $oldpass, 'new_pass' => $newpass, 'again_pass' => $newpass]
        );
    }
}
