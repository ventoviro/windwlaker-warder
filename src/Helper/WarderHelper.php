<?php
/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2016 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Warder\Helper;

use Symfony\Component\Yaml\Yaml;
use Windwalker\Core\Package\PackageHelper;
use Windwalker\Warder\Data\UserData;
use Windwalker\Warder\WarderPackage;

/**
 * The SentryHelper class.
 *
 * @since  {DEPLOY_VERSION}
 */
class WarderHelper
{
	/**
	 * Property package.
	 *
	 * @var  WarderPackage
	 */
	protected static $package;

	/**
	 * getLoginName
	 *
	 * @param string $default
	 *
	 * @return string
	 */
	public static function getLoginName($default = 'username')
	{
		return static::getPackage()->getLoginName($default);
	}

	/**
	 * isFrontend
	 *
	 * @param   string $name
	 *
	 * @return  boolean
	 */
	public static function isFrontend($name = null)
	{
		return static::getPackage()->isFrontend($name);
	}

	/**
	 * isAdmin
	 *
	 * @param   string $name
	 *
	 * @return  boolean
	 */
	public static function isAdmin($name = null)
	{
		return static::getPackage()->isAdmin($name);
	}

	/**
	 * getFrontendRouting
	 *
	 * @return  array
	 */
	public static function getFrontendRouting()
	{
		if (!static::$package)
		{
			throw new \LogicException('Please register warder into Windwalker first.');
		}

		return Yaml::parse(file_get_contents(WARDER_SOURCE . '/routing.yml'));
	}

	/**
	 * getFrontendRouting
	 *
	 * @return  array
	 */
	public static function getAdminRouting()
	{
		if (!static::$package)
		{
			throw new \LogicException('Please register warder into Windwalker first.');
		}

		return Yaml::parse(file_get_contents(WARDER_SOURCE_ADMIN . '/routing.yml'));
	}

	/**
	 * getPackage
	 *
	 * @return  WarderPackage
	 */
	public static function getPackage()
	{
		if (!static::$package)
		{
			throw new \LogicException('Please register warder into Windwalker first.');
		}

		return static::$package;
	}

	/**
	 * Method to set property package
	 *
	 * @param   WarderPackage $package
	 *
	 * @return  void
	 */
	public static function setPackage(WarderPackage $package)
	{
		static::$package = $package;
	}

	/**
	 * createUserData
	 *
	 * @param array $data
	 *
	 * @return  UserData
	 */
	public static function createUserData($data = array())
	{
		return static::getPackage()->createUserData($data);
	}
}
