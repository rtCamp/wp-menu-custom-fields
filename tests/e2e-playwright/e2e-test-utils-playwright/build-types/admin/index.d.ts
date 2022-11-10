/**
 * External dependencies
 */
import type { Browser, Page, BrowserContext } from '@playwright/test';
/**
 * Internal dependencies
 */
/**
 * Internal dependencies
 */
import { createNewPost } from '../../src/admin/create-new-post';
import type { PageUtils } from '../../src/page-utils';
declare type AdminConstructorProps = {
    page: Page;
    pageUtils: PageUtils;
};
export declare class Admin {
    browser: Browser;
    page: Page;
    pageUtils: PageUtils;
    context: BrowserContext;
    constructor({ page, pageUtils }: AdminConstructorProps);
    createNewPost: typeof createNewPost;
    getPageError: () => Promise<string | null>;
    visitAdminPage: (adminPath: string, query: string) => Promise<void>;
    visitSiteEditor: (query: import("../../src/admin/visit-site-editor").SiteEditorQueryParams, skipWelcomeGuide?: boolean | undefined) => Promise<void>;
}
export {};
//# sourceMappingURL=index.d.ts.map