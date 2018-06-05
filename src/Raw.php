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

/**
 * Реализация прямых запросов к API
 *
 * @package Rutube
 */
class Raw extends Entity
{
    /**
     * Прямой запрос к API Rutube
     *
     * @param string $method Метод: GET, POST, PUT, PATCH, DELETE
     * @param string $url URL метода API, например: api/video/person/
     * @param array $options Параметры запроса:
     * [
     *     'params'=>[],
     *     'query'=>[],
     *     'file'=>[],
     *     'return_code'=>false
     * ]
     *
     * @return mixed
     *
     * @throws Exceptions\ConnectionErrorException
     */
    public function call($method, $url, $options = array())
    {
        return $this->getTransport()->call(
            $method,
            $url,
            isset($options['params']) ? $options['params'] : array(),
            isset($options['query']) ? $options['query'] : array(),
            isset($options['file']) ? $options['file'] : array(),
            isset($options['return_code']) ? $options['return_code'] : false
        );
    }
}
