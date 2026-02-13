import { defineConfig } from 'vite';
import injectHTML from 'vite-plugin-html-inject';
import { resolve } from 'path';

export default defineConfig({
    base: './',
    plugins: [
        injectHTML({
            tagName: 'include', // 將原本的 load 改為 include
        }), // 啟用 HTML 分段功能
    ],
    build: {
        rollupOptions: {
            input: {
                main: resolve(__dirname, 'index.html'),
                //
                news: resolve(__dirname, 'news.html'),
                // 認識協會
                about: resolve(__dirname, 'about.html'),
                organization: resolve(__dirname, 'organization.html'),
                member: resolve(__dirname, 'member.html'),
                bylaw: resolve(__dirname, 'bylaw.html'),
                minutes: resolve(__dirname, 'minutes.html'),
                meetings_detail: resolve(__dirname, 'meetings_detail.html'),


                //專業服務
            },
        },
    },
    server: {
        port: 3000, // 或是你喜歡的 port
        open: true  // 自動開啟瀏覽器
    }
});