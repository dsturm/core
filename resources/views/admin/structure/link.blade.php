@php
    $title = isset($link)
        ? __('waterhole::admin.edit-link-title')
        : __('waterhole::admin.create-link-title');
@endphp

<x-waterhole::admin :title="$title">
    <x-waterhole::admin.title
        :parent-url="route('waterhole.admin.structure')"
        :parent-title="__('waterhole::admin.structure-title')"
        :title="$title"
    />

    <form
        method="POST"
        action="{{ isset($link) ? route('waterhole.admin.structure.links.update', compact('link')) : route('waterhole.admin.structure.links.store') }}"
        enctype="multipart/form-data"
    >
        @csrf
        @if (isset($link)) @method('PATCH') @endif

        <div class="stack gap-lg">
            <x-waterhole::validation-errors/>

            <div class="stack gap-md">
                @components($form->fields())
            </div>

            <div class="row gap-xs wrap">
                <button
                    type="submit"
                    class="btn bg-accent btn--wide"
                >
                    {{ isset($link) ? __('waterhole::system.save-changes-button') : __('waterhole::system.create-button') }}
                </button>

                <a
                    href="{{ route('waterhole.admin.structure') }}"
                    class="btn"
                >{{ __('waterhole::system.cancel-button') }}</a>
            </div>
        </div>
    </form>
</x-waterhole::admin>
