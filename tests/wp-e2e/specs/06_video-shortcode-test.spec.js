/**
 * WordPress dependencies
 */
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');


test.describe('Validate Video shortcode', () => {
    test.beforeEach(async ({ admin }) => {
        await admin.visitAdminPage("nav-menus.php");
    });
    test('Check Video-shortcode', async ({admin, page, pageUtils }) => {
        // Get short code
        await admin.visitAdminPage('upload.php');
        await page.locator('role=checkbox[name="video"i]').click()
        //Get input value
        const inPutVal = await page.locator('role=textbox[name="File URL:"i]').inputValue();
        const Code = `[audio src="${inPutVal}"]`

        await admin.visitAdminPage("nav-menus.php");
        //Expand Shortcode
        await page.locator("a[class='item-edit'][id*='edit-']").nth(1).click();
    
        //Add Proper title
        await page.locator("textarea[id*='menu-item-custom-text-']").nth(1).click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.keyboard.type('Video code');

        //checkbox
        await page.locator("input[id*='menu-item-selected-feature-radio-shortcode-']").nth(1).check();

        //Add New short code
        await page.locator("input[id*='menu-item-shortcode-']").nth(1).click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.locator("input[id*='menu-item-shortcode-']").nth(1).fill(Code)

        // Caption.
        await page.locator("textarea[id*='menu-item-shortcode-caption-']").nth(1).click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.locator("textarea[id*='menu-item-shortcode-caption-']").nth(1).fill("Video caption")

        // Click text=Main Menu has been updated.
        await page.locator("role=button[name='Save Menu'i]").click();
        await expect(page.locator("#message")).not.toBeNull();

        await Promise.all([
            page.click("#wp-admin-bar-site-name > a"),
            //page.click("#wp-admin-bar-view-site > a")
        ]);

        //Verify Frontend
        await page.locator("li[id*='menu-item-']").first().hover();
        const tweets = page.locator("div[class='rt-wp-menu-custom-fields-wrapper']");
        await expect(tweets).not.toBeNull();
    });

});