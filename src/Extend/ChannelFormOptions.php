<?php

namespace Waterhole\Extend;

use Waterhole\Extend\Concerns\OfComponents;
use Waterhole\Extend\Concerns\OrderedList;
use Waterhole\Forms\Fields\ChannelDefaultLayout;
use Waterhole\Forms\Fields\ChannelFilters;
use Waterhole\Forms\Fields\ChannelReactions;
use Waterhole\Forms\Fields\ChannelSandbox;
use Waterhole\Forms\Fields\ChannelTaxonomies;

abstract class ChannelFormOptions
{
    use OrderedList, OfComponents;
}

ChannelFormOptions::add('sandbox', ChannelSandbox::class);
ChannelFormOptions::add('default-layout', ChannelDefaultLayout::class);
ChannelFormOptions::add('filters', ChannelFilters::class);
ChannelFormOptions::add('reactions', ChannelReactions::class);
ChannelFormOptions::add('taxonomies', ChannelTaxonomies::class);
