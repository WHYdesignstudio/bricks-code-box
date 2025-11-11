# Bricks Code Box - WordPress Plugin

A **WordPress plugin** for **Bricks Builder** that adds a **Code Box** element (snippet box) with syntax highlighting, copy button, line numbers, dark/light theme, optional title/filename, and more convenience features.

---

## ✨ Features

- **Bricks Element "Code Box"**
  - Selectable language (e.g., HTML, CSS, JS, PHP, JSON, YAML, …)
  - **Syntax Highlighting** (Prism.js)
  - **Copy-to-Clipboard** button (with ARIA labels & feedback)
  - **Line numbers** (optional)
  - **Dark/Light theme** toggleable
  - **Title/Filename** (optional) with icon
  - **Line wrap** toggleable (Wrap/No-Wrap)
  - **Max height** with scroll (optional)
  - **Collapsible** (optional: expand/collapse)
- **Clean Bricks Integration**
  - Own category "Bricks Code Box"
  - Control groups for content, display, behavior
- **Accessible**
  - Focus states, screen reader labels, button keyboard support
- **Auto-Updates (optional)**
  - via **Plugin Update Checker (PUC)** directly from this GitHub repo

---

## 🔧 Requirements

- **WordPress** ≥ 6.0 (WordPress installation required)
- **Bricks Builder** ≥ 1.9.x (Bricks Theme or Plugin)
- **PHP** ≥ 7.4 (recommended: 8.1+)

---

## 📦 Installation

### Option A: Create ZIP file and upload (recommended)
1. **Download repository:**
   - GitHub: **Code → Download ZIP** (or clone repository)
   - Extract the ZIP file locally
2. **Create ZIP file for WordPress:**
   - Navigate to the extracted folder (should be named `bricks-code-box-main` or similar)
   - **Important:** Create a ZIP file from the **contents** of the folder
   - The ZIP must result in the folder `bricks-code-box/` when extracted
   - Structure should be: `bricks-code-box/bricks-code-box.php`, `bricks-code-box/elements/`, etc.
3. **Upload to WordPress:**
   - **WordPress Admin** → **Plugins → Install → Upload Plugin**
   - Select and upload your created ZIP file
4. **Activate plugin:**
   - Activate the plugin
   - Use the new "Code Box" element in **Bricks Builder**
