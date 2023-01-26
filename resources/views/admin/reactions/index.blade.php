<x-waterhole::admin :title="__('waterhole::admin.reactions-title')">
    <div class="stack gap-md">
        <div class="row gap-md">
            <h1 class="h3">{{ __('waterhole::admin.reactions-title') }}</h1>

            <div class="grow"></div>

            <a href="{{ route('waterhole.admin.reaction-sets.create') }}" type="button" class="btn bg-accent">
                <x-waterhole::icon icon="tabler-plus"/>
                <span>{{ __('waterhole::admin.create-reaction-set-button') }}</span>
            </a>
        </div>

        <ul class="card" role="list">
            @forelse ($reactionSets as $reactionSet)
                <li class="card__row row gap-xs">
                    <div class="row reverse text-md reactions-condensed">
                        @foreach ($reactionSet->reactionTypes->reverse() as $reactionType)
                            <x-waterhole::icon :icon="$reactionType->icon"/>
                        @endforeach
                    </div>

                    {{ $reactionSet->name }}

                    <div class="grow"></div>

                    <x-waterhole::action-buttons
                        class="row text-xs"
                        :for="$reactionSet"
                        placement="bottom-end"
                        :button-attributes="['class' => 'btn btn--icon btn--transparent']"
                        tooltips
                        :limit="2"
                    />
                </li>
            @empty
                <li class="placeholder">No Reaction Sets</li>
            @endforelse
        </ul>
    </div>
</x-waterhole::admin>
