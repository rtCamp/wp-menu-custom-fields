/**
 * WordPress dependencies
 */
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');
const ShortCode = '[video src="https://alvi-tazwar.rt.gw/wp-content/uploads/2022/10/https___handbook.rt_.gw_.mp4"]'


test.describe('Validate Video shortcode', () => {
    test.beforeEach(async ({ admin }) => {
        await admin.visitAdminPage("nav-menus.php");
    });
    test('Check Video-shortcode', async ({ page, pageUtils }) => {

        //Expand Video shortcode
        await page.locator("a[class='item-edit'][id='edit-27']").click();

        //Add Proper title
        await page.locator("textarea[id='menu-item-custom-text-27']").click();
        await page.keyboard.type('Video Shortcode');
       // await page.locator("textarea[id='menu-item-custom-text-24]']").fill('Validate');
        
        //checkbox
        await page.locator('#menu-item-selected-feature-radio-shortcode-27').check(); 

    
        //Add Shortcode
        await page.locator("#menu-item-shortcode-27").click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.locator("#menu-item-shortcode-27").fill(ShortCode)

        // Caption.
        await page.locator("#menu-item-shortcode-caption-27").click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.locator("#menu-item-shortcode-caption-27").fill("Caption")
    
        // Click text=Main Menu has been updated.
        await page.locator("role=button[name='Save Menu'i]").click();
        await expect(page.locator("#message")).not.toBeNull();

        await Promise.all([
            page.click("#wp-admin-bar-site-name > a"),
            //page.click("#wp-admin-bar-view-site > a")
        ]);
    
        //Verify Frontend
        await page.locator('#menu-item-31 > button').hover();
        const tweets = page.locator("#menu-item-27 > div > div > span");
        await expect(tweets).toHaveClass("rt-wp-menu-custom-fields-shortcode-caption");
      
    });

});