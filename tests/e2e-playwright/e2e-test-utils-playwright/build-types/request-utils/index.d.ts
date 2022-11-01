/// <reference types="node" />
import type { APIRequestContext, Cookie } from '@playwright/test';
import type { User } from '../../src/request-utils/login';
import { rest, batchRest } from '../../src/request-utils/rest';
import { deleteAllBlocks } from '../../src/request-utils/blocks';
import { deleteAllPosts } from '../../src/request-utils/posts';
import { deleteAllWidgets, addWidgetBlock } from '../../src/request-utils/widgets';
interface StorageState {
    cookies: Cookie[];
    nonce: string;
    rootURL: string;
}
declare class RequestUtils {
    request: APIRequestContext;
    user: User;
    maxBatchSize?: number;
    storageState?: StorageState;
    storageStatePath?: string;
    baseURL?: string;
    pluginsMap: Record<string, string> | null;
    static setup({ user, storageStatePath, baseURL, }: {
        user?: User;
        storageStatePath?: string;
        baseURL?: string;
    }): Promise<RequestUtils>;
    constructor(requestContext: APIRequestContext, { user, storageState, storageStatePath, baseURL, }?: {
        user?: User;
        storageState?: StorageState;
        storageStatePath?: string;
        baseURL?: string;
    });
    login: (user?: User | undefined) => Promise<string>;
    setupRest: () => Promise<StorageState>;
    rest: typeof rest;
    getMaxBatchSize: (forceRefetch?: boolean | undefined) => Promise<number>;
    batchRest: typeof batchRest;
    getPluginsMap: (forceRefetch?: boolean | undefined) => Promise<Record<string, string>>;
    activatePlugin: (slug: string) => Promise<void>;
    deactivatePlugin: (slug: string) => Promise<void>;
    activateTheme: (themeSlug: string) => Promise<void>;
    deleteAllBlocks: typeof deleteAllBlocks;
    deleteAllPosts: typeof deleteAllPosts;
    createComment: (payload: import("../../src/request-utils/comments").CreateCommentPayload) => Promise<import("../../src/request-utils/comments").Comment>;
    deleteAllComments: () => Promise<void>;
    deleteAllWidgets: typeof deleteAllWidgets;
    addWidgetBlock: typeof addWidgetBlock;
    deleteAllTemplates: (type: "wp_template" | "wp_template_part") => Promise<void>;
    resetPreferences: () => Promise<void>;
    listMedia: () => Promise<import("../../src/request-utils/media").Media[]>;
    uploadMedia: (filePathOrData: string | import("fs").ReadStream) => Promise<import("../../src/request-utils/media").Media>;
    deleteMedia: (mediaId: number) => Promise<any>;
    deleteAllMedia: () => Promise<any[]>;
}
export type { StorageState };
export { RequestUtils };
//# sourceMappingURL=index.d.ts.map