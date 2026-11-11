import { test, expect } from '@playwright/test';

test.describe('Drupal authentication', () => {

  test('user can log in and access the admin dashboard', async ({ page }) => {
    await page.goto('/user/login');
    await page.getByLabel('Username').fill('admin');
    await page.getByLabel('Password').fill('admin');
    await page.getByRole('button', { name: 'Log in' }).click();
    await expect(page).toHaveURL(/\/user\/\d+/);
    await page.goto('/admin/content');
    await expect(page.locator('h1')).toContainText('Content');
  });

  test('user can create a new page node', async ({ page }) => {
    await page.goto('/user/login');
    await page.getByLabel('Username').fill('admin');
    await page.getByLabel('Password').fill('admin');
    await page.getByRole('button', { name: 'Log in' }).click();
    await page.goto('/node/add/page');
    await page.getByLabel('Title', { exact: true }).fill('Playwright Test Page');
    await page.getByRole('button', { name: 'Save' }).click();
    await expect(page.locator('h1')).toContainText('Playwright Test Page');
    await expect(page.locator('.messages--status')).toBeVisible();
  });

});

