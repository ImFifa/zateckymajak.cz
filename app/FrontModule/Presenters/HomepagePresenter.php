<?php declare(strict_types = 1);

namespace App\FrontModule\Presenters;

class HomepagePresenter extends BasePresenter
{

	public function renderDefault(): void
	{
		$this->template->articles = $this->repository->new->getPublicNews('cs')->limit(5);
		$this->template->categories = $this->repository->category->getCategories();
	}

	public function renderAuthors(): void
	{

	}

	public function renderContact(): void
	{

	}

	public function renderSitemap(): void
	{

	}

}
