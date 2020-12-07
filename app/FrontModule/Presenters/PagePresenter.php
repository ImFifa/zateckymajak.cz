<?php declare(strict_types = 1);

namespace App\FrontModule\Presenters;

use function array_key_exists;

class PagePresenter extends BasePresenter
{

	/** @var array<string, string> */
	private array $subpages = [];

	public function renderDefault(?string $slug): void
	{
		if ($slug !== null && array_key_exists($slug, $this->subpages)) {
			$this->template->slug = $slug;
			$this->template->page = $this->subpages[$slug];
		} else {
			$this->error();
		}
	}

}
