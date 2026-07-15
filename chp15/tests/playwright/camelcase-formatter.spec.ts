import { test, expect } from '@playwright/test';

test.describe('CamelCase field formatter', () => {

  test('anonymous user can see formatted field value', async ({ page }) => {
    // Navigate to a node that has the CamelCase formatter applied.
    await page.goto('/node/1');

    // Assert that the page loaded successfully.
    await expect(page).toHaveTitle(/Test Page/);

    // Assert that the camelCase formatted value is visible on the page.
    await expect(page.locator('body')).toContainText('aUserEnteredString');
  });

});
