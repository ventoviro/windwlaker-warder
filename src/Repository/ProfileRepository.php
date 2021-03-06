<?php
/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Lyrasoft\Warder\Repository;

use Windwalker\Core\User\User;

/**
 * The ProfileModel class.
 *
 * @since  1.0
 */
class ProfileRepository extends UserRepository
{
    /**
     * Property name.
     *
     * @var  string
     */
    protected $name = 'profile';

    /**
     * getRecord
     *
     * @param string $name
     *
     * @return  \Windwalker\Record\Record
     * @throws \Exception
     */
    public function getRecord($name = 'User')
    {
        return parent::getRecord($name);
    }

    /**
     * getDefaultData
     *
     * @return array
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getFormDefaultData()
    {
        $sessionData = (array) $this['form.data'];

        $pk = $this['load.conditions'];

        if (!$pk) {
            $pk = User::get()->id;
        }

        $item = $this->getItem($pk);

        $this->postGetItem($item);

        $item->bind($sessionData);

        unset($item->password);
        unset($item->password2);

        return $item->dump(true);
    }
}
