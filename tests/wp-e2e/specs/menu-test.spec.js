/**
 * WordPress dependencies
 */
const { test, expect } = require('@wordpress/e2e-test-utils-playwright');


test.describe('Add and Remove Menu', () => {
    test.beforeEach(async ({ admin }) => {
        await admin.visitAdminPage("nav-menus.php");
    });
    test('Should add a new menu and remove elements from the menu and Delete the menu', async ({ page }) => {

        // Create a new Menu
        await page.locator('a:has-text("create a new menu")').click();
        await page.locator('input[name="menu-name"]').fill('Test' + Math.random());

        await page.locator('role=button[name="Create Menu"i]').click();

        // Add new page to menu
        await page.locator('.menu-item-title').first().check();
        await page.locator('role=button[name="Add to Menu"i]').click();

        // Save Menu
        await page.locator('role=button[name="Save Menu"i]').click();

        // Double Check for Save Menu
        await page.locator('text=Delete Menu Save Menu >> input[name="save_menu"]').click();

        // A message should show up
        await expect(page.locator('#message > p')).toHaveText(/has been updated./);

        // Remove Existing Item
        await page.locator('role=checkbox[name="Bulk Select"i]').first().click();
        await page.locator('text=Remove Selected Items').click();

        // A message should show up
        await expect(page.locator('#message > p')).toHaveText(/has been updated./);

        //Accept Alert
        page.on('dialog', async (dialog) => {
            await dialog.accept()
        })

        // Delete The menu
        await page.locator('role=link[name="Delete Menu"i]').click();


        // A message should show up
        await expect(page.locator('#message > p')).toHaveText('The menu has been successfully deleted.');

    });


});