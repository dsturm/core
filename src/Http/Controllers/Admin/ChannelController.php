<?php

namespace Waterhole\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Waterhole\Forms\ChannelForm;
use Waterhole\Http\Controllers\Controller;
use Waterhole\Models\Channel;

/**
 * Controller for admin channel management (create and update).
 *
 * Deletion is handled by the DeleteChannel action.
 */
class ChannelController extends Controller
{
    public function create()
    {
        $form = $this->form(new Channel());

        return view('waterhole::admin.structure.channel', compact('form'));
    }

    public function store(Request $request)
    {
        $this->form(new Channel())->submit($request);

        return redirect()->route('waterhole.admin.structure');
    }

    public function edit(Channel $channel)
    {
        $form = $this->form($channel);

        return view('waterhole::admin.structure.channel', compact('form', 'channel'));
    }

    public function update(Channel $channel, Request $request)
    {
        $this->form($channel)->submit($request);

        return redirect()->route('waterhole.admin.structure');
    }

    private function form(Channel $channel)
    {
        return new ChannelForm($channel);
    }
}
