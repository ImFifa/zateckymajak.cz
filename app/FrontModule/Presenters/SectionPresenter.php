<?php declare(strict_types = 1);

namespace App\FrontModule\Presenters;

class SectionPresenter extends BasePresenter
{

	public function renderDefault($section): void
	{
		$this->template->section = $section;
	}

	public function renderArticle($section, $slug): void
	{
		$article = $this->repository->new->getNew($slug, 'cs');
		$this->template->article = $article;


		if ($article->gallery_id != NULL)
			$this->template->images = $this->repository->image->getImagesByGallery($article->gallery_id);


		bdump($this->template->article);


	}

}
