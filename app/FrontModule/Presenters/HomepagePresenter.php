<?php declare(strict_types = 1);

namespace App\FrontModule\Presenters;

/**
* * @property-read \App\Model\FolderModel $folder
**/

class HomepagePresenter extends BasePresenter
{
	public function renderDefault(): void
	{
		$vars = $this->configuration;

		$nOfArticles = (int) $vars->articlesCount;
		$articles = $this->repository->getPublicNews('cs')->limit($nOfArticles);
		$this->template->articles = $articles;
		$this->template->nOfArticles = $nOfArticles + 4;

		foreach ($articles as $article) {
			$category[] = $this->repository->getCategoryById($article->category_id);
		}
		$this->template->article_category = $category;

		$this->template->categories = $this->repository->getCategories();
	}

	public function renderSections(): void
	{
		$this->template->categories = $this->repository->getCategories();
	}

	public function renderAuthors(): void
	{

	}

	public function renderDocuments(): void
	{
		$this->template->folder_zpravodajstvi = $this->repository->getFilesByFolderId(5);
		$this->template->folder_sluzby = $this->repository->getFilesByFolderId(6);
		$this->template->folder_kultura = $this->repository->getFilesByFolderId(7);
		$this->template->folder_sport = $this->repository->getFilesByFolderId(8);
		$this->template->folder_vzdelavani = $this->repository->getFilesByFolderId(9);
		$this->template->folder_blogy = $this->repository->getFilesByFolderId(10);
		$this->template->filetypes = ['doc', 'docx', 'jpeg', 'jpg', 'pdf', 'png', 'ppt', 'pptx', 'txt', 'xls', 'xlsx'];
	}

	public function renderContact(): void
	{

	}

	public function renderSitemap(): void
	{

	}

}
