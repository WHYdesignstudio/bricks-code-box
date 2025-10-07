# Bricks Code Box Widget

Ein leichtgewichtiges Bricks-Addon, das ein **Code Box**-Element (Snippet-Box) zu den Bricks-Widgets hinzufügt – mit Syntax-Highlighting, Copy-Button, Zeilennummern, Dark/Light-Theme, optionalem Titel/Dateiname und weiteren Komfortfeatures.

**Short English summary**: A small Bricks addon that adds a “Code Box” element with syntax highlighting, copy-to-clipboard, line numbers, theming, and more. Ships with optional PUC-based auto-updates from GitHub.

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

- **WordPress** ≥ 6.0  
- **Bricks Builder** ≥ 1.9.x  
- **PHP** ≥ 7.4 (empfohlen: 8.1+)

---

## 📦 Installation

### Variante A: ZIP (empfohlen)
1. Latest Release von GitHub als ZIP herunterladen.
2. In WordPress: **Plugins → Installieren → Plugin hochladen**.
3. Aktivieren.

> **Wichtig:** Der Plugin-Ordner sollte `bricks-code-box/` heißen und die Hauptdatei `bricks-code-box.php` enthalten.

### Variante B: Git-Clone
```bash
cd wp-content/plugins
git clone https://github.com/DEINUSER/bricks-code-box.git bricks-code-box
