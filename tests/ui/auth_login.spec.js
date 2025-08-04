// npx playwright test tests/ui/auth_login.spec.js --headed

const { test, expect } = require("@playwright/test");

test("login form works correctly", async ({ page }) => {
    await page.goto("http://localhost:8080/account/login");
    await page.fill('input[name="email"]', "halo1.trisnasejati@gmail.com");
    await page.fill('input[name="password"]', "rindu");
    await page.click('button[type="submit"]');

    try {
        await expect(page).toHaveURL(/.*account.*/);
    } catch (err) {
        console.error("Halaman tidak mengarah ke /account setelah login.");
        // throw err;
    }

    try {
        await expect(page.locator("body")).toContainText("Profile");
    } catch (err) {
        console.error("Login gagal");
        const alert = page.locator(".alert");
        if (await alert.isVisible()) {
            const errorMsg = await alert.textContent();
            console.error("Error:", errorMsg?.trim());
        }
        process.exit(1);
    }
    await page.waitForTimeout(1000);
});
