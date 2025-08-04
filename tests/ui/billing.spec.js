// npx playwright test tests/ui/billing.spec.js --headed

const { test, expect } = require("@playwright/test");

test("login form works correctly", async ({ page }) => {
    await page.goto("http://localhost:8080/account/login");
    await page.fill('input[name="email"]', "admin@trisnawan.com");
    await page.fill('input[name="password"]', "rindu");
    await page.click('button[type="submit"]');

    await expect(page).toHaveURL(/.*account.*/);
    await page.goto("http://localhost:8080/customer");
    await page
        .locator("table tbody tr")
        .nth(0)
        .locator("a.btn-outline-primary")
        .click();
    await page.waitForTimeout(500);

    await expect(page.locator("#tagihanModal")).toBeVisible();
    await page.selectOption('select[name="month"]', "04");
    await page.fill('input[name="year"]', "2025");
    await page.fill('input[name="meter_start"]', "350");
    await page.fill('input[name="meter_end"]', "648");

    const modal = page.locator("#tagihanModal");
    await modal.locator('button[type="submit"]').click();

    await expect(page).toHaveURL(/.*billing.*/);
    await page.waitForTimeout(5000);
});
