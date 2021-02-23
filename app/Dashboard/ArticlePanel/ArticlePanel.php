<?php

namespace App\Dashboard\ArticlePanel;

use App\AdminModule\Components\DashboardControl\Panel;
use App\Model\ArticleModel;

class ArticlePanel extends Panel
{

	/** @var ArticleModel */
	private $articleModel;

	public function __construct(ArticleModel $articleModel)
	{
		$this->articleModel = $articleModel;
	}

	public function render(): void
	{
		$this->template->setFile(__DIR__ . '/ArticlePanel.latte');
		$this->template->count = $this->articleModel->getCount();
		$this->template->lastArticle = $this->articleModel->getTable()->order('created DESC, id DESC')->limit(1)->fetch();
		$this->template->render();
	}

}
