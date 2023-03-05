<x-waterhole::admin :title="__('waterhole::admin.users-title')">
    <div class="stack gap-md">

        <div class="row gap-sm wrap">
            <h1 class="h3">
                {{ __('waterhole::admin.users-title') }}
            </h1>

            <div class="grow"></div>

            <form
                class="combobox break-xs"
                data-controller="filter-input"
                data-turbo-action="replace"
                data-turbo-frame="users_frame"
            >
                <div class="input-container">
                    <x-waterhole::icon
                        icon="tabler-search"
                        class="no-pointer color-muted"
                    />
                    <input
                        data-action="
                            incremental-search#input
                            focus->filter-input#focus
                            blur->filter-input#blur
                            filter-input#update
                        "
                        data-controller="incremental-search"
                        data-filter-input-target="input"
                        name="q"
                        placeholder="{{ __('waterhole::admin.users-filter-placeholder') }}"
                        type="search"
                        value="{{ request('q') }}"
                    >
                </div>

                <ul
                    class="menu combobox__list"
                    data-action="
                        combobox-commit->filter-input#commit
                        mousedown->filter-input#preventBlur
                    "
                    data-filter-input-target="list"
                    hidden
                    id="filter-suggestions"
                    role="listbox"
                >
                    <li
                        id="filter-group"
                        role="option"
                        class="menu-item"
                        data-value="group:"
                    >
                        <span class="menu-item__title">group:</span>
                        <span class="color-muted">{{ __('waterhole::admin.users-filter-group-description') }}</span>
                    </li>
                    @foreach (Waterhole\Models\Group::selectable()->get() as $group)
                        <li
                            id="filter-group-{{ $group->id }}"
                            role="option"
                            class="menu-item"
                        >
                            <span class="menu-item__title">group:{{ str_contains($group->name, ' ') ? '"'.$group->name.'"' : $group->name }}</span>
                        </li>
                    @endforeach
                    <li
                        role="option"
                        class="menu-item"
                        data-value="is:suspended"
                    >
                        <span class="menu-item__title">is:suspended</span>
                    </li>
                </ul>
            </form>

            <a
                href="{{ route('waterhole.admin.users.create') }}"
                type="button"
                class="btn bg-accent"
            >
                <x-waterhole::icon icon="tabler-plus"/>
                <span>{{ __('waterhole::admin.create-user-button') }}</span>
            </a>
        </div>

        <turbo-frame id="users_frame" target="_top" class="stack gap-md">
            @if ($users->isNotEmpty())
                <div class="table-container full-width" tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                                {{--                                <td class="choice-cell">--}}
                                {{--                                    <label>--}}
                                {{--                                        <input type="checkbox">--}}
                                {{--                                    </label>--}}
                                {{--                                </td>--}}
                                @foreach (['name', 'email', 'groups', 'created_at', 'last_seen_at'] as $column)
                                    <th>
                                        @if (in_array($column, $sortable))
                                            <a
                                                href="{{ request()->fullUrlWithQuery(['sort' => $column, 'direction' => $sort === $column ? ($direction === 'asc' ? 'desc' : 'asc') : null]) }}"
                                                class="with-icon color-text"
                                            >
                                                <span>
                                                    {{ __('waterhole::admin.users-'.str_replace('_', '-', $column).'-column') }}
                                                </span>
                                                @if ($sort === $column)
                                                    <x-waterhole::icon :icon="'tabler-chevron-'.($direction === 'asc' ? 'up' : 'down')"/>
                                                @endif
                                            </a>
                                        @else
                                            {{ __('waterhole::admin.users-'.str_replace('_', '-', $column).'-column') }}
                                        @endif
                                    </th>
                                @endforeach
                                <th style="width: 1px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    {{--                                    <td class="choice-cell">--}}
                                    {{--                                        <label>--}}
                                    {{--                                            <input type="checkbox">--}}
                                    {{--                                        </label>--}}
                                    {{--                                    </td>--}}
                                    <td>
                                        <x-waterhole::user-label
                                            :user="$user"
                                            class="color-text"
                                            link
                                            target="_blank"
                                        />
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $user->email }}">{{ Str::limit($user->email, 20) }}</a>
                                    </td>
                                    <td>
                                        <x-waterhole::user-groups :user="$user"/>
                                    </td>
                                    <td>
                                        <x-waterhole::time-ago :datetime="$user->created_at"/>
                                    </td>
                                    <td>
                                        <x-waterhole::time-ago :datetime="$user->last_seen_at"/>
                                    </td>
                                    <td>
                                        <x-waterhole::action-buttons
                                            class="row text-xs"
                                            :for="$user"
                                            :button-attributes="['class' => 'btn btn--transparent btn--icon']"
                                            tooltips
                                            :limit="2"
                                            placement="bottom-end"
                                        />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $users->links() }}
                </div>
            @else
                <div class="placeholder card">
                    <x-waterhole::icon
                        class="placeholder__icon"
                        icon="tabler-search"
                    />
                    <h4>{{ __('waterhole::admin.users-empty-message') }}</h4>
                </div>
            @endif
        </turbo-frame>
    </div>
</x-waterhole::admin>
