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

use Rutube\Models\Show\ShowList;

class Show extends Entity
{
    /**
     * Получение списка доступных ТВ-шоу
     * @autorization не требуется
     *
     * @param int $page Страница
     * @param int $limit Кол-во результатов на странице
     *
     * @return mixed
     *  {
     *      "has_next": false, // флаг, указывающий о наличии следующей странциы
     *      "next": null, // ссылка на следующую страницу, если есть
     *      "previous": null, // ссылка на предыдущую страницу, если есть
     *      "page": 1, // номер страницы
     *      "per_page": 40, // количество роликов на странице
     *      "results": [ // массив результатов
     *          {
     *              "id": 7,
     *              "content": "http://rutube2010.ru/api/metainfo/tv/7/video",
     *              "name": "Comedy Woman",
     *              "can_subscribe": true,
     *              "description": "Каждую пятницу в час дня...",
     *              "picture": "http://pic.rutube2010.ru/tv/6b/6f/6b6f05b6c19f275c5652d6f8a0461927.jpg"
     *          }
     *      ]
     *  }
     *
     * @throws Exceptions\ConnectionErrorException
     */
    public function listShow($page = 1, $limit = 20)
    {
        $result = $this->getTransport()->loadMetainfoTv(['page' => $page, 'limit' => $limit]);
        return new ShowList($result);
    }

    /**
     * Поиск ТВ-шоу
     * @autorization не требуется
     *
     * @param string $search Строка для поиска шоу
     * @param int $page Страница
     * @param int $limit Кол-во результатов на странице
     *
     * @return mixed
     * @see listShow
     *
     * @throws Exceptions\ConnectionErrorException
     */
    public function searchShow($search, $page = 1, $limit = 20)
    {
        $result = $this->getTransport()->loadMetainfoTv(['search' => $search, 'page' => $page, 'limit' => $limit]);
        return new ShowList($result);
    }
}
