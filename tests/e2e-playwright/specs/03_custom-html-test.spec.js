/**
 * WordPress dependencies
 */
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');


test.describe('Validate Custom HTML', () => {
    test.beforeEach(async ({ admin }) => {
        await admin.visitAdminPage("nav-menus.php");
    });
    test('Check custom html', async ({ page,pageUtils }) => {

        //Expand Custom Html
        await page.locator("a[class='item-edit'][id*='edit-']").nth(1).click();

        //Add Proper title
        await page.locator("textarea[id*='menu-item-custom-text-']").nth(1).click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.keyboard.type('Custom HTML');

        //checkbox
        await page.locator("input[id*='menu-item-selected-feature-radio-html-']").nth(1).check();
        //Write on the frame
        const textarea = page.frameLocator("[id$='_ifr']").locator("#tinymce")
        await textarea.fill('Bold')
        await expect(textarea).toHaveText('Bold')
        await page.locator("role=button[name='Save Menu'i]").click();
        await expect(page.locator("#message")).not.toBeNull();
    
        // Click text=Main Menu has been updated.
       await page.locator('text=Main Menu has been updated.').click();
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