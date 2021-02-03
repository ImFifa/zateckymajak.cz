<?php declare(strict_types = 1);

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;

class RouterFactory
{

	use Nette\StaticClass;

	public static function createRouter(): Nette\Routing\Router
	{
		$router = new RouteList();

		$router->withModule('Admin')
			->addRoute('admin/<presenter>/<action>[/<id>]', 'Homepage:default');


		$router->withModule('Front')->addRoute('[<lang=cs (cs)>/]', 'Homepage:default');
		$router->withModule('Front')->addRoute('[<lang=cs (cs)>/]rubriky', 'Homepage:sections');
		$router->withModule('Front')->addRoute('[<lang=cs (cs)>/]redakce', 'Homepage:authors');
		$router->withModule('Front')->addRoute('[<lang=cs (cs)>/]kontakt', 'Homepage:contact');
		$router->withModule('Front')->addRoute('[<lang=cs (cs)>/]mapa-stranek', 'Homepage:sitemap');

		$router->withModule('Front')->addRoute('[<lang=cs (cs)>/]<section>[/<page [0-9]>]', 'Section:default');
		$router->withModule('Front')->addRoute('[<lang=cs (cs)>/]<section>/<slug>', 'Section:article');

		return $router;
	}

}
