<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('admin', array(
			'module' => 'Admin',
			'presenter' => 'Homepage',
			'action' => 'default'
		));

		$router[] = new Route('prihlaseni', array(
			'module' => 'Front',
			'presenter' => 'Sign',
			'action' => 'in'
		));


		$router[] = new Route('odhlaseni', array(
			'module' => 'Front',
			'presenter' => 'Sign',
			'action' => 'out'
		));


		$router[] = new Route('<presenter>/<action>[/<id>]', 'Front:Homepage:default');


		return $router;
	}

}
