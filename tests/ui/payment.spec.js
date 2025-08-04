// npx playwright test tests/ui/payment.spec.js --headed

const { test, expect } = require("@playwright/test");

test("login form works correctly", async ({ page }) => {
    await page.goto("http://localhost:8080/account/login");
    await page.fill('input[name="email"]', "halo.trisnasejati@gmail.com");
    await page.fill('input[name="password"]', "rindu");
    await page.click('button[type="submit"]');

    await expect(page).toHaveURL(/.*account.*/);
    await page.goto("http://localhost:8080/billing");
    await page
        .locator("table tbody tr")
        .nth(0)
        .locator("a.btn-primary")
        .click();
    await expect(page).toHaveURL(/.*payment.*/);

    await page.locator("a.btn-primary").scrollIntoViewIfNeeded();
    await page.waitForTimeout(1000);
    await page.locator("a.btn-primary").click();
    await expect(page).toHaveURL(/.*web.*/);

    await page
        .locator("div.w-full")
        .locator("button[type=button]")
        .nth(2)
        .click();
    await page.waitForTimeout(1000);
    await page
        .locator("div.w-full")
        .locator("button[type=button]")
        .nth(3)
        .click();

    await page.waitForTimeout(5000);
});
