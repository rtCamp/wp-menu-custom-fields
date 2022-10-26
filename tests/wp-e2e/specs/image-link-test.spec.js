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
        await page.locator("a[class='item-edit'][id='edit-24']").click();

        //Add Proper title
        await page.locator("textarea[id='menu-item-custom-text-24']").click();
        await page.keyboard.type('Image-Link');
       // await page.locator("textarea[id='menu-item-custom-text-24]']").fill('Validate');
        
        //checkbox
        await page.locator('#menu-item-selected-feature-radio-image-24').check(); 

    
        //Add Image Link
        await page.locator("#menu-item-media-link-24").click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.locator("#menu-item-media-link-24").fill(ImageLink)

        // Caption.
        await page.locator("#menu-item-media-caption-24").click();
        await pageUtils.pressKeyWithModifier('primary', 'a');
        await page.keyboard.press('Delete');
        await page.locator("#menu-item-media-caption-24").fill("Caption")
    
        // Click text=Main Menu has been updated.
        await page.locator("role=button[name='Save Menu'i]").click();
        await expect(page.locator("#message")).not.toBeNull();

        await Promise.all([
            page.click("#wp-admin-bar-site-name > a"),
            //page.click("#wp-admin-bar-view-site > a")
        ]);
    
        //Verify Frontend
        await page.locator('#menu-item-31 > button').hover();
        const tweets = page.locator("#menu-item-24 > div > div > span");
        await expect(tweets).toHaveClass("rt-wp-menu-custom-fields-image-caption");
      
    });

});