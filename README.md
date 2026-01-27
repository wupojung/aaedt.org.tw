# AAEDT 專案：現代化網頁開發與佈景原型環境

這是一個基於 **Vite** 構建的高性能靜態網頁開發環境。本專案透過組件化（Component-based）的開發思維，解決了傳統多頁面網頁在處理重複內容（如 Header、Footer）時的維護痛點，並導入了專業的 CI/CD 自動化部署流程。

## 🚀 技術特性

* **Vite 引擎**：利用原生 ESM 特性，提供極速的熱更新（HMR）開發體驗。
* **HTML 組件化注入**：採用 `vite-plugin-html-inject` 插件，實現 `<include src="..." />` 標籤式片段管理，讓程式碼更具可讀性與維護性。
* **多頁面系統 (MPA)**：支援 `index.html` 與 `member.html` 等多個入口頁面，並透過單一 `src/main.js` 進行資源總控。
* **GitHub Actions 自動化部署**：配置完備的 CI 工作流，代碼推送到 `master` 分支後即自動構建並發布至 GitHub Pages。
* **智慧開發環境優化**：針對 WebStorm/PHPStorm 進行路徑分析與無障礙（Accessibility）檢查優化。

## 📁 專案架構說明

```text
.
├── .github/workflows/    # GitHub Actions 自動部署腳本
├── public/               # 靜態資源（不經 Vite 編譯，如 favicon、內容圖片）
│   └── img/              # 存放網站圖片資源
├── src/                  # 原始碼目錄
│   ├── assets/           # 需要編譯的資源（CSS, 字體, 小圖）
│   ├── partials/         # HTML 組件片段（Header, Footer）
│   ├── scripts/          # JavaScript 邏輯模組
│   └── main.js           # 專案總入口（指揮中心）
├── index.html            # 首頁
├── member.html           # 會員中心頁
├── vite.config.js        # Vite 設定檔（包含多頁面與路徑處理）
└── package.json          # 專案套件設定
```

## 🛠️ 開發指南

### 1. 環境需求
請確保您的開發環境已安裝 **Node.js** (建議版本 v18.0.0 以上)。

### 2. 安裝依賴套件
```bash
npm install
```

### 3. 啟動開發模式
啟動後會提供一個本地網址，支持存檔即時更新：
```bash
npm run dev
```

### 4. 生產環境打包
將原始碼編譯、壓縮並優化至 ```/dist``` 資料夾，準備發布：
```bash
npm run build
```

### 5. 本地預覽打包結果
在正式上傳前，模擬生產環境的運行狀況：
```bash
npm run preview
```

## 💻 WebStorm / PHPStorm 開發建議

為了獲得最佳的 IDE 支援，建議手動進行以下調整：

* **資源根目錄設定**：在 `public` 資料夾點擊右鍵，選擇 **"Mark Directory as > Resource Root"**，確保圖片路徑偵測正確。
* **自定義標籤排除紅字**：針對 `<include />` 標籤，在紅線上按 `Alt + Enter` 選擇 **"Add include to custom html tags"**。
* **CSS 規範檢查**：定義 `font-family` 時請務必在末尾補上通用字體族（如 `sans-serif`），以通過 IDE 的格式檢查。

---

## 🌐 部署資訊

本專案配置了自動化 CI/CD 流程。每次將代碼 Push 至 **`master`** 分支時，GitHub Actions 會自動執行編譯與部署。

* **部署分支**：`gh-pages`
* **線上預覽連結**：[點擊前往 AAEDT 預覽網頁](https://wupojung.github.io/aaedt.org.tw/)

---

© 2026 AAEDT 專案 - 吳柏瀧 (Po-Lung,Wu)