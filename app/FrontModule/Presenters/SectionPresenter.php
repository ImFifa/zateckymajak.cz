<?php declare(strict_types = 1);

namespace App\FrontModule\Presenters;

use Nette\Utils\Paginator;

class SectionPresenter extends BasePresenter
{

	public function renderDefault($section, int $page = 1): void
	{
		$vars = $this->configuration;
		$itemsPerPage = (int) $vars->itemsPerPage;

		$category = $this->repository->getCategoryBySlug($section);
		$this->template->category = $category;

		$articlesCount = $this->repository->getPublicNewsByCategoryCount('cs', $category->id);

		$paginator = new Paginator;
		$paginator->setPage($page); // číslo aktuální stránky
		$paginator->setItemsPerPage($itemsPerPage); // počet položek na stránce
		$paginator->setItemCount($articlesCount); // celkový počet položek, je-li znám

		$this->template->articles = $this->repository->getPublicNewsByCategory('cs', $category->id, $paginator->getLength(), $paginator->getOffset());
		$this->template->paginator = $paginator;
		$this->template->categories = $this->repository->getCategories();
	}

	public function renderArticle($section, $slug): void
	{
		$article = $this->repository->article->getNew($slug, 'cs');

		if (isset($article->perex))
			$this->template->perex = strip_tags($article->perex);

		$this->template->article = $article;

		$this->template->article_category = $this->repository->getCategoryById($article->category_id);

		if ($article->gallery_id != NULL)
			$this->template->images = $this->repository->image->getImagesByGallery($article->gallery_id);

		if ($article->folder_id != NULL) {
			$this->template->folder = $this->repository->getFolder($article->folder_id);
			$this->template->files = $this->repository->getFilesByFolderId($article->folder_id);
			$this->template->filetypes = ['doc', 'docx', 'jpeg', 'jpg', 'pdf', 'png', 'ppt', 'pptx', 'txt', 'xls', 'xlsx'];
		}

		$url = $this->getHttpRequest()->getUrl()->getAbsoluteUrl();
		$this->template->url = $url;
	}

}
