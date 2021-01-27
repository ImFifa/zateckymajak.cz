<?php declare(strict_types = 1);

namespace App\FrontModule\Presenters;

use Nette\Utils\Strings;

class HomepagePresenter extends BasePresenter
{

	public function renderDefault(): void
	{
		$articles = $this->repository->new->getPublicNews('cs')->limit(7);
		$this->template->articles = $articles;

		foreach ($articles as $article) {
			$category[] = $this->repository->category->getCategoryById($article->category_id);
		}
		$this->template->article_category = $category;

		$this->template->categories = $this->repository->category->getCategories();
	}

	public function renderSections(): void
	{
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
