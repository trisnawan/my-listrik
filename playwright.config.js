// npx playwright test tests/ui/login.spec.js
const { defineConfig } = require("@playwright/test");

module.exports = defineConfig({
    use: {
        video: "on", // rekam semua test
    },
    testDir: "tests/ui",
});
