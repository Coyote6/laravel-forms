<?php
	
	
namespace Coyote6\LaravelForms\Traits;

use Illuminate\Support\Collection;


trait HtmlContent {
	
    protected string $content = '';

	// Set Content
	//
	// @param string $content - The html content to display.
	// @return self
	//
	public function setContent (string $content): self {
		$this->content = strip_tags ($content, '');			// Immediately strip any php tags.
		return $this;
	}

	// Content
	//
	// @alias setContent
	// @param string $content - The html content to display.
	// @return self
	//
	public function content (string $content): self {
		return $this->setContent($content);
	}


	// Get Content (Sanatizes to remove PHP tags)
	//
	// @return string
	//
	public function getContent (Collection|array|string $allowedTags = ''): string {
		return strip_tags ($this->content, $allowedTags);
	}

	
}