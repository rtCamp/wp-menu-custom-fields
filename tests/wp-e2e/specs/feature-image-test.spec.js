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
        await page.locator("a[class='item-edit'][id='edit-25']").click();

        //Add Proper title
        await page.locator("textarea[id='menu-item-custom-text-25']").click();
        await page.keyboard.type('Feature Image');
       // await page.locator("textarea[id='menu-item-custom-text-24]']").fill('Validate');
        
        //checkbox
        await page.locator('#menu-item-selected-feature-radio-image-25').check(); 

        //Select image
        await page.locator("#custom-field-select-image-25").click();
        await page.locator('div[class="thumbnail"]').dblclick();
        await page.locator('role=button[name="Select"i]').dblclick();

        // Caption.
        await page.locator("#menu-item-media-caption-25").click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.locator("#menu-item-media-caption-25").fill("Caption-Feature Image")
    
        // Click text=Main Menu has been updated.
        await page.locator("role=button[name='Save Menu'i]").click();
        await expect(page.locator("#message")).not.toBeNull();

        await Promise.all([
            page.click("#wp-admin-bar-site-name > a"),
            //page.click("#wp-admin-bar-view-site > a")
        ]);
    
        //Verify Frontend
        await page.locator('#menu-item-30 > button').hover();
        const tweets = page.locator("#menu-item-25 > div > div > span");
        await expect(tweets).toHaveClass("rt-wp-menu-custom-fields-image-caption");
      
    });

});