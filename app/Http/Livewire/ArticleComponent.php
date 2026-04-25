<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleComponent extends Component
{
    public $Article_id = 0;

    public $Article = [
        "designation" => "loading",
        "prix" => "loading",
        "Details" => "loading",
        "Quantite" => "loading"
    ];

    public function render()
    {
        return view('livewire.article-component');
    }

    public function mount($id)
    {
        $this->Article_id = $id;
    }

    public function find($id)
    {
        $this->Article = Article::findOrFail($id);
    }
}
