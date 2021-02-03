<?php declare(strict_types = 1);

namespace App\FrontModule\Presenters;

class HomepagePresenter extends BasePresenter
{
	public function renderDefault(): void
	{
		$vars = $this->configuration;

		$nOfArticles = (int) $vars->articlesCount;
		$articles = $this->repository->new->getPublicNews('cs')->limit($nOfArticles);
		$this->template->articles = $articles;
		$this->template->nOfArticles = $nOfArticles + 4;

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
