<?php declare(strict_types = 1);

namespace App\FrontModule\Presenters;

use App\Components\BoxComponent;
use App\Components\IBoxComponentFactory;
use App\CoreModule\Presenters\FrontBasePresenter;
use App\Model\ConfigurationModel;
use stdClass;

abstract class BasePresenter extends FrontBasePresenter
{

	/** @inject */
	public IBoxComponentFactory $boxFactory;

	/** @var ConfigurationModel */
	public $configuration;

	public function flashMessage($message, string $type = 'success'): stdClass
	{
		return parent::flashMessage($message, $type);
	}

	protected function createComponentBox(): BoxComponent
	{
		return $this->boxFactory->create();
	}
}
