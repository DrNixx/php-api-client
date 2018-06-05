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
 * Управление аккаунтом пользователя
 *
 * @package Rutube
 */
class Account extends Entity
{
    /**
     * Изменение пароля пользователя
     *
     * @param int $oldpass Старый пароль
     * @param int $newpass Новый пароль
     *
     * @return mixed
     *
     * @throws Exceptions\ConnectionErrorException
     */
    public function changePassword($oldpass, $newpass)
    {
        return $this->getTransport()->changePassword($oldpass, $newpass);
    }
}
