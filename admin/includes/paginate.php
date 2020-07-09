<?php
class Paginate {
    public $current_page;
    public $items_per_page;
    public $items_total_count;

    public function __construct($page, $items_per_page, $items_total_count) {
        $this->current_page = (int)$page;
        $this->items_per_page = (int)$items_per_page;
        $this->items_total_count = (int)$items_total_count;
    }

    // Next page: The current page + 1;
    public function next() {
        return $this->current_page + 1;
    }

    // Previous page: The current page - 1;
    public function previous() {
        return $this->current_page - 1;
    }

    // Calculate total of page
    public function pageTotal() {
        // ceil - Round fractions up
        return ceil($this->items_total_count/$this->items_per_page);
    }

    // If current page less than 1, can't previous page
    public function hasPrevious() {
        return $this->previous() >= 1 ? true : false;
    }

    // If current page more than page total, can't next page
    public function hasNext() {
        return $this->next() <= $this->pageTotal() ? true : false;
    }

    public function offset() {
        return ($this->current_page - 1) * $this->items_per_page;
    }
}

?>