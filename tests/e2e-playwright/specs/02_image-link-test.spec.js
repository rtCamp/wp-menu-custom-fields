/**
 * WordPress dependencies
 */
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');
const ImageLink = "https://i.picsum.photos/id/418/200/300.jpg?hmac=T7cC_OCVJnIk98mcvhuKBWancCeGl2KcyuSBTCYE-QM"

test.describe('Validate Imagelink', () => {
    test.beforeEach(async ({ admin }) => {
        await admin.visitAdminPage("nav-menus.php");
    });
    test('Check Image-Link', async ({ page, pageUtils }) => {
        //Expand Featured Image
        await page.locator("a[class='item-edit'][id*='edit-']").nth(1).click();
        //Add Proper title
        await page.locator("textarea[id*='menu-item-custom-text-']").nth(1).click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.keyboard.type('Image-Link');

        //checkbox
        await page.locator("input[id*='menu-item-selected-feature-radio-image-']").nth(1).check();

        //Add Image Link
        await page.locator("input[id*='menu-item-media-link-']").nth(1).click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.locator("input[id*='menu-item-media-link-']").nth(1).fill(ImageLink);

        // Caption.
        await page.locator("textarea[id*='menu-item-media-caption-']").nth(1).click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.locator("textarea[id*='menu-item-media-caption-']").nth(1).fill("Caption")

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