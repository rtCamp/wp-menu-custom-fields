/**
 * Internal dependencies
 */
import type { RequestUtils } from '../../src/request-utils/index';
export interface User {
    username: string;
    password: string;
}
declare function login(this: RequestUtils, user?: User): Promise<string>;
export { login };
//# sourceMappingURL=login.d.ts.map