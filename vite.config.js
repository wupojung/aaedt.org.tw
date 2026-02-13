import {defineConfig} from 'vite';
import injectHTML from 'vite-plugin-html-inject';
import {resolve} from 'path';

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
                remodeling: resolve(__dirname, 'remodeling.html'),  //環境改造
                inspection: resolve(__dirname, 'inspection.html'),  //環境檢測
                workshop: resolve(__dirname, 'workshop.html'),  //體驗工作坊
                lectures: resolve(__dirname, 'lectures.html'),  //系列演講
                academic: resolve(__dirname, 'academic.html'),  //學術活動

                //推廣行動
                campaign: resolve(__dirname, 'campaign_overview.html'),  //推廣行動
                knowledge: resolve(__dirname, 'knowledge.html'),//知識分享
                practice: resolve(__dirname, 'practice.html'), //改善實務
                certification: resolve(__dirname, 'certification.html'), //標章認證
                results: resolve(__dirname, 'results.html'), //推廣成果


                //資源連結
                regulations: resolve(__dirname, 'regulations.html'),  //法規資訊
                guide: resolve(__dirname, 'guide.html'),//設計指南
                reference: resolve(__dirname, 'reference.html'), //參考資料
                faq: resolve(__dirname, 'faq.html'), //常見問題

                //加入我們
                join: resolve(__dirname, 'join.html'),  //成為會員
                volunteer: resolve(__dirname, 'volunteer.html'),//志工招募
                proposal: resolve(__dirname, 'proposal.html'), //合作提案
                donate: resolve(__dirname, 'donate.html'), //捐款支持
            },
        },
    },
    server: {
        port: 3000, // 或是你喜歡的 port
        open: true  // 自動開啟瀏覽器
    }
});