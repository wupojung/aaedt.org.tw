import { defineConfig } from 'vite';
import injectHTML from 'vite-plugin-html-inject';

export default defineConfig({
    base: './',
    plugins: [
        injectHTML({
            tagName: 'include', // 將原本的 load 改為 include
        }), // 啟用 HTML 分段功能
    ],
    server: {
        port: 3000, // 或是你喜歡的 port
        open: true  // 自動開啟瀏覽器
    }
});