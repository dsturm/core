@php
    $title = isset($page) ? 'Edit Page' : 'Create a Page';
@endphp

<x-waterhole::admin :title="$title">
    <x-waterhole::dialog :title="$title">
        <form
            method="POST"
            action="{{ isset($page) ? route('waterhole.admin.structure.pages.update', compact('page')) : route('waterhole.admin.structure.pages.store') }}"
        >
            @csrf
            @if (isset($page)) @method('PATCH') @endif

            <div class="stack-lg" data-controller="slugger">
                <x-waterhole::validation-errors/>

                <div class="form-groups">
                    <x-waterhole::field name="name" label="Name">
                        <input
                            type="text"
                            name="name"
                            id="{{ $component->id }}"
                            class="input"
                            value="{{ old('name', $page->name ?? null) }}"
                            autofocus
                            data-action="slugger#updateName"
                        >
                    </x-waterhole::field>

                    <x-waterhole::field name="slug" label="Slug">
                        <input
                            type="text"
                            name="slug"
                            id="{{ $component->id }}"
                            class="input"
                            value="{{ old('slug', $page->slug ?? null) }}"
                            data-action="slugger#updateSlug"
                            data-slugger-target="slug"
                        >
                        <p class="field__description">
                            This page will be accessible at
                            {!! preg_replace('~^https?://~', '', str_replace('*', '<span data-slugger-target="mirror">'.old('slug', $page->slug ?? '').'</span>', route('waterhole.page', ['page' => '*']))) !!}.
                        </p>
                    </x-waterhole::field>

                    <x-waterhole::field name="icon" label="Icon">
                        <input
                            type="text"
                            name="icon"
                            id="{{ $component->id }}"
                            class="input"
                            value="{{ old('icon', $page->icon ?? null) }}"
                        >
                    </x-waterhole::field>

                    <x-waterhole::field name="body" label="Body">
                        <x-waterhole::text-editor
                            name="body"
                            id="{{ $component->id }}"
                            :value="old('body', $page->body ?? null)"
                            class="input"
                        />
                    </x-waterhole::field>

                    <div class="field">
                        <div class="field__label">Permissions</div>
                        <div>
                            <x-waterhole::admin.permission-grid
                                :abilities="['view']"
                                :defaults="['view']"
                                :permissions="$page->permissions ?? null"
                            />
                        </div>
                    </div>

                    <div>
                        <div class="toolbar">
                            <button type="submit" class="btn btn--primary btn--wide">
                                {{ isset($page) ? 'Save Changes' : 'Create' }}
                            </button>
                            <a href="{{ route('waterhole.admin.structure') }}" class="btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-waterhole::dialog>
</x-waterhole::admin>
