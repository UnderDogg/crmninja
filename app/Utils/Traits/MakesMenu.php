<?php

namespace App\Utils\Traits;

use Nwidart\Modules\Facades\Module;

/**
 * Class MakesMenu
 * @package App\Utils\Traits
 */
trait MakesMenu
{
	
	/**
	 * Builds an array of available modules for this view
	 * @param  string $entity Class name
	 * @return array of modules
	 */
	public function makeEntityTabMenu(string $entity) : array
	{

        $tabs = [];

    	foreach (Module::getCached() as $module)
		{
			if(!$module['sidebar']
                && $module['active'] == 1
                && in_array( strtolower( class_basename($entity) ), $module['views']))
			{
                $tabs[] = $module;
			}
		}

		return $tabs;

	}

	/**
	 * Builds an array items to be presented on the sidebar
	 * @return array menu items
	 */
	public function makeSideBarMenu()
	{

	}

}