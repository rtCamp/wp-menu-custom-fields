/**
 * WordPress dependencies
 */
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');


test.describe('Validate Feature Image', () => {
    test.beforeEach(async ({ admin }) => {
        await admin.visitAdminPage("nav-menus.php");
    });
    test('Check Feature Image', async ({ page, pageUtils }) => {

        //Expand Featured Image
        await page.locator("a[class='item-edit'][id*='edit-']").nth(1).click();

        //Add Proper title
        await page.locator("textarea[id*='menu-item-custom-text-']").nth(1).click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.keyboard.type('Feature Image');
        //checkbox
        await page.locator("input[id*='menu-item-selected-feature-radio-image-']").nth(1).check();
        //Select image
        await page.locator("button[id*='custom-field-select-image-']").nth(1).click();
        await page.locator("role=tab[name='Media Library'i]").click();
        const selectBtn = page.locator('role=button[name="Select"i]');
        if (selectBtn.isDisabled()) {
            await page.locator('div[class="thumbnail"]').click();
        }
        else {
            await page.locator('role=button[name="Select"i]').click();
        }
        await page.locator('role=button[name="Select"i]').click();

        // Featured Image Caption.
        await page.locator("textarea[id*='menu-item-media-caption-']").nth(1).click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.locator("textarea[id*='menu-item-media-caption-']").nth(1).fill("Featured ImageCaption")

        // Click text=Main Menu has been updated.
        await page.locator("role=button[name='Save Menu'i]").click();
        await expect(page.locator("#message")).not.toBeNull();

        await Promise.all([
            page.click("#wp-admin-bar-site-name > a"),
        ]);

        //Verify Frontend
        await page.locator("li[id*='menu-item-']").first().hover();
        const tweets = page.locator("div[class='rt-wp-menu-custom-fields-wrapper']");
        await expect(tweets).not.toBeNull();

    });

});