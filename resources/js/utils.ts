/**
 * Determine whether the user is trying to open a link in a new tab.
 */
export function shouldOpenInNewTab(e: MouseEvent): boolean {
    return e.altKey || e.ctrlKey || e.metaKey || e.shiftKey
        || (e.button !== undefined && e.button !== 0);
}

/**
 * Determine if an element is currently visible in the viewport.
 */
export function isElementInViewport(el: HTMLElement, proportion: number = 1): boolean {
    const rect = el.getBoundingClientRect();

    return -rect.top / rect.height < proportion
        && (rect.bottom - window.innerHeight) / rect.height < proportion;
}

/**
 * Get the height of the page header.
 */
export function getHeaderHeight(): number {
    return document.getElementById('#header')?.offsetHeight || 0;
}

/**
 * Convert an HTML string into a DOM element.
 */
export function htmlToElement(html: string): Element | null {
    const template = document.createElement('template');
    template.innerHTML = html;

    return template.content.firstElementChild;
}

/**
 * Create a slug out of the given string. Non-alphanumeric characters are
 * converted to hyphens.
 */
export function slug(string: string): string {
    return string.toLowerCase()
        .replace(/[^a-z0-9]/gi, '-')
        .replace(/-+/g, '-')
        .replace(/-$|^-/g, '');
}
