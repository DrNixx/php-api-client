<?php
namespace Rutube\Models\Video;

use Rutube\Models\BaseObject;

/**
 * Ответ сервера rutube при отложенной публикации
 *
 * @property string $video id видео
 * @property string $created Дата и время создания отложенной публикации
 * @property string $modified Дата и время последнего изменения отложенной публикации
 * @property string $timestamp Дата и время открытия ролика с отложенной публикацией
 * @property string $blocking_rule Id cвязанной блокировки видео
 */
class PublicationResponse extends BaseObject
{
}
