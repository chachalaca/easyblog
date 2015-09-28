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

        $router[] = new Route('/<articleId>[/from/<presenter>/<action>]', [
            'module' => 'Front',
            'presenter' => 'Blog',
            'action' => 'detail',

        ]);

        $router[] = new Route('<presenter>/[<action>[/<id>]]', [
            'module' => 'Front',
            'presenter' => 'Blog',
            'action' => 'default',
            'id' => NULL,
        ]);





		return $router;
	}

}
