<?php declare(strict_types = 1);

namespace App\FrontModule\Presenters;

class SectionPresenter extends BasePresenter
{

	public function renderDefault($section): void
	{
		$this->template->category = $this->repository->category->getCategoryBySlug($section);
	}

	public function renderArticle($section, $slug): void
	{
		$article = $this->repository->new->getNew($slug, 'cs');
		$this->template->article = $article;

		$this->template->article_category = $this->repository->category->getCategoryById($article->category_id);


		if ($article->gallery_id != NULL)
			$this->template->images = $this->repository->image->getImagesByGallery($article->gallery_id);


		bdump($this->template->article);


	}

}
