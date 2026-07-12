import { test as setup, expect } from '@playwright/test';
import { mkdirSync } from 'node:fs';

const AUTH_FILE = '.auth/admin.json';

setup('authenticate as admin', async ({ page }) => {
  mkdirSync('.auth', { recursive: true });

  await page.goto('/user/login');
  await page.getByLabel('Username').fill('admin');
  await page.getByLabel('Password').fill('admin');
  await page.getByRole('button', { name: 'Log in' }).click();

  // The /user page redirects to /user/1 on successful login.
  await page.waitForURL(/\/user\/\d+/);
  await expect(page.getByText(/member for/i)).toBeVisible();

  await page.context().storageState({ path: AUTH_FILE });
});
