<?php

namespace App\View\Components\Home;

use App\Models\TopCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class TopCategories extends Component
{
    public Collection $topCategories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->topCategories = TopCategory::with('category')
            ->orderBy('sort_order', 'asc')
            ->take(6)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.top-categories');
    }
}
