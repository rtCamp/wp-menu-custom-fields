/**
 * WordPress dependencies
 */
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');


test.describe('Validate Custom HTML', () => {
    test.beforeEach(async ({ admin }) => {
        await admin.visitAdminPage("nav-menus.php");
    });
    test('Check custom html', async ({ page }) => {

        //Expand Custom html
        await page.locator("a[class='item-edit'][id='edit-26']").click();
        //Add Proper title
        await page.locator("textarea[class='widefat menu-item-custom-text-26']").click();
        await page.locator("textarea[class='widefat menu-item-custom-text-26']").fill('Validate');
        //checkbox
        await page.locator('#menu-item-selected-feature-radio-html-26').check(); 

        // Select text Visual
        await page.waitForSelector("#menu-item-custom-html-26-tmce");
        //Write on the frame
        const textarea = page.frameLocator('#menu-item-custom-html-26_ifr').locator("#tinymce")
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
        await page.locator('#menu-item-29 > button').hover();
        const tweets = page.locator("#menu-item-26 > div > span");
        await expect(tweets).toHaveClass("rt-wp-menu-custom-fields-custom-text");
      
    });

});