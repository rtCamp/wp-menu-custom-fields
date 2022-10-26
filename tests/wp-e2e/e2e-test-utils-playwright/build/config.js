"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.WP_BASE_URL = exports.WP_PASSWORD = exports.WP_USERNAME = exports.WP_ADMIN_USER = void 0;
const WP_ADMIN_USER = {
    username: 'alvitazwar',
    password: 'alvi0052',
};
exports.WP_ADMIN_USER = WP_ADMIN_USER;
const { WP_USERNAME = WP_ADMIN_USER.username, WP_PASSWORD = WP_ADMIN_USER.password, WP_BASE_URL = 'https://alvi-tazwar.rt.gw/', } = process.env;
exports.WP_USERNAME = WP_USERNAME;
exports.WP_PASSWORD = WP_PASSWORD;
exports.WP_BASE_URL = WP_BASE_URL;
//# sourceMappingURL=config.js.map