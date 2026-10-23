import { test, expect } from '@playwright/test';

// Shared setup: every test in this file starts logged in as the admin user.
// Moving the login into a beforeEach hook keeps the individual tests focused
// on what they are actually asserting.
test.beforeEach(async ({ page }) => {
  await page.goto('/user/login');
  await page.getByLabel('Username').fill('admin');
  await page.getByLabel('Password').fill('admin');
  await page.getByRole('button', { name: 'Log in' }).click();
  await expect(page).toHaveURL(/\/user\/\d+/);
});

test.describe('Content administration listing', () => {

  test('the content overview page loads', async ({ page }) => {
    await page.goto('/admin/content');
    await expect(page.locator('h1')).toContainText('Content');
    // The content table is present.
    await expect(page.locator('table')).toBeVisible();
  });

  test('the content type filter narrows the listing', async ({ page }) => {
    await page.goto('/admin/content');

    // Drive the "Content type" <select> filter with selectOption(), then
    // submit the exposed filter form.
    await page.getByLabel('Content type').selectOption('page');
    await page.getByRole('button', { name: 'Filter' }).click();

    // The listing reloads with the type filter applied.
    await expect(page).toHaveURL(/type=page/);
    await expect(page.locator('h1')).toContainText('Content');
  });

});
