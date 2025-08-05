// npx playwright test tests/ui/auth_register.spec.js --headed

const { test, expect } = require("@playwright/test");

test("register form works correctly", async ({ page }) => {
    await page.goto("http://localhost:8080/account/register");

    await page.fill('input[name="full_name"]', "Trisnawan");
    await page.fill('input[name="email"]', "baru.trisnasejati@gmail.com");
    await page.fill('input[name="password"]', "rindu");
    await page.fill('input[name="password_conf"]', "rindu");
    await page.click('button[type="submit"]');

    // Tunggu redirect dan cek konten
    await expect(page).toHaveURL(/.*account.*/);
    await page.waitForTimeout(2000);
    await expect(page.locator("body")).toContainText("Profile");
    await page.waitForTimeout(3000);
});
