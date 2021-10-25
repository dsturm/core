import * as Turbo from '@hotwired/turbo';

// import './bootstrap';
// import './elements/turbo-echo-stream-tag';
import 'wicg-inert';

Turbo.start();

window.Turbo = Turbo;

document.addEventListener('turbo:submit-start', e => {
    const submitter = (e as any).detail.formSubmission.submitter;
    submitter.disabled = true;
});

document.addEventListener('turbo:submit-end', e => {
    const submitter = (e as any).detail.formSubmission.submitter;
    submitter.disabled = false;
});

document.addEventListener('turbo:before-fetch-response', async e => {
    const response = (e as any).detail.fetchResponse;
    if (response.statusCode >= 500 && response.statusCode <= 599) {
        const alert = (document.getElementById('fetch-error') as HTMLTemplateElement)?.content?.firstElementChild?.cloneNode(true) as HTMLElement;
        if (alert) {
            (document.getElementById('alerts') as AlertsElement).show(alert, { key: 'fetchError', duration: -1 });
        }
    }
});

document.addEventListener('turbo:before-stream-render', e => {
    const stream = e.target as StreamElement;
    if (stream.action === 'replace') {
        e.preventDefault();
        stream.targetElements.forEach(el => {
            morphdom(el, stream.templateContent.firstElementChild!);
        });
    }
});

import { Application } from '@hotwired/stimulus';
import { StreamElement } from '@hotwired/turbo/dist/types/elements';
import morphdom from 'morphdom';
import { AlertsController } from './controllers/alerts';

import ChannelPickerController from './controllers/channel-picker';
import { Comment } from './controllers/comment';
import { CommentReplies } from './controllers/comment-replies';
import { HeaderController } from './controllers/header';
import { LoadBackwards } from './controllers/load-backwards';
import { ModalController } from './controllers/modal';

window.Stimulus = Application.start();
window.Stimulus.register('channel-picker', ChannelPickerController);
window.Stimulus.register('modal', ModalController);
window.Stimulus.register('header', HeaderController);
window.Stimulus.register('load-backwards', LoadBackwards);
window.Stimulus.register('post-page', PostPage);
window.Stimulus.register('comment-replies', CommentReplies);
window.Stimulus.register('comment', Comment);
window.Stimulus.register('scrollspy', Scrollspy);
window.Stimulus.register('page', PageController);
window.Stimulus.register('alerts', AlertsController);
window.Stimulus.register('post', PostController);

declare global {
    interface Window {
        Turbo: any;
        Stimulus: Application;
    }
}

import { PopupElement, MenuElement, ModalElement, TooltipElement, AlertsElement } from 'inclusive-elements';
import { PageController } from './controllers/page';
import { PostController } from './controllers/post';
import { PostPage } from './controllers/post-page';
import { Scrollspy } from './controllers/scrollspy';


window.customElements.define('ui-popup', PopupElement);
window.customElements.define('ui-menu', MenuElement);
window.customElements.define('ui-modal', ModalElement);
window.customElements.define('ui-tooltip', TooltipElement);
window.customElements.define('ui-alerts', AlertsElement);
