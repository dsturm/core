<x-waterhole::layout title="Edit Comment">
    <div class="container section">
        <turbo-frame
            id="@domid($comment)"
            class="comment"
        >
            <form
                method="POST"
                action="{{ $comment->url }}"
                class="comment__main"
            >
                <x-waterhole::attribution
                    :user="$comment->user"
                    :date="$comment->created_at"
                />

                @csrf
                @method('PATCH')
                <input type="hidden" name="return" value="{{ old('return', $comment->post_url) }}">

                <x-waterhole::validation-errors :errors="$errors"/>

                <x-waterhole::text-editor
                    name="body"
                    value="{{ old('body', $comment->body) }}"
                    class="input"
                />

                <div class="toolbar toolbar--right">
                    <a
                        href="{{ $comment->post_url }}"
                        class="btn"
                    >Cancel</a>

                    <button
                        type="submit"
                        class="btn btn--primary"
                    >Save</button>
                </div>
            </form>
        </turbo-frame>
    </div>
</x-waterhole::layout>
