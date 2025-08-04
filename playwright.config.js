const { defineConfig } = require("@playwright/test");

module.exports = defineConfig({
    use: {
        video: "on", // rekam semua test
        launchOptions: {
            slowMo: 500, // Perlambat aksi 500ms (global) - seperti slow motion
        },
    },
    testDir: "tests/ui",
});
