# Bricks Code Box - WordPress Plugin

Ein **WordPress-Plugin** für den **Bricks Builder**, das ein **Code Box**-Element (Snippet-Box) hinzufügt – mit Syntax-Highlighting, Copy-Button, Zeilennummern, Dark/Light-Theme, optionalem Titel/Dateiname und weiteren Komfortfeatures.

**Short English summary**: A WordPress plugin for Bricks Builder that adds a "Code Box" element with syntax highlighting, copy-to-clipboard, line numbers, theming, and more. Ships with optional PUC-based auto-updates from GitHub.

---

## ✨ Features

- **Bricks-Element „Code Box“**
  - Sprache auswählbar (z. B. HTML, CSS, JS, PHP, JSON, YAML, …)
  - **Syntax-Highlighting** (Prism.js)
  - **Copy-to-Clipboard**-Button (mit ARIA-Label & Feedback)
  - **Zeilennummern** (optional)
  - **Dark/Light-Theme** umschaltbar
  - **Titel/Dateiname** (optional) mit Icon
  - **Zeilenumbruch** umschaltbar (Wrap/No-Wrap)
  - **Max-Höhe** mit Scroll (optional)
  - **Kollabierbar** (optional: auf/zu)
- **Saubere Bricks-Integration**
  - Eigene Kategorie „Bricks Code Box“
  - Control-Gruppen für Inhalt, Darstellung, Verhalten
- **Barrierearm**
  - Fokuszustände, Screenreader-Labels, Button-Keyboard-Support
- **Auto-Updates (optional)**
  - via **Plugin Update Checker (PUC)** direkt aus diesem GitHub-Repo

---

## 🔧 Voraussetzungen

- **WordPress** ≥ 6.0 (WordPress-Installation erforderlich)
- **Bricks Builder** ≥ 1.9.x (Bricks Theme oder Plugin)
- **PHP** ≥ 7.4 (empfohlen: 8.1+)

---

## 📦 Installation

### Variante A: ZIP (empfohlen)
1. Latest Release von GitHub als ZIP herunterladen.
2. In **WordPress Admin**: **Plugins → Installieren → Plugin hochladen**.
3. Plugin aktivieren.
4. In **Bricks Builder** das neue "Code Box"-Element verwenden.

> **Wichtig:** Der Plugin-Ordner sollte `bricks-code-box/` heißen und die Hauptdatei `bricks-code-box.php` enthalten.

### Variante B: Git-Clone
```bash
cd wp-content/plugins
git clone https://github.com/DEINUSER/bricks-code-box.git bricks-code-box
