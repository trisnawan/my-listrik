const { test, expect } = require("@playwright/test");

test("login form works correctly", async ({ page }) => {
    await page.goto("http://localhost:8080/account/login");

    await page.fill('input[name="email"]', "halo.trisnasejati@gmail.com");
    await page.fill('input[name="password"]', "rindu");
    await page.click('button[type="submit"]');

    // Tunggu redirect dan cek konten
    await expect(page).toHaveURL(/.*account.*/);
    await expect(page.locator("body")).toContainText("Profile");
});
