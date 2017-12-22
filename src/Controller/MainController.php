<?php
namespace Drupal\popup\Controller;
use Drupal\Core\Controller\ControllerBase;
/**
* Controlador de Popup
*/
class MainController extends ControllerBase
{

	function init()
	{
		return [
	      '#type' => 'markup',
	      '#markup' =>'hola'
	    ];
	}
}