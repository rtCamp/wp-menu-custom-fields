/**
 * WordPress dependencies
 */
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');

test.describe('Prepare Test scenario', () => {
    test.beforeEach(async ({ admin }) => {
        await admin.visitAdminPage('nav-menus.php');
    });
    test('Perform Scenario creation for tests', async ({ admin, page, editor }) => {
        // Create a new Menu
        await page.locator('input[name="menu-name"]').fill('Main Menu');

        await page.locator('role=button[name="Create Menu"i]').click();
        // Add pages to menu
        await page.locator('.menu-item-title').first().check();
        await page.locator('role=button[name="Add to Menu"i]').click();
        //validate add
        const item = page.locator("li[class='menu-item menu-item-depth-0 menu-item-page menu-item-edit-inactive pending']");
        await expect(item).toBeVisible();
        // Add Posts to menu
        await page.locator("#add-post-type-post > h3").click();
        await page.locator('role=checkbox[name="Hello world!"i]').first().check();
        await page.locator('role=button[name="Add to Menu"i]').click();
        // DRAG AND DROP
        // select element
        const srcElement = page.locator('text=Hello world! sub item Post ↑ | ↓ Edit');
        const box = await srcElement.boundingBox();
        if (srcElement) {
            await page.mouse.click(box.x + box.width / 2, box.y + box.height / 2);
            await page.mouse.down("left")
            await page.mouse.move(box.x + box.width + 2, box.y + box.height + 2)
            await page.mouse.click(box.x + box.width + .5, box.y + box.height + .5)
            await page.locator("#locations-primary").check();
            await page.locator('role=button[name="Save Menu"i]').click();
            // Double Check for Save Menu
        }
        else { console.log("No element") }
    });

    test('Upload image', async ({ admin, page }) => {
        await admin.visitAdminPage("media-new.php")
        const imgPath = "assets/image.jpeg";
        //await page.locator('#__wp-uploader-id-1').click();
        const [fileChooser] = await Promise.all([
            // It is important to call waitForEvent before click to set up waiting.
            page.waitForEvent('filechooser'),
            // Opens the file chooser.
            page.locator('#plupload-browse-button').click(),
        ])
        await fileChooser.setFiles([
            imgPath
        ])

        const item = await page.locator("#wpbody-content > div.wrap > h1");
        await expect(item).toBeVisible();
    });
    test('Upload video', async ({ admin, page, editor }) => {
        await admin.visitAdminPage("media-new.php")
        const videoPath = "assets/video.mp4";
        const [fileChooser] = await Promise.all([
            // It is important to call waitForEvent before click to set up waiting.
            page.waitForEvent('filechooser'),
            // Opens the file chooser.
            page.locator('#plupload-browse-button').click(),
        ])
        await fileChooser.setFiles([
            videoPath,
        ])
        const item = await page.locator("#wpbody-content > div.wrap > h1");
        await expect(item).toBeVisible();
    });
    test('Upload audio', async ({ admin, page, editor }) => {
        await admin.visitAdminPage("media-new.php")
        const audioPath = "assets/audio.mp3";
        const [fileChooser] = await Promise.all([
            // It is important to call waitForEvent before click to set up waiting.
            page.waitForEvent('filechooser'),
            // Opens the file chooser.
            page.locator('#plupload-browse-button').click(),
        ])
        await fileChooser.setFiles([
            audioPath,
        ])
        const item = await page.locator("#wpbody-content > div.wrap > h1");
        await expect(item).toBeVisible();
    });
});