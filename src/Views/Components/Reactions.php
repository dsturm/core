<?php

namespace Waterhole\Views\Components;

use Illuminate\View\Component;
use Waterhole\Models\Model;
use Waterhole\Views\Components\Concerns\Streamable;

class Reactions extends Component
{
    use Streamable;

    public Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('waterhole::components.reactions');
    }
}
