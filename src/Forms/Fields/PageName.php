<?php

namespace Waterhole\Forms\Fields;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Waterhole\Forms\Field;
use Waterhole\Models\Page;

class PageName extends Field
{
    public function __construct(public ?Page $model)
    {
    }

    public function render(): string
    {
        return <<<'blade'
            <x-waterhole::field
                name="name"
                :label="__('waterhole::admin.page-name-label')"
            >
                <input
                    type="text"
                    name="name"
                    id="{{ $component->id }}"
                    value="{{ old('name', $model->name ?? null) }}"
                    autofocus
                    data-action="slugger#updateName"
                >
            </x-waterhole::field>
        blade;
    }

    public function validating(Validator $validator): void
    {
        $validator->addRules(['name' => ['required', 'string', 'max:255']]);
    }

    public function saving(FormRequest $request): void
    {
        $this->model->name = $request->validated('name');
    }
}
